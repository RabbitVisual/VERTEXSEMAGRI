@extends('admin.layouts.admin')

@section('title', 'Criar Slide do Carousel')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>
                <span>Criar Slide do Carousel</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Admin</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <a href="{{ route('admin.carousel.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Carousel</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <span class="text-gray-900 dark:text-white font-medium">Criar</span>
            </nav>
        </div>
        <a href="{{ route('admin.carousel.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-slate-800 dark:text-white dark:border-slate-600 dark:hover:bg-slate-700 dark:focus:ring-slate-700 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
            Cancelar
        </a>
    </div>

    <!-- Form - Flowbite Card -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700">
        <form action="{{ route('admin.carousel.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="p-6 md:p-8 space-y-6 md:space-y-8">
                <!-- Título -->
                <div>
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Título do Slide <span class="text-xs font-normal text-gray-500 dark:text-gray-400">(aceita HTML formatado)</span>
                    </label>
                    <!-- Quill Editor Container para Título -->
                    <div id="quill-title" class="quill-editor-wrapper"></div>
                    <!-- Hidden textarea para enviar HTML -->
                    <textarea id="title" name="title" class="hidden">{{ old('title') }}</textarea>
                    @error('title')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ordem de Exibição -->
                <div class="max-w-xs">
                    <label for="order" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Ordem de Exibição
                    </label>
                    <input type="number"
                           id="order"
                           name="order"
                           value="{{ old('order', \App\Models\CarouselSlide::max('order') + 1) }}"
                           min="0"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500 @error('order') border-red-500 dark:border-red-600 @enderror">
                    @error('order')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Número menor aparece primeiro</p>
                </div>

                <!-- Descrição -->
                <div>
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Descrição/Texto do Slide <span class="text-xs font-normal text-gray-500 dark:text-gray-400">(Editor de texto rico - negrito, cores, tamanhos, etc.)</span>
                    </label>
                    <!-- Quill Editor Container -->
                    <div id="quill-description" class="quill-editor-wrapper"></div>
                    <!-- Hidden textarea para enviar HTML -->
                    <textarea id="description" name="description" class="hidden">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Imagem -->
                <div>
                    <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Imagem do Slide
                    </label>
                    <div class="space-y-4">
                        <input type="file"
                               id="image"
                               name="image"
                               accept="image/*"
                               onchange="previewImage(this)"
                               class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 @error('image') border-red-500 dark:border-red-600 @enderror">
                        @error('image')
                            <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        <div id="imagePreview" class="hidden">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Preview da Imagem:</p>
                            <img id="previewImg" src="" alt="Preview" class="w-full max-w-md h-64 object-cover rounded-lg border border-gray-200 dark:border-slate-700">
                        </div>
                    </div>
                </div>

                <!-- Link -->
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="link" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Link (URL)
                        </label>
                        <input type="url"
                               id="link"
                               name="link"
                               value="{{ old('link') }}"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500 @error('link') border-red-500 dark:border-red-600 @enderror"
                               placeholder="https://exemplo.com">
                        @error('link')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="link_text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Texto do Botão
                        </label>
                        <input type="text"
                               id="link_text"
                               name="link_text"
                               value="{{ old('link_text', 'Saiba mais') }}"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500 @error('link_text') border-red-500 dark:border-red-600 @enderror"
                               placeholder="Ex: Saiba mais">
                        @error('link_text')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Opções -->
                <div class="grid md:grid-cols-2 gap-6 pt-4 border-t border-gray-200 dark:border-slate-700">
                    <div class="flex items-center gap-3">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', true) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-emerald-600"></div>
                            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-white">Slide Ativo</span>
                        </label>
                    </div>

                    <div class="flex items-center gap-3">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="show_image" value="1" class="sr-only peer" {{ old('show_image', true) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
                            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-white">Exibir Imagem</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex items-center justify-end gap-3 p-6 border-t border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <a href="{{ route('admin.carousel.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-slate-800 dark:text-white dark:border-slate-600 dark:hover:bg-slate-700 dark:focus:ring-slate-700 transition-colors">
                    Cancelar
                </a>
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-center text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800 transition-colors">
                    <div class="inline-flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                        Criar Slide
                    </div>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
@vite(['resources/js/quill-editor.js'])
<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        };

        reader.readAsDataURL(input.files[0]);
    } else {
        preview.classList.add('hidden');
    }
}
</script>
@endpush
@endsection
