@extends('admin.layouts.admin')

@section('title', 'Gerenciar Homepage')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2 font-poppins">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-module-icon module="homepage" class="w-6 h-6 md:w-7 md:h-7 text-white" style="duotone" />
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
            <a href="{{ route('homepage') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-all shadow-md hover:shadow-lg">
                <x-icon name="arrow-up-right-from-square" class="w-5 h-5" style="duotone" />
                <span>Visualizar Site</span>
            </a>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex overflow-x-auto pb-2 gap-2 hide-scrollbar">
        <button onclick="showTab('sections')" id="tab-sections" class="tab-button flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 whitespace-nowrap bg-white dark:bg-slate-800 border-2 border-emerald-500 text-emerald-700 dark:text-emerald-400 shadow-sm">
            <x-icon name="layer-group" class="w-4 h-4" style="duotone" />
            Seções
        </button>
        <button onclick="showTab('carousel')" id="tab-carousel" class="tab-button flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 whitespace-nowrap bg-white dark:bg-slate-800 border-2 border-transparent text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-slate-700">
            <x-icon name="images" class="w-4 h-4" style="duotone" />
            Carousel
        </button>
        <button onclick="showTab('content')" id="tab-content" class="tab-button flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 whitespace-nowrap bg-white dark:bg-slate-800 border-2 border-transparent text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-slate-700">
            <x-icon name="pen-to-square" class="w-4 h-4" style="duotone" />
            Conteúdo Hero
        </button>
        <button onclick="showTab('contact')" id="tab-contact" class="tab-button flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 whitespace-nowrap bg-white dark:bg-slate-800 border-2 border-transparent text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-slate-700">
            <x-icon name="address-book" class="w-4 h-4" style="duotone" />
            Contato
        </button>
        <button onclick="showTab('navbar')" id="tab-navbar" class="tab-button flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 whitespace-nowrap bg-white dark:bg-slate-800 border-2 border-transparent text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-slate-700">
            <x-icon name="bars" class="w-4 h-4" style="duotone" />
            Menu Navbar
        </button>
        <button onclick="showTab('footer')" id="tab-footer" class="tab-button flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 whitespace-nowrap bg-white dark:bg-slate-800 border-2 border-transparent text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-slate-700">
            <x-icon name="shoe-prints" class="w-4 h-4" style="duotone" />
            Footer
        </button>
    </div>

    <!-- Tab Content: Sections -->
    <div id="tab-content-sections" class="tab-content">
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-gray-900/50 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white font-poppins">Gerenciar Seções da Homepage</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Ative ou desative seções da página inicial</p>
                </div>
            </div>
            <div class="p-6">
                @php
                $sections = [
                    'carousel' => ['name' => 'Carousel', 'icon' => 'images', 'description' => 'Exibe slides rotativos no topo da página', 'special' => true],
                    'hero' => ['name' => 'Hero Section', 'icon' => 'billboard', 'description' => 'Seção principal com título e descrição'],
                    'servicos' => ['name' => 'Seção de Serviços', 'icon' => 'briefcase', 'description' => 'Exibe os serviços oferecidos pela secretaria'],
                    'sobre' => ['name' => 'Sobre a SEMAGRI', 'icon' => 'circle-info', 'description' => 'Informações sobre a secretaria'],
                    'servicos_publicos' => ['name' => 'Serviços Públicos', 'icon' => 'building-columns', 'description' => 'Links para serviços públicos online'],
                    'contato' => ['name' => 'Seção de Contato', 'icon' => 'address-card', 'description' => 'Informações de contato da secretaria'],
                ];
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($sections as $key => $section)
                        @php
                            // Garantir valor booleano correto
                            if ($key === 'carousel') {
                                $enabled = (bool) $carouselEnabled;
                            } else {
                                $enabled = isset($configs[$key . '_enabled']) ? (bool) $configs[$key . '_enabled'] : true;
                            }
                        @endphp
                        <div class="flex items-center justify-between p-4 rounded-2xl border-2 border-gray-100 dark:border-slate-700 hover:border-emerald-300 dark:hover:border-emerald-700 transition-colors bg-gray-50/50 dark:bg-slate-800/50">
                            <div class="flex items-center gap-4 flex-1">
                                <div class="w-12 h-12 bg-gradient-to-br from-emerald-100 to-emerald-200 dark:from-emerald-900/30 dark:to-emerald-800/30 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <x-icon name="{{ $section['icon'] }}" class="w-6 h-6 text-emerald-600 dark:text-emerald-400" style="duotone" />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-base font-bold text-gray-900 dark:text-white">{{ $section['name'] }}</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $section['description'] }}</p>
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
    </div>

    <!-- Tab Content: Carousel -->
    <div id="tab-content-carousel" class="tab-content hidden">
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden mb-6">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-gray-900/50">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white font-poppins">Gerenciar Carousel</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Gerencie os slides do carousel da homepage</p>
                    </div>
                    <a href="{{ route('admin.carousel.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-indigo-800 transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5">
                        <x-icon name="images" class="w-5 h-5" />
                        <span>Gerenciar Slides</span>
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if($carouselSlides->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($carouselSlides->take(6) as $slide)
                            <div class="relative rounded-2xl overflow-hidden border border-gray-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow">
                                @if($slide->image && $slide->show_image)
                                    <img src="{{ asset('storage/' . $slide->image) }}" alt="{{ $slide->title ?? 'Slide' }}" class="w-full h-40 object-cover">
                                @else
                                    <div class="w-full h-40 bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center">
                                        <x-icon name="image" class="w-12 h-12 text-white/50" />
                                    </div>
                                @endif
                                <div class="p-4 bg-white dark:bg-slate-800">
                                    <div class="text-sm font-bold text-gray-900 dark:text-white truncate">
                                    {!! $slide->title ?? 'Sem título' !!}
                                </div>
                                    <div class="flex items-center justify-between mt-3">
                                        <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $slide->is_active ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                            {{ $slide->is_active ? 'Ativo' : 'Inativo' }}
                                        </span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 font-mono">#{{ $slide->order }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if($carouselSlides->count() > 6)
                        <div class="mt-6 text-center">
                            <a href="{{ route('admin.carousel.index') }}" class="text-sm text-emerald-600 dark:text-emerald-400 hover:underline font-medium">
                                Ver todos os {{ $carouselSlides->count() }} slides
                            </a>
                        </div>
                    @endif
                @else
                    <div class="text-center py-12">
                        <div class="w-20 h-20 bg-gray-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <x-icon name="images" class="w-10 h-10 text-gray-400 dark:text-gray-500" style="duotone" />
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Nenhum slide cadastrado</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6 max-w-sm mx-auto">O carousel aparecerá vazio. Adicione banners para destacar informações importantes.</p>
                        <a href="{{ route('admin.carousel.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-indigo-800 transition-all duration-300 shadow-md hover:shadow-lg">
                            <x-icon name="plus" class="w-5 h-5" />
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

            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-gray-900/50">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white font-poppins">Conteúdo da Hero Section</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Edite o título e subtítulo da seção principal</p>
                </div>
                <div class="p-6 space-y-5">
                    <div>
                        <label for="hero_title" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Título Principal
                        </label>
                        <input
                            type="text"
                            id="hero_title"
                            name="hero_title"
                            value="{{ $configs['hero_title'] }}"
                            class="w-full px-4 py-3 border-2 border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-700/50 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all font-medium"
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
                            class="w-full px-4 py-3 border-2 border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-700/50 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                            placeholder="Trabalhando pelo desenvolvimento rural sustentável..."
                        >{{ $configs['hero_subtitle'] }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white rounded-xl font-semibold hover:from-emerald-700 hover:to-emerald-800 transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5"
                >
                    <x-icon name="floppy-disk" class="w-5 h-5" />
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

            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-gray-900/50">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white font-poppins">Informações de Contato</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Configure as informações de contato exibidas na homepage</p>
                </div>
                <div class="p-6 space-y-5">
                    <div>
                        <label for="telefone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Telefone
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <x-icon name="phone" class="w-5 h-5 text-gray-400" />
                            </div>
                            <input
                                type="text"
                                id="telefone"
                                name="telefone"
                                value="{{ $configs['telefone'] }}"
                                class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-700/50 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                                placeholder="(75) 3248-2489"
                            >
                        </div>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            E-mail
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <x-icon name="envelope" class="w-5 h-5 text-gray-400" />
                            </div>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ $configs['email'] }}"
                                class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-700/50 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                                placeholder="gabinete@coracaodemaria.ba.gov.br"
                            >
                        </div>
                    </div>
                    <div>
                        <label for="endereco" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Endereço
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <x-icon name="map-location-dot" class="w-5 h-5 text-gray-400" />
                            </div>
                            <input
                                type="text"
                                id="endereco"
                                name="endereco"
                                value="{{ $configs['endereco'] }}"
                                class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-700/50 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                                placeholder="Praça Dr. Araújo Pinho, Centro - CEP 44250-000"
                            >
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white rounded-xl font-semibold hover:from-emerald-700 hover:to-emerald-800 transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5"
                >
                    <x-icon name="floppy-disk" class="w-5 h-5" />
                    <span>Salvar Alterações</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Tab Content: Navbar -->
    <div id="tab-content-navbar" class="tab-content hidden">
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-gray-900/50">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white font-poppins">Gerenciar Links do Navbar</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Ative ou desative links exibidos na barra de navegação</p>
            </div>
            <div class="p-6">
                @php
                $navbarLinks = [
                    'navbar_inicio' => ['name' => 'Início', 'icon' => 'house', 'description' => 'Link para a seção Início'],
                    'navbar_servicos' => ['name' => 'Serviços', 'icon' => 'briefcase', 'description' => 'Link para a seção Serviços'],
                    'navbar_sobre' => ['name' => 'Sobre', 'icon' => 'circle-info', 'description' => 'Link para a seção Sobre'],
                    'navbar_consulta' => ['name' => 'Consultar Demanda', 'icon' => 'magnifying-glass', 'description' => 'Link para consulta de demandas'],
                    'navbar_contato' => ['name' => 'Contato', 'icon' => 'address-book', 'description' => 'Link para a seção Contato'],
                ];
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($navbarLinks as $key => $link)
                        @php
                            $enabled = isset($configs[$key . '_enabled']) ? (bool) $configs[$key . '_enabled'] : true;
                        @endphp
                        <div class="flex items-center justify-between p-4 rounded-2xl border-2 border-gray-100 dark:border-slate-700 hover:border-blue-300 dark:hover:border-blue-700 transition-colors bg-gray-50/50 dark:bg-slate-800/50">
                            <div class="flex items-center gap-4 flex-1">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/30 dark:to-blue-800/30 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <x-icon name="{{ $link['icon'] }}" class="w-6 h-6 text-blue-600 dark:text-blue-400" style="duotone" />
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-base font-bold text-gray-900 dark:text-white">{{ $link['name'] }}</h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $link['description'] }}</p>
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
    </div>

    <!-- Tab Content: Footer -->
    <div id="tab-content-footer" class="tab-content hidden">
        <form action="{{ route('admin.homepage.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-gray-900/50">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white font-poppins">Configurações do Footer</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Configure as informações exibidas no rodapé da homepage</p>
                </div>
                <div class="p-6 space-y-5">
                    <div>
                        <label for="footer_descricao" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Descrição do Footer
                        </label>
                        <textarea
                            id="footer_descricao"
                            name="footer_descricao"
                            rows="3"
                            class="w-full px-4 py-3 border-2 border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-700/50 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                            placeholder="Secretaria Municipal de Agricultura de Coração de Maria - BA..."
                        >{{ $configs['footer_descricao'] ?? '' }}</textarea>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label for="footer_facebook_url" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                URL do Facebook
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-icon name="facebook" class="w-5 h-5 text-gray-400" style="brands" />
                                </div>
                                <input
                                    type="url"
                                    id="footer_facebook_url"
                                    name="footer_facebook_url"
                                    value="{{ $configs['footer_facebook_url'] ?? '' }}"
                                    class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-700/50 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                                    placeholder="https://www.facebook.com/..."
                                >
                            </div>
                        </div>
                        <div>
                            <label for="footer_instagram_url" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                URL do Instagram
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-icon name="instagram" class="w-5 h-5 text-gray-400" style="brands" />
                                </div>
                                <input
                                    type="url"
                                    id="footer_instagram_url"
                                    name="footer_instagram_url"
                                    value="{{ $configs['footer_instagram_url'] ?? '' }}"
                                    class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-700/50 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                                    placeholder="https://www.instagram.com/..."
                                >
                            </div>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label for="footer_whatsapp" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                WhatsApp (apenas números)
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-icon name="whatsapp" class="w-5 h-5 text-gray-400" style="brands" />
                                </div>
                                <input
                                    type="text"
                                    id="footer_whatsapp"
                                    name="footer_whatsapp"
                                    value="{{ $configs['footer_whatsapp'] ?? '' }}"
                                    class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-700/50 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                                    placeholder="557532482489"
                                >
                            </div>
                        </div>
                        <div>
                            <label for="footer_site_prefeitura" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                URL do Site da Prefeitura
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <x-icon name="globe" class="w-5 h-5 text-gray-400" />
                                </div>
                                <input
                                    type="url"
                                    id="footer_site_prefeitura"
                                    name="footer_site_prefeitura"
                                    value="{{ $configs['footer_site_prefeitura'] ?? '' }}"
                                    class="w-full pl-10 pr-4 py-3 border-2 border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-700/50 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                                    placeholder="https://www.coracaodemaria.ba.gov.br"
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informações da Vertex Solutions -->
            <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-gray-900/50">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white font-poppins">Informações da Vertex Solutions</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Configure as informações da empresa desenvolvedora exibidas no rodapé</p>
                </div>
                <div class="p-6 space-y-5">
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
                                class="w-full px-4 py-3 border-2 border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-700/50 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
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
                                class="w-full px-4 py-3 border-2 border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-700/50 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
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
                                class="w-full px-4 py-3 border-2 border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-700/50 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
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
                                class="w-full px-4 py-3 border-2 border-gray-200 dark:border-slate-600 rounded-xl bg-gray-50 dark:bg-slate-700/50 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all"
                                placeholder="75992034656"
                            >
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <button
                    type="submit"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white rounded-xl font-semibold hover:from-emerald-700 hover:to-emerald-800 transition-all duration-300 shadow-md hover:shadow-lg hover:-translate-y-0.5"
                >
                    <x-icon name="floppy-disk" class="w-5 h-5" />
                    <span>Salvar Alterações</span>
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
    function showTab(tabName) {
        // Save to localStorage
        localStorage.setItem('homepage_active_tab', tabName);

        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.add('hidden');
        });

        // Remove active state from all tabs
        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('border-emerald-500', 'text-emerald-600', 'dark:text-emerald-400', 'bg-white', 'dark:bg-slate-800');
            button.classList.add('border-transparent', 'text-gray-600', 'dark:text-gray-400');
        });

        // Show selected tab content
        document.getElementById('tab-content-' + tabName).classList.remove('hidden');

        // Activate selected tab
        const activeTab = document.getElementById('tab-' + tabName);
        activeTab.classList.remove('border-transparent', 'text-gray-600', 'dark:text-gray-400');
        activeTab.classList.add('border-emerald-500', 'text-emerald-600', 'dark:text-emerald-400', 'bg-white', 'dark:bg-slate-800');
    }

    // Section toggle functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Restore active tab
        const activeTab = localStorage.getItem('homepage_active_tab') || 'sections';
        showTab(activeTab);

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
            notification.className = `fixed top-24 right-4 px-6 py-4 rounded-xl shadow-xl z-50 animate-in slide-in-from-right flex items-center gap-3 border ${
                type === 'success'
                    ? 'bg-white dark:bg-gray-800 border-emerald-500 text-emerald-800 dark:text-emerald-400'
                    : 'bg-white dark:bg-gray-800 border-red-500 text-red-800 dark:text-red-400'
            }`;

            const icon = type === 'success'
                ? '<i class="fa-duotone fa-check-circle text-xl"></i>'
                : '<i class="fa-duotone fa-triangle-exclamation text-xl"></i>';

            notification.innerHTML = `${icon} <span class="font-medium">${message}</span>`;

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
