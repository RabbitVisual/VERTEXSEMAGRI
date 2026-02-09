@extends('admin.layouts.admin')

@section('title', 'Gerenciar Homepage')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon module="homepage" class="w-6 h-6 md:w-7 md:h-7 text-white" style="duotone" />
                </div>
                <span>Gerenciar Homepage</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-4 h-4" style="duotone" />
                <span class="text-gray-900 dark:text-white font-medium">Homepage</span>
            </nav>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('homepage') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors">
                <x-icon name="file-pdf" class="w-5 h-5" style="duotone" />
                Footer
            </span>
        </button>
    </nav>
</div>

<!-- Tab Content: Sections -->
<div id="tab-content-sections" class="tab-content">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-gray-900/50">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Gerenciar Seções da Homepage</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Ative ou desative seções da página inicial</p>
        </div>
        <div class="p-6 space-y-4">
                @php
                $sections = [
                    'carousel' => ['name' => 'Carousel', 'icon' => 'M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941', 'description' => 'Exibe slides rotativos no topo da página', 'special' => true],
                    'hero' => ['name' => 'Hero Section', 'icon' => 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25', 'description' => 'Seção principal com título e descrição'],
                    'servicos' => ['name' => 'Seção de Serviços', 'icon' => 'M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z', 'description' => 'Exibe os serviços oferecidos pela secretaria'],
                    'sobre' => ['name' => 'Sobre a SEMAGRI', 'icon' => 'M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z', 'description' => 'Informações sobre a secretaria'],
                    'servicos_publicos' => ['name' => 'Serviços Públicos', 'icon' => 'M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418', 'description' => 'Links para serviços públicos online'],
                    'contato' => ['name' => 'Seção de Contato', 'icon' => 'M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z', 'description' => 'Informações de contato da secretaria'],
                ];
            @endphp

            @foreach($sections as $key => $section)
                @php
                    // Garantir valor booleano correto
                    if ($key === 'carousel') {
                        $enabled = (bool) $carouselEnabled;
                    } else {
                        $enabled = isset($configs[$key . '_enabled']) ? (bool) $configs[$key . '_enabled'] : true;
                    }
                @endphp
                <div class="flex items-center justify-between p-4 rounded-xl border-2 border-gray-200 dark:border-slate-700 hover:border-emerald-300 dark:hover:border-emerald-700 transition-colors">
                    <div class="flex items-center gap-4 flex-1">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-100 to-emerald-200 dark:from-emerald-900/30 dark:to-emerald-800/30 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $section['icon'] }}" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-base font-bold text-gray-900 dark:text-white">{{ $section['name'] }}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $section['description'] }}</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer ml-4">
                        <input
                            type="checkbox"
                            class="sr-only peer section-toggle"
                            data-section="{{ $key }}"
                            {{ $enabled ? 'checked' : '' }}
                            value="1"
                        >
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-300 dark:peer-focus:ring-emerald-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-emerald-600"></div>
                    </label>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Tab Content: Carousel -->
<div id="tab-content-carousel" class="tab-content hidden">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-gray-900/50">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Gerenciar Carousel</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Gerencie os slides do carousel da homepage</p>
                </div>
                <a href="{{ route('admin.carousel.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-indigo-800 transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                    <span>Gerenciar Slides</span>
                </a>
            </div>
        </div>
        <div class="p-6">
            @if($carouselSlides->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($carouselSlides->take(6) as $slide)
                        <div class="relative rounded-xl overflow-hidden border-2 border-gray-200 dark:border-slate-700">
                            @if($slide->image && $slide->show_image)
                                <img src="{{ asset('storage/' . $slide->image) }}" alt="{{ $slide->title ?? 'Slide' }}" class="w-full h-32 object-cover">
                            @else
                                <div class="w-full h-32 bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-white/50" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="p-3 bg-white dark:bg-slate-800">
                                <h4 class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ $slide->title ?? 'Sem título' }}</h4>
                                <div class="flex items-center justify-between mt-2">
                                    <span class="text-xs px-2 py-1 rounded-full {{ $slide->is_active ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                        {{ $slide->is_active ? 'Ativo' : 'Inativo' }}
                                    </span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">#{{ $slide->order }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($carouselSlides->count() > 6)
                    <div class="mt-4 text-center">
                        <a href="{{ route('admin.carousel.index') }}" class="text-sm text-emerald-600 dark:text-emerald-400 hover:underline font-medium">
                            Ver todos os {{ $carouselSlides->count() }} slides
                        </a>
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Nenhum slide cadastrado</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Comece criando seu primeiro slide do carousel</p>
                    <a href="{{ route('admin.carousel.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-indigo-800 transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span>Criar Primeiro Slide</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Tab Content: Content -->
