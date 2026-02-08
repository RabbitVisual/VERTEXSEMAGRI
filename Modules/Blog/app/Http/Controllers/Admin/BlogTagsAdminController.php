<?php

namespace Modules\Blog\App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Blog\App\Models\BlogTag;
use Illuminate\Support\Str;

class BlogTagsAdminController extends Controller
{
    /**
     * Display tags list
     */
    public function index()
    {
        $tags = BlogTag::withCount('posts')
            ->orderBy('name')
            ->paginate(20);

        $estatisticas = [
            'total_tags' => BlogTag::count(),
            'used_tags' => BlogTag::has('posts')->count(),
            'unused_tags' => BlogTag::doesntHave('posts')->count(),
        ];

        return view('blog::admin.tags.index', compact('tags', 'estatisticas'));
    }

    /**
     * Show the form for creating a new tag.
     */
    public function create()
    {
        return view('blog::admin.tags.create');
    }

    /**
     * Store a newly created tag.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_tags,slug',
            'color' => 'nullable|string|max:7'
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        BlogTag::create($validated);

        return redirect()->route('admin.blog.tags.index')
            ->with('success', 'Tag criada com sucesso!');
    }

    /**
     * Display the specified tag.
     */
    public function show($id)
    {
        $tag = BlogTag::with(['posts' => function ($query) {
            $query->with(['author', 'category'])->orderBy('created_at', 'desc')->limit(10);
        }])->findOrFail($id);

        $estatisticas = [
            'total_posts' => $tag->posts()->count(),
            'published_posts' => $tag->publishedPosts()->count(),
            'draft_posts' => $tag->posts()->where('status', 'draft')->count(),
            'total_views' => $tag->posts()->sum('views_count'),
        ];

        return view('blog::admin.tags.show', compact('tag', 'estatisticas'));
    }

    /**
     * Show the form for editing the specified tag.
     */
    public function edit($id)
    {
        $tag = BlogTag::findOrFail($id);
        return view('blog::admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified tag.
     */
    public function update(Request $request, $id)
    {
        $tag = BlogTag::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_tags,slug,' . $id,
            'color' => 'nullable|string|max:7'
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $tag->update($validated);

        return redirect()->route('admin.blog.tags.show', $tag->id)
            ->with('success', 'Tag atualizada com sucesso!');
    }

    /**
     * Remove the specified tag.
     */
    public function destroy($id)
    {
        $tag = BlogTag::findOrFail($id);
        $tag->delete();

        return redirect()->route('admin.blog.tags.index')
            ->with('success', 'Tag excluída com sucesso!');
    }

    /**
     * Clean unused tags
     */
    public function cleanUnused()
    {
        $deletedCount = BlogTag::doesntHave('posts')->delete();

        return redirect()->route('admin.blog.tags.index')
            ->with('success', "Foram removidas {$deletedCount} tags não utilizadas.");
    }
}
