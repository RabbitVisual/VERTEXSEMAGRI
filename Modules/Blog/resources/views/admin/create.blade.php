@extends('admin.layouts.admin')

@section('title', 'Novo Post - Blog Admin')

@section('content')
<!-- Page Header -->
<div class="mb-8 pb-4 border-b border-gray-200 dark:border-slate-700">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <svg class="w-8 h-8 text-emerald-600 dark:text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    {!! \App\Helpers\ModuleIcons::getIconPath('Blog') !!}
                </svg>
                Novo Post
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                    <li><a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400">Dashboard</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="{{ route('admin.blog.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400">Blog</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-gray-900 dark:text-gray-100">Novo Post</li>
                </ol>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.blog.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-medium transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Voltar
            </a>
        </div>
    </div>
</div>

<!-- Form -->
<form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Info -->
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Informações Básicas</h3>
                
                <div class="space-y-4">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Título *
                        </label>
                        <input type="text" id="title" name="title" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                               placeholder="Digite o título do post...">
                    </div>

                    <!-- Slug -->
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Slug (URL amigável)
                        </label>
                        <input type="text" id="slug" name="slug"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                               placeholder="deixe-vazio-para-gerar-automaticamente">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Deixe vazio para gerar automaticamente</p>
                    </div>

                    <!-- Excerpt -->
                    <div>
                        <label for="excerpt" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Resumo
                        </label>
                        <textarea id="excerpt" name="excerpt" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                  placeholder="Breve resumo do post..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Conteúdo</h3>
                
                <div class="blog-editor-wrapper">
                    <label for="blog-content-editor" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Conteúdo do Post *
                    </label>
                    <div id="blog-content-editor" class="min-h-[400px]"></div>
                    <textarea id="content" name="content" class="hidden"></textarea>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Editor completo com formatação rica, imagens, links, listas e muito mais.
                        <span class="text-emerald-600 dark:text-emerald-400 font-medium">Auto-save ativado!</span>
                    </p>
                </div>
            </div>

            <!-- Images -->
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Imagens</h3>
                
                <div class="space-y-4">
                    <!-- Featured Image -->
                    <div>
                        <label for="featured_image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Imagem Destacada
                        </label>
                        <input type="file" id="featured_image" name="featured_image" accept="image/*"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>

                    <!-- Gallery Images -->
                    <div>
                        <label for="gallery_images" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Galeria de Imagens
                        </label>
                        <input type="file" id="gallery_images" name="gallery_images[]" accept="image/*" multiple
                               class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Selecione múltiplas imagens para criar uma galeria</p>
                    </div>
                </div>
            </div>

            <!-- SEO -->
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">SEO</h3>
                
                <div class="space-y-4">
                    <!-- Meta Title -->
                    <div>
                        <label for="meta_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Meta Título
                        </label>
                        <input type="text" id="meta_title" name="meta_title"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                               placeholder="Título para SEO (deixe vazio para usar o título do post)">
                    </div>

                    <!-- Meta Description -->
                    <div>
                        <label for="meta_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Meta Descrição
                        </label>
                        <textarea id="meta_description" name="meta_description" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                  placeholder="Descrição para SEO..."></textarea>
                    </div>

                    <!-- Meta Keywords -->
                    <div>
                        <label for="meta_keywords" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Palavras-chave
                        </label>
                        <input type="text" id="meta_keywords" name="meta_keywords"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                               placeholder="palavra1, palavra2, palavra3">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Separe as palavras-chave com vírgulas</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Publish -->
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Publicação</h3>
                
                <div class="space-y-4">
                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Status
                        </label>
                        <select id="status" name="status" 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="draft">Rascunho</option>
                            <option value="published">Publicado</option>
                            <option value="archived">Arquivado</option>
                        </select>
                    </div>

                    <!-- Published At -->
                    <div>
                        <label for="published_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Data de Publicação
                        </label>
                        <input type="datetime-local" id="published_at" name="published_at"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>

                    <!-- Featured -->
                    <div class="flex items-center">
                        <input type="checkbox" id="is_featured" name="is_featured" value="1"
                               class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                        <label for="is_featured" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                            Post em destaque
                        </label>
                    </div>

                    <!-- Allow Comments -->
                    <div class="flex items-center">
                        <input type="checkbox" id="allow_comments" name="allow_comments" value="1" checked
                               class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                        <label for="allow_comments" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                            Permitir comentários
                        </label>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-slate-700">
                    <div class="flex flex-col gap-3">
                        <button type="submit" 
                                class="w-full px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition-colors">
                            Criar Post
                        </button>
                        <a href="{{ route('admin.blog.index') }}" 
                           class="w-full px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg font-medium transition-colors text-center">
                            Cancelar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Category -->
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Categoria</h3>
                
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Categoria *
                    </label>
                    <select id="category_id" name="category_id" required
                            class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">Selecione uma categoria</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mt-4">
                    <a href="{{ route('admin.blog.categories.create') }}" 
                       class="text-sm text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300">
                        + Nova categoria
                    </a>
                </div>
            </div>

            <!-- Tags -->
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Tags</h3>
                
                <div>
                    <label for="tags" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Tags do Post
                    </label>
                    <input type="text" id="tags" name="tags[]" 
                           class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                           placeholder="Digite as tags separadas por vírgula">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Separe as tags com vírgulas</p>
                </div>

                <!-- Popular Tags -->
                @if($tags->count() > 0)
                <div class="mt-4">
                    <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tags populares:</p>
                    <div class="flex flex-wrap gap-2">
                        @foreach($tags->take(10) as $tag)
                        <button type="button" onclick="addTag('{{ $tag->name }}')" 
                                class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 hover:bg-gray-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-300 transition-colors">
                            {{ $tag->name }}
                        </button>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
@vite('resources/js/blog-editor.js')

<script>
// Auto-generate slug from title
document.getElementById('title').addEventListener('input', function() {
    const title = this.value;
    const slug = title.toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim('-');
    document.getElementById('slug').value = slug;
});

// Add tag function
function addTag(tagName) {
    const tagsInput = document.getElementById('tags');
    const currentTags = tagsInput.value;

    if (currentTags) {
        tagsInput.value = currentTags + ', ' + tagName;
    } else {
        tagsInput.value = tagName;
    }
}
</script>
@endpush

@push('styles')
<style>
.blog-editor-wrapper .ql-toolbar.ql-snow {
    border: 2px solid rgb(209 213 219);
    border-radius: 0.75rem 0.75rem 0 0;
    background: white;
}
.dark .blog-editor-wrapper .ql-toolbar.ql-snow {
    border-color: rgb(51 65 85);
    background: rgb(51 65 85);
}
.blog-editor-wrapper .ql-container.ql-snow {
    border: 2px solid rgb(209 213 219);
    border-top: none;
    border-radius: 0 0 0.75rem 0.75rem;
    background: white;
    min-height: 400px;
}
.dark .blog-editor-wrapper .ql-container.ql-snow {
    border-color: rgb(51 65 85);
    background: rgb(30 41 59);
}
</style>
@endpush
