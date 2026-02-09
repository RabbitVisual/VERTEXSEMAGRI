@extends('admin.layouts.admin')

@section('title', 'Editar: ' . $post->title . ' - Blog Admin')

@section('content')
<!-- Page Header -->
<div class="mb-8 pb-4 border-b border-gray-200 dark:border-slate-700">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <x-icon name="newspaper" style="duotone" class="w-8 h-8 text-emerald-600 dark:text-emerald-500" />
                Editar Post
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                    <li><a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400">Dashboard</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="{{ route('admin.blog.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400">Blog</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="{{ route('admin.blog.show', $post->id) }}" class="hover:text-emerald-600 dark:hover:text-emerald-400">{{ Str::limit($post->title, 20) }}</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-gray-900 dark:text-gray-100">Editar</li>
                </ol>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.blog.show', $post->id) }}"
               class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg font-medium transition-colors">
                <x-icon name="arrow-left" class="w-4 h-4 mr-2" />
                Voltar
            </a>
        </div>
    </div>
</div>

<!-- Form -->
<form action="{{ route('admin.blog.update', $post->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

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
                        <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>

                    <!-- Slug -->
                    <div>
                        <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Slug (URL amigável)
                        </label>
                        <div class="flex">
                            <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 dark:border-slate-600 bg-gray-50 dark:bg-slate-800 text-gray-500 dark:text-gray-400 text-sm">
                                {{ config('app.url') }}/blog/
                            </span>
                            <input type="text" id="slug" name="slug" value="{{ old('slug', $post->slug) }}"
                                   class="flex-1 min-w-0 block w-full px-3 py-2 rounded-r-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm">
                        </div>
                    </div>

                    <!-- Excerpt -->
                    <div>
                        <label for="excerpt" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Resumo
                        </label>
                        <textarea id="excerpt" name="excerpt" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">{{ old('excerpt', $post->excerpt) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Content Editor -->
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Conteúdo</h3>
                
                <div class="blog-editor-wrapper">
                    <div id="editor-container" class="h-96">{!! old('content', $post->content) !!}</div>
                    <input type="hidden" name="content" id="content" value="{{ old('content', $post->content) }}">
                </div>
            </div>

            <!-- Media -->
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Mídia</h3>

                <div class="space-y-6">
                    <!-- Featured Image -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Imagem Destacada
                        </label>

                        @if($post->featured_image)
                        <div class="mb-4 relative w-48 h-32 rounded-lg overflow-hidden border border-gray-200 dark:border-slate-600 group">
                            <img src="{{ Storage::url($post->featured_image) }}" class="object-cover w-full h-full">
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <button type="button" onclick="openPrivacyEditor('{{ Storage::url($post->featured_image) }}')"
                                        class="bg-red-600 text-white p-2 rounded-full hover:bg-red-700" title="Censurar/Editar">
                                    <x-icon name="eye-slash" class="w-4 h-4" />
                                </button>
                            </div>
                        </div>
                        @endif

                        <input type="file" name="featured_image" accept="image/*" class="block w-full text-sm text-slate-500 ...">
                    </div>

                    <!-- Gallery Images -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Galeria de Imagens
                        </label>

                        @if($post->gallery_images)
                        <div class="grid grid-cols-4 gap-2 mb-4">
                            @foreach($post->gallery_images as $img)
                            <div class="relative aspect-square rounded overflow-hidden border border-gray-200 dark:border-slate-600 group">
                                <img src="{{ Storage::url($img) }}" class="object-cover w-full h-full">
                                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                    <button type="button" onclick="openPrivacyEditor('{{ Storage::url($img) }}')"
                                            class="bg-red-600 text-white p-2 rounded-full hover:bg-red-700" title="Censurar/Editar">
                                        <x-icon name="eye-slash" class="w-4 h-4" />
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        <input type="file" name="gallery_images[]" multiple accept="image/*" class="block w-full text-sm text-slate-500 ...">
                
                <div class="space-y-6">
                    <!-- Featured Image -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Imagem Destacada
                        </label>
                        
                        @if($post->featured_image)
                        <div class="mb-4 relative w-48 h-32 rounded-lg overflow-hidden border border-gray-200 dark:border-slate-600 group">
                            <img src="{{ Storage::url($post->featured_image) }}" class="object-cover w-full h-full">
                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <button type="button" onclick="openPrivacyEditor('{{ Storage::url($post->featured_image) }}')" 
                                        class="bg-red-600 text-white p-2 rounded-full hover:bg-red-700" title="Censurar/Editar">
                                    <x-icon name="eye-slash" class="w-4 h-4" />
                                </button>
                            </div>
                        </div>
                        @endif

                        <input type="file" name="featured_image" accept="image/*" class="block w-full text-sm text-slate-500 ...">
                    </div>

                    <!-- Gallery Images -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Galeria de Imagens
                        </label>
                        
                        @if($post->gallery_images)
                        <div class="grid grid-cols-4 gap-2 mb-4">
                            @foreach($post->gallery_images as $img)
                            <div class="relative aspect-square rounded overflow-hidden border border-gray-200 dark:border-slate-600 group">
                                <img src="{{ Storage::url($img) }}" class="object-cover w-full h-full">
                                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-2">
                                    <button type="button" onclick="openPrivacyEditor('{{ Storage::url($img) }}')" 
                                            class="bg-red-600 text-white p-2 rounded-full hover:bg-red-700" title="Censurar/Editar">
                                        <x-icon name="eye-slash" class="w-4 h-4" />
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        <input type="file" name="gallery_images[]" multiple accept="image/*" class="block w-full text-sm text-slate-500 ...">
                    </div>
                </div>
            </div>

            <!-- Attachments -->
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Anexos (PDFs, Editais)</h3>
                
                @if($post->attachments)
                <ul class="mb-4 space-y-2">
                    @foreach($post->attachments as $att)
                    <li class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                        <x-icon name="file-pdf" class="w-4 h-4 mr-2" />
                        {{ $att['name'] }}
                    </li>
                    @endforeach
                </ul>
                @endif
                
                <input type="file" name="attachments[]" multiple accept=".pdf" class="block w-full text-sm text-slate-500 ...">
            </div>

            <!-- SEO -->
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Otimização SEO</h3>
                
                <div class="space-y-4">
                    <!-- Meta Title -->
                    <div>
                        <label for="meta_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Meta Título
                        </label>
                        <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $post->meta_title) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                </div>
            </div>

            <!-- Attachments -->
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Anexos (PDFs, Editais)</h3>

                @if($post->attachments)
                <ul class="mb-4 space-y-2">
                    @foreach($post->attachments as $att)
                    <li class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                        <x-icon name="file-pdf" class="w-4 h-4 mr-2" />
                        {{ $att['name'] }}
                    </li>
                    @endforeach
                </ul>
                @endif

                <input type="file" name="attachments[]" multiple accept=".pdf" class="block w-full text-sm text-slate-500 ...">
            </div>

            <!-- SEO -->
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Otimização SEO</h3>

                <div class="space-y-4">
                    <!-- Meta Title -->
                    <div>
                        <label for="meta_title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Meta Título
                        </label>
                        <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $post->meta_title) }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>

                    <!-- Meta Description -->
                    <div>
                        <label for="meta_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Meta Descrição
                        </label>
                    <!-- Meta Description -->
                    <div>
                        <label for="meta_description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Meta Descrição
                        </label>
                        <textarea id="meta_description" name="meta_description" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">{{ old('meta_description', $post->meta_description) }}</textarea>
                    </div>

                    <!-- OG Image -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Imagem de Compartilhamento (OG Image)
                        </label>

                        
                        @if($post->og_image)
                        <div class="mb-2">
                            <img src="{{ Storage::url($post->og_image) }}" class="h-20 w-auto rounded border">
                        </div>
                        @endif

                        <input type="file" name="og_image" accept="image/*" class="block w-full text-sm text-slate-500 ...">
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
                        <select id="status" name="status" 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="draft" {{ $post->status == 'draft' ? 'selected' : '' }}>Rascunho</option>
                            <option value="review" {{ $post->status == 'review' ? 'selected' : '' }}>Em Revisão</option>
                            <option value="published" {{ $post->status == 'published' ? 'selected' : '' }}>Publicado</option>
                            <option value="archived" {{ $post->status == 'archived' ? 'selected' : '' }}>Arquivado</option>
                        </select>
                    </div>

                    <!-- Published At -->
                    <div>
                        <label for="published_at" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Data de Publicação
                        </label>
                        <input type="datetime-local" id="published_at" name="published_at"
                               value="{{ $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '' }}"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>

                    <!-- Featured -->
                    <div class="flex items-center">
                        <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ $post->is_featured ? 'checked' : '' }}
                               class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                        <label for="is_featured" class="ml-2 block text-sm text-gray-900 dark:text-gray-100">
                            Post em destaque
                        </label>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-slate-700">
                    <div class="flex flex-col gap-3">
                        <button type="submit" 
                                class="w-full px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition-colors">
                            <x-icon name="save" class="w-4 h-4 inline mr-1" /> Salvar Alterações
                        </button>
                        <a href="{{ route('admin.blog.index') }}"
                        <a href="{{ route('admin.blog.index') }}" 
                           class="w-full px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg font-medium transition-colors text-center">
                            Cancelar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Integrations -->
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Integrações</h3>

                <div class="space-y-4">
                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Categoria *
                        </label>
                        <select id="category_id" name="category_id" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

            
            <!-- Integrations -->
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Integrações</h3>
                
                <div class="space-y-4">
                    <!-- Category -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Categoria *
                        </label>
                        <select id="category_id" name="category_id" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Team Members -->
                    <div>
                        <label for="team_members" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Equipe Responsável
                        </label>
                        <select id="team_members" name="team_members[]" multiple size="5"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                            @if(isset($employees))
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}" {{ in_array($emp->id, $post->team_members ?? []) ? 'selected' : '' }}>
                                        {{ $emp->nom_pessoa }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <!-- Related Demand -->
                    <div>
                        <label for="related_demand_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Demanda Relacionada
                        </label>
                        <select id="related_demand_id" name="related_demand_id"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
                            <option value="">Nenhuma</option>
                            @if(isset($demandas))
                                @foreach($demandas as $dem)
                                    <option value="{{ $dem->id }}" {{ $post->related_demand_id == $dem->id ? 'selected' : '' }}>
                                        #{{ $dem->id }} - {{ \Illuminate\Support\Str::limit($dem->descricao ?? 'Sem descrição', 30) }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
            </div>

            <!-- Tags -->
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Tags</h3>
                
                <div>
                    <input type="text" id="tags" name="tags[]" value="{{ implode(',', $post->tags->pluck('name')->toArray()) }}"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                           placeholder="Digite as tags...">
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Privacy Editor Modal -->
<div id="privacyEditorModal" class="fixed inset-0 z-50 hidden bg-black/80 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-2xl max-w-4xl w-full flex flex-col max-h-[90vh]">
        <div class="p-4 border-b border-gray-200 dark:border-slate-700 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center">
                <x-icon name="shield-check" class="w-5 h-5 mr-2 text-emerald-600" />
                Editor de Privacidade (LGPD)
            </h3>
            <button onclick="closePrivacyEditor()" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                <x-icon name="xmark" class="w-6 h-6" />
            </button>
        </div>

        <div class="flex-1 overflow-auto p-4 bg-gray-900 flex justify-center items-center relative" id="canvas-container">
            <canvas id="editorCanvas" class="max-w-full cursor-crosshair"></canvas>
        </div>

        
        <div class="flex-1 overflow-auto p-4 bg-gray-900 flex justify-center items-center relative" id="canvas-container">
            <canvas id="editorCanvas" class="max-w-full cursor-crosshair"></canvas>
        </div>
        
        <div class="p-4 border-t border-gray-200 dark:border-slate-700 flex justify-between items-center bg-gray-50 dark:bg-slate-900">
            <div class="text-sm text-gray-500">
                Selecione uma área na imagem para censurar.
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="applyBlur()" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg font-medium flex items-center">
                    <x-icon name="droplet" class="w-4 h-4 mr-2" /> Borrar
                </button>
                <button type="button" onclick="applyPixelate()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium flex items-center">
                    <x-icon name="border-none" class="w-4 h-4 mr-2" /> Pixelar
                </button>
                <div class="w-px h-8 bg-gray-300 dark:bg-slate-600 mx-2"></div>
                <button type="button" onclick="saveRedaction()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium flex items-center">
                    <x-icon name="floppy-disk" class="w-4 h-4 mr-2" /> Salvar Edição
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@vite('resources/js/blog-editor.js')

<script>
// Privacy Editor Logic
let canvas, ctx;
let isDrawing = false;
let startX, startY, currentX, currentY;
let currentImageSrc = '';
let imgObj = new Image();

function openPrivacyEditor(src) {
    currentImageSrc = src;
    document.getElementById('privacyEditorModal').classList.remove('hidden');

    canvas = document.getElementById('editorCanvas');
    ctx = canvas.getContext('2d');

    
    canvas = document.getElementById('editorCanvas');
    ctx = canvas.getContext('2d');
    
    imgObj.onload = function() {
        // Set canvas size to image size
        canvas.width = imgObj.width;
        canvas.height = imgObj.height;

        
        // Scale logic for display would be handled by CSS max-w-full
        ctx.drawImage(imgObj, 0, 0);
    };
    imgObj.src = src;

    
    // Mouse Events for Selection
    canvas.onmousedown = function(e) {
        const rect = canvas.getBoundingClientRect();
        const scaleX = canvas.width / rect.width;
        const scaleY = canvas.height / rect.height;

        
        startX = (e.clientX - rect.left) * scaleX;
        startY = (e.clientY - rect.top) * scaleY;
        isDrawing = true;
    };

    canvas.onmousemove = function(e) {
        if (!isDrawing) return;

        const rect = canvas.getBoundingClientRect();
        const scaleX = canvas.width / rect.width;
        const scaleY = canvas.height / rect.height;

        currentX = (e.clientX - rect.left) * scaleX;
        currentY = (e.clientY - rect.top) * scaleY;

        // Redraw image
        ctx.drawImage(imgObj, 0, 0);

    
    canvas.onmousemove = function(e) {
        if (!isDrawing) return;
        
        const rect = canvas.getBoundingClientRect();
        const scaleX = canvas.width / rect.width;
        const scaleY = canvas.height / rect.height;
        
        currentX = (e.clientX - rect.left) * scaleX;
        currentY = (e.clientY - rect.top) * scaleY;
        
        // Redraw image
        ctx.drawImage(imgObj, 0, 0);
        
        // Draw selection rectangle
        ctx.strokeStyle = 'red';
        ctx.lineWidth = 2;
        ctx.strokeRect(startX, startY, currentX - startX, currentY - startY);
    };

    
    canvas.onmouseup = function() {
        isDrawing = false;
        // Keep the selection rect visible until action
    };
}

function closePrivacyEditor() {
    document.getElementById('privacyEditorModal').classList.add('hidden');
}

function applyPixelate() {
    if (startX === undefined) return;

    const w = currentX - startX;
    const h = currentY - startY;
    const size = 10; // Pixel size

    // Get image data of selected area
    // Simplified pixelation: draw small version then scale up

    // Draw original image to clear selection box
    ctx.drawImage(imgObj, 0, 0);

    
    const w = currentX - startX;
    const h = currentY - startY;
    const size = 10; // Pixel size
    
    // Get image data of selected area
    // Simplified pixelation: draw small version then scale up
    
    // Draw original image to clear selection box
    ctx.drawImage(imgObj, 0, 0);
    
    // We need to manipulate pixels or use drawImage trick
    // Create temp canvas
    const tempCanvas = document.createElement('canvas');
    const tCtx = tempCanvas.getContext('2d');

    tempCanvas.width = Math.abs(w);
    tempCanvas.height = Math.abs(h);

    // Draw selected area to temp canvas reduced size
    tCtx.drawImage(canvas, startX, startY, w, h, 0, 0, w/size, h/size);

    
    tempCanvas.width = Math.abs(w);
    tempCanvas.height = Math.abs(h);
    
    // Draw selected area to temp canvas reduced size
    tCtx.drawImage(canvas, startX, startY, w, h, 0, 0, w/size, h/size);
    
    // Draw back scaled up
    ctx.imageSmoothingEnabled = false;
    ctx.drawImage(tempCanvas, 0, 0, w/size, h/size, startX, startY, w, h);
    ctx.imageSmoothingEnabled = true;

    
    // Update imgObj to current state so we can add multiple redactions
    imgObj.src = canvas.toDataURL();
}

function applyBlur() {
    if (startX === undefined) return;

    const w = currentX - startX;
    const h = currentY - startY;

    ctx.drawImage(imgObj, 0, 0);

    
    const w = currentX - startX;
    const h = currentY - startY;
    
    ctx.drawImage(imgObj, 0, 0);
    
    ctx.filter = 'blur(10px)';
    // Draw the image again but clipped to rect
    // This is tricky in single canvas.
    // Easier approach: put image data, blur it.

    
    // Fallback: Fill with black rectangle for "Redact" style since Canvas blur is complex without StackBlur
    ctx.filter = 'none';
    ctx.fillStyle = 'black';
    ctx.fillRect(startX, startY, w, h);

    
    // Update imgObj
    imgObj.src = canvas.toDataURL();
}

function saveRedaction() {
    const dataUrl = canvas.toDataURL('image/jpeg', 0.9);

    
    fetch('{{ route("admin.blog.redact-image") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            image_path: currentImageSrc,
            image_data: dataUrl
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Imagem atualizada com sucesso!');
            location.reload();
        } else {
            alert('Erro: ' + data.message);
        }
    })
    .catch(err => {
        console.error(err);
        alert('Erro ao salvar.');
    });
}
</script>
@endpush