<div id="tab-content-content" class="tab-content hidden">
    <form action="{{ route('admin.homepage.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-gray-900/50">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Conteúdo da Hero Section</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Edite o título e subtítulo da seção principal</p>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label for="hero_title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Título Principal
                    </label>
                    <input
                        type="text"
                        id="hero_title"
                        name="hero_title"
                        value="{{ $configs['hero_title'] }}"
                        class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                        placeholder="Secretaria Municipal de Agricultura"
                    >
                </div>
                <div>
                    <label for="hero_subtitle" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Subtítulo
                    </label>
                    <textarea
                        id="hero_subtitle"
                        name="hero_subtitle"
                        rows="3"
                        class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                        placeholder="Trabalhando pelo desenvolvimento rural sustentável..."
                    >{{ $configs['hero_subtitle'] }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <button
                type="submit"
                class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white rounded-xl font-semibold hover:from-emerald-700 hover:to-emerald-800 transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105"
            >
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
                <span>Salvar Alterações</span>
            </button>
        </div>
    </form>
</div>

<!-- Tab Content: Contact -->
<div id="tab-content-contact" class="tab-content hidden">
    <form action="{{ route('admin.homepage.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-gray-900/50">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Informações de Contato</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Configure as informações de contato exibidas na homepage</p>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label for="telefone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Telefone
                    </label>
                    <input
                        type="text"
                        id="telefone"
                        name="telefone"
                        value="{{ $configs['telefone'] }}"
                        class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                        placeholder="(75) 3248-2489"
                    >
                </div>
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        E-mail
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ $configs['email'] }}"
                        class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                        placeholder="gabinete@coracaodemaria.ba.gov.br"
                    >
                </div>
                <div>
                    <label for="endereco" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Endereço
                    </label>
                    <input
                        type="text"
                        id="endereco"
                        name="endereco"
                        value="{{ $configs['endereco'] }}"
                        class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                        placeholder="Praça Dr. Araújo Pinho, Centro - CEP 44250-000"
                    >
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <button
                type="submit"
                class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white rounded-xl font-semibold hover:from-emerald-700 hover:to-emerald-800 transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105"
            >
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
                <span>Salvar Alterações</span>
            </button>
        </div>
    </form>
</div>

<!-- Tab Content: Navbar -->
<div id="tab-content-navbar" class="tab-content hidden">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-gray-900/50">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Gerenciar Links do Navbar</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Ative ou desative links exibidos na barra de navegação</p>
        </div>
        <div class="p-6 space-y-4">
            @php
                $navbarLinks = [
                    'navbar_inicio' => ['name' => 'Início', 'icon' => 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25', 'description' => 'Link para a seção Início'],
                    'navbar_servicos' => ['name' => 'Serviços', 'icon' => 'M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z', 'description' => 'Link para a seção Serviços'],
                    'navbar_sobre' => ['name' => 'Sobre', 'icon' => 'M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z', 'description' => 'Link para a seção Sobre'],
                    'navbar_consulta' => ['name' => 'Consultar Demanda', 'icon' => 'M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z', 'description' => 'Link para consulta de demandas'],
                    'navbar_contato' => ['name' => 'Contato', 'icon' => 'M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z', 'description' => 'Link para a seção Contato'],
                ];
            @endphp

            @foreach($navbarLinks as $key => $link)
                @php
                    $enabled = isset($configs[$key . '_enabled']) ? (bool) $configs[$key . '_enabled'] : true;
                @endphp
                <div class="flex items-center justify-between p-4 rounded-xl border-2 border-gray-200 dark:border-slate-700 hover:border-emerald-300 dark:hover:border-emerald-700 transition-colors">
                    <div class="flex items-center gap-4 flex-1">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/30 dark:to-blue-800/30 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $link['icon'] }}" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-base font-bold text-gray-900 dark:text-white">{{ $link['name'] }}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $link['description'] }}</p>
                        </div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer ml-4">
                        <input
                            type="checkbox"
                            class="sr-only peer section-toggle"
                            data-section="{{ $key }}"
                            {{ $enabled ? 'checked' : '' }}
                            value="1"
                        >
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-300 dark:peer-focus:ring-emerald-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-emerald-600"></div>
                    </label>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Tab Content: Footer -->
