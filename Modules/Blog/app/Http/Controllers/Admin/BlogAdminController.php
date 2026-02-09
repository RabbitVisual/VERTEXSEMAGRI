<?php

namespace Modules\Blog\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Blog\App\Models\BlogPost;
use Modules\Blog\App\Models\BlogCategory;
use Modules\Blog\App\Models\BlogTag;
use Modules\Blog\App\Models\BlogComment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class BlogAdminController extends Controller
{
    /**
     * Display blog dashboard
     */
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'status', 'category', 'author']);

        $query = BlogPost::with(['category', 'author', 'tags'])
            ->orderBy('created_at', 'desc');

        // Aplicar filtros
        if (!empty($filters['search'])) {
            $query->search($filters['search']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        if (!empty($filters['author'])) {
            $query->where('author_id', $filters['author']);
        }

        $posts = $query->paginate(20);

        // Estatísticas
        $estatisticas = $this->calcularEstatisticas();

        // Dados para filtros
        $categories = BlogCategory::active()->ordered()->get();
        $authors = \App\Models\User::whereHas('blogPosts')->get();

        return view('blog::admin.index', compact('posts', 'filters', 'estatisticas', 'categories', 'authors'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        $categories = BlogCategory::active()->ordered()->get();
        $tags = BlogTag::orderBy('name')->get();

        return view('blog::admin.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created post.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_posts,slug',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'category_id' => 'required|exists:blog_categories,id',
            'featured_image' => 'nullable|image|max:2048',
            'gallery_images.*' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
            'allow_comments' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string',
            'tags' => 'nullable|array',
            'tags.*' => 'string'
        ]);

        // Gerar slug se não fornecido
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Processar imagem destacada
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $this->uploadImage($request->file('featured_image'));
        }

        // Processar galeria de imagens
        if ($request->hasFile('gallery_images')) {
            $galleryImages = [];
            foreach ($request->file('gallery_images') as $image) {
                $galleryImages[] = $this->uploadImage($image);
            }
            $validated['gallery_images'] = $galleryImages;
        }

        // Processar meta keywords
        if (!empty($validated['meta_keywords'])) {
            $validated['meta_keywords'] = array_map('trim', explode(',', $validated['meta_keywords']));
        }

        // Definir data de publicação
        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $post = BlogPost::create($validated);

        // Processar tags
        if (!empty($validated['tags'])) {
            $this->syncTags($post, $validated['tags']);
        }

        return redirect()->route('admin.blog.show', $post->id)
            ->with('success', 'Post criado com sucesso!');
    }

    /**
     * Display the specified post.
     */
    public function show($id)
    {
        $post = BlogPost::with([
            'category',
            'author',
            'tags',
            'comments.user',
            'comments.parent',
            'views'
        ])->findOrFail($id);

        // Estatísticas específicas do post
        $estatisticas = [
            'total_views' => $post->views_count,
            'total_likes' => $post->likes_count,
            'total_shares' => $post->shares_count,
            'total_comments' => $post->comments()->count(),
            'approved_comments' => $post->approvedComments()->count(),
            'pending_comments' => $post->comments()->where('status', 'pending')->count(),
        ];

        // Comentários recentes
        $comentariosRecentes = $post->comments()
            ->with(['user', 'parent'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('blog::admin.show', compact('post', 'estatisticas', 'comentariosRecentes'));
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit($id)
    {
        $post = BlogPost::with(['tags'])->findOrFail($id);
        $categories = BlogCategory::active()->ordered()->get();
        $tags = BlogTag::orderBy('name')->get();

        return view('blog::admin.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified post.
     */
    public function update(Request $request, $id)
    {
        $post = BlogPost::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_posts,slug,' . $id,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'category_id' => 'required|exists:blog_categories,id',
            'featured_image' => 'nullable|image|max:2048',
            'gallery_images.*' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
            'allow_comments' => 'boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string',
            'tags' => 'nullable|array',
            'tags.*' => 'string'
        ]);

        // Gerar slug se não fornecido
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Processar imagem destacada
        if ($request->hasFile('featured_image')) {
            // Remover imagem antiga
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $validated['featured_image'] = $this->uploadImage($request->file('featured_image'));
        }

        // Processar galeria de imagens
        if ($request->hasFile('gallery_images')) {
            // Remover imagens antigas
            if ($post->gallery_images) {
                foreach ($post->gallery_images as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            }

            $galleryImages = [];
            foreach ($request->file('gallery_images') as $image) {
                $galleryImages[] = $this->uploadImage($image);
            }
            $validated['gallery_images'] = $galleryImages;
        }

        // Processar meta keywords
        if (!empty($validated['meta_keywords'])) {
            $validated['meta_keywords'] = array_map('trim', explode(',', $validated['meta_keywords']));
        }

        // Definir data de publicação
        if ($validated['status'] === 'published' && empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $post->update($validated);

        // Processar tags
        if (!empty($validated['tags'])) {
            $this->syncTags($post, $validated['tags']);
        } else {
            $post->tags()->detach();
        }

        return redirect()->route('admin.blog.show', $post->id)
            ->with('success', 'Post atualizado com sucesso!');
    }

    /**
     * Remove the specified post.
     */
    public function destroy($id)
    {
        \Log::info('BlogAdminController::destroy called with ID: ' . $id);

        try {
            $post = BlogPost::findOrFail($id);
            \Log::info('Post found: ' . $post->title);

            // Remover imagens
            if ($post->featured_image) {
                \Log::info('Deleting featured image: ' . $post->featured_image);
                Storage::disk('public')->delete($post->featured_image);
            }

            if ($post->gallery_images) {
                \Log::info('Deleting ' . count($post->gallery_images) . ' gallery images');
                foreach ($post->gallery_images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }

            $post->delete();
            \Log::info('Post deleted successfully');

            \Log::info('Redirecting to admin.blog.index');
            return redirect()->route('admin.blog.index')
                ->with('success', 'Post excluído com sucesso!');

        } catch (\Exception $e) {
            \Log::error('Error in BlogAdminController::destroy: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->with('error', 'Erro ao excluir post: ' . $e->getMessage());
        }
    }

    /**
     * Upload and process image
     */
    private function uploadImage($file)
    {
        $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
        $path = 'blog/images/' . date('Y/m');

        // Criar diretório se não existir
        Storage::disk('public')->makeDirectory($path);

        // Redimensionar e otimizar imagem
        $image = Image::make($file);
        $image->fit(1200, 800, function ($constraint) {
            $constraint->upsize();
        });

        // Salvar imagem
        $fullPath = $path . '/' . $filename;
        Storage::disk('public')->put($fullPath, $image->encode());

        return $fullPath;
    }

    /**
     * Sync tags with post
     */
    private function syncTags($post, $tagNames)
    {
        $tagIds = [];

        foreach ($tagNames as $tagName) {
            $tagName = trim($tagName);
            if (!empty($tagName)) {
                $tag = BlogTag::firstOrCreate(
                    ['name' => $tagName],
                    ['slug' => Str::slug($tagName)]
                );
                $tagIds[] = $tag->id;
            }
        }

        $post->tags()->sync($tagIds);
    }

    /**
     * Calculate statistics
     */
    private function calcularEstatisticas()
    {
        try {
            return [
                'total_posts' => BlogPost::count(),
                'published_posts' => BlogPost::published()->count(),
                'draft_posts' => BlogPost::where('status', 'draft')->count(),
                'featured_posts' => BlogPost::featured()->count(),
                'total_categories' => BlogCategory::count(),
                'total_tags' => BlogTag::count(),
                'total_comments' => BlogComment::count(),
                'pending_comments' => BlogComment::pending()->count(),
                'total_views' => BlogPost::sum('views_count'),
            ];
        } catch (\Exception $e) {
            \Log::error('Erro ao calcular estatísticas do blog: ' . $e->getMessage());
            return [
                'total_posts' => 0,
                'published_posts' => 0,
                'draft_posts' => 0,
                'featured_posts' => 0,
                'total_categories' => 0,
                'total_tags' => 0,
                'total_comments' => 0,
                'pending_comments' => 0,
                'total_views' => 0,
            ];
        }
    }

    /**
     * Upload image for blog content editor
     */
    public function uploadEditorImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
            'type' => 'nullable|string'
        ]);

        try {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Create directory if it doesn't exist
            $path = public_path('storage/blog/images');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            // Move file to storage
            $file->move($path, $filename);

            return response()->json([
                'success' => true,
                'url' => asset('storage/blog/images/' . $filename),
                'filename' => $filename
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao fazer upload da imagem: ' . $e->getMessage()
            ], 500);
        }
    }
}

    /**
     * Import data from Demanda (Privacy Shield)
     */
    public function importDemanda(Request $request)
    {
        $id = $request->input('id');
        $demanda = \Modules\Demandas\App\Models\Demanda::with('pessoa')->findOrFail($id);

        // Privacy Shield: Consent Check
        if (!$demanda->image_consent) {
            return response()->json([
                'success' => false,
                'message' => 'AVISO DE PRIVACIDADE: O solicitante NÃO autorizou o uso de imagens para esta demanda. O uso de fotos é PROIBIDO.',
                'restricted' => true
            ]);
        }

        // Sanitization Logic: Mask Address
        $address = $demanda->endereco ?? '';
        // Regex to remove house numbers (e.g., ", 123" or " nº 123")
        $sanitizedAddress = preg_replace('/,\s*n?º?\s*\d+/i', '', $address);
        $sanitizedAddress = preg_replace('/\s+\d+$/', '', $sanitizedAddress); // Remove number at end if no comma

        $title = "Serviço Realizado: " . ($demanda->tipoServico->nome ?? 'Manutenção');
        $content = "
            <h2>Relatório de Execução</h2>
            <p><strong>Local:</strong> {$sanitizedAddress}</p>
            <p><strong>Descrição:</strong> {$demanda->descricao}</p>
            <p><strong>Status:</strong> Concluído</p>
            <p>A Secretaria Municipal de Agricultura informa que a solicitação foi atendida com sucesso, garantindo melhorias para a comunidade local.</p>
        ";

        return response()->json([
            'success' => true,
            'title' => $title,
            'content' => $content,
            // Assuming Demanda has photos/attachments logic, but we'll return empty for now as it varies
            'images' => []
        ]);
    }
}