<div id="tab-content-footer" class="tab-content hidden">
    <form action="{{ route('admin.homepage.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-gray-900/50">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Configurações do Footer</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Configure as informações exibidas no rodapé da homepage</p>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label for="footer_descricao" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Descrição do Footer
                    </label>
                    <textarea
                        id="footer_descricao"
                        name="footer_descricao"
                        rows="3"
                        class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                        placeholder="Secretaria Municipal de Agricultura de Coração de Maria - BA..."
                    >{{ $configs['footer_descricao'] ?? '' }}</textarea>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label for="footer_facebook_url" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            URL do Facebook
                        </label>
                        <input
                            type="url"
                            id="footer_facebook_url"
                            name="footer_facebook_url"
                            value="{{ $configs['footer_facebook_url'] ?? '' }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                            placeholder="https://www.facebook.com/..."
                        >
                    </div>
                    <div>
                        <label for="footer_instagram_url" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            URL do Instagram
                        </label>
                        <input
                            type="url"
                            id="footer_instagram_url"
                            name="footer_instagram_url"
                            value="{{ $configs['footer_instagram_url'] ?? '' }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                            placeholder="https://www.instagram.com/..."
                        >
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label for="footer_whatsapp" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            WhatsApp (apenas números)
                        </label>
                        <input
                            type="text"
                            id="footer_whatsapp"
                            name="footer_whatsapp"
                            value="{{ $configs['footer_whatsapp'] ?? '' }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                            placeholder="557532482489"
                        >
                    </div>
                    <div>
                        <label for="footer_site_prefeitura" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            URL do Site da Prefeitura
                        </label>
                        <input
                            type="url"
                            id="footer_site_prefeitura"
                            name="footer_site_prefeitura"
                            value="{{ $configs['footer_site_prefeitura'] ?? '' }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                            placeholder="https://www.coracaodemaria.ba.gov.br"
                        >
                    </div>
                </div>
            </div>
        </div>

        <!-- Informações da Vertex Solutions -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-gray-900/50">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Informações da Vertex Solutions</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Configure as informações da empresa desenvolvedora exibidas no rodapé</p>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label for="footer_vertex_company" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Nome da Empresa
                        </label>
                        <input
                            type="text"
                            id="footer_vertex_company"
                            name="footer_vertex_company"
                            value="{{ $configs['footer_vertex_company'] ?? 'Vertex Solutions LTDA' }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                            placeholder="Vertex Solutions LTDA"
                        >
                    </div>
                    <div>
                        <label for="footer_vertex_ceo" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            CEO / Desenvolvedor
                        </label>
                        <input
                            type="text"
                            id="footer_vertex_ceo"
                            name="footer_vertex_ceo"
                            value="{{ $configs['footer_vertex_ceo'] ?? 'Reinan Rodrigues' }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                            placeholder="Reinan Rodrigues"
                        >
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label for="footer_vertex_email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            E-mail
                        </label>
                        <input
                            type="email"
                            id="footer_vertex_email"
                            name="footer_vertex_email"
                            value="{{ $configs['footer_vertex_email'] ?? 'r.rodriguesjs@gmail.com' }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                            placeholder="r.rodriguesjs@gmail.com"
                        >
                    </div>
                    <div>
                        <label for="footer_vertex_phone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Telefone (apenas números)
                        </label>
                        <input
                            type="text"
                            id="footer_vertex_phone"
                            name="footer_vertex_phone"
                            value="{{ $configs['footer_vertex_phone'] ?? '75992034656' }}"
                            class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                            placeholder="75992034656"
                        >
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3">
            <button
                type="submit"
                class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white rounded-xl font-semibold hover:from-emerald-700 hover:to-emerald-800 transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105"
            >
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
                <span>Salvar Alterações</span>
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function showTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });

    // Remove active state from all tabs
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('border-emerald-500', 'text-emerald-600', 'dark:text-emerald-400');
        button.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
    });

    // Show selected tab content
    document.getElementById('tab-content-' + tabName).classList.remove('hidden');

    // Activate selected tab
    const activeTab = document.getElementById('tab-' + tabName);
    activeTab.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
    activeTab.classList.add('border-emerald-500', 'text-emerald-600', 'dark:text-emerald-400');
}

// Section toggle functionality
document.addEventListener('DOMContentLoaded', function() {
    const toggles = document.querySelectorAll('.section-toggle');

    toggles.forEach(toggle => {
        // Prevenir múltiplos cliques simultâneos
        let isProcessing = false;

        toggle.addEventListener('change', function() {
            if (isProcessing) {
                this.checked = !this.checked; // Reverter se já estiver processando
                return;
            }

            isProcessing = true;
            const section = this.dataset.section;
            const enabled = this.checked;
            const originalState = !enabled;

            // Desabilitar toggle durante requisição
            this.disabled = true;

            fetch('{{ route("admin.homepage.toggle-section") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    section: section,
                    enabled: enabled
                })
            })
            .then(async response => {
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    const text = await response.text();
                    throw new Error(`Resposta inválida: ${text.substring(0, 100)}`);
                }

                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({}));
                    throw new Error(errorData.message || `Erro HTTP ${response.status}`);
                }

                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Show notification
                    showNotification(data.message, 'success');
                } else {
                    // Revert toggle on error
                    this.checked = originalState;
                    showNotification(data.message || 'Erro ao atualizar seção', 'error');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                // Revert toggle on error
                this.checked = originalState;
                showNotification('Erro ao atualizar seção. Tente novamente.', 'error');
            })
            .finally(() => {
                isProcessing = false;
                this.disabled = false;
            });
        });
    });

    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `fixed top-20 right-4 px-6 py-3 rounded-xl shadow-lg z-50 animate-in slide-in-from-right ${
            type === 'success'
                ? 'bg-emerald-500 text-white'
                : 'bg-red-500 text-white'
        }`;
        notification.textContent = message;
        document.body.appendChild(notification);
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transition = 'opacity 0.3s';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
});
</script>
@endpush
</div>
@endsection






