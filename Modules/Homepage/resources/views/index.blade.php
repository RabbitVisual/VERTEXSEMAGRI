@extends('homepage::layouts.homepage')

@section('title', 'Secretaria Municipal de Agricultura - SEMAGRI')

@section('content')
@include('homepage::layouts.navbar-homepage')

<div class="min-h-screen bg-gradient-to-br from-emerald-50 via-white to-green-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
    <!-- Avisos no Topo -->
    @if(\Nwidart\Modules\Facades\Module::isEnabled('Avisos'))
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <x-avisos::avisos-por-posicao posicao="topo" />
        </div>
    @endif

    <!-- Carousel Section -->
    @if($carouselEnabled && $carouselSlides->count() > 0)
    <section class="relative overflow-hidden bg-gradient-to-br from-emerald-600 via-teal-600 to-green-600">
        <div data-hs-carousel='{
            "loadingClasses": "opacity-0",
            "isAutoPlay": true,
            "speed": 5000,
            "isInfiniteLoop": true
        }' class="relative" id="homepageCarousel">
            <div class="hs-carousel relative overflow-hidden w-full h-[400px] md:h-[500px] lg:h-[600px]">
                <div class="hs-carousel-body absolute top-0 bottom-0 start-0 flex flex-nowrap transition-transform duration-700" style="opacity: 1;">
                    @foreach($carouselSlides as $index => $slide)
                        <div class="hs-carousel-slide flex-shrink-0 w-full h-full">
                            <div class="relative w-full h-full flex items-center justify-center">
                                @if($slide->show_image && $slide->image)
                                    <div class="absolute inset-0 w-full h-full">
                                        <img src="{{ asset('storage/' . $slide->image) }}"
                                             alt="{{ $slide->title ?? 'Slide ' . ($index + 1) }}"
                                             class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-gradient-to-r from-emerald-900/80 via-emerald-800/70 to-teal-900/80"></div>
                                    </div>
                                @else
                                    <div class="absolute inset-0 w-full h-full bg-gradient-to-br from-emerald-600 via-teal-600 to-green-600"></div>
                                @endif

                                <div class="relative z-10 w-full container mx-auto px-4 py-12 md:py-16 lg:py-20 text-center text-white">
                                    <div class="max-w-4xl mx-auto space-y-6">
                                        @if($slide->title)
                                            @php
                                                $titleContent = $slide->title;
                                                $styleTags = '';
                                                $scriptTags = '';

                                                if (preg_match_all('/<style[^>]*>.*?<\/style>/is', $titleContent, $styleMatches)) {
                                                    $styleTags = implode("\n", $styleMatches[0]);
                                                    $titleContent = preg_replace('/<style[^>]*>.*?<\/style>/is', '', $titleContent);
                                                }

                                                if (preg_match_all('/<script[^>]*>.*?<\/script>/is', $titleContent, $scriptMatches)) {
                                                    $scriptTags = implode("\n", $scriptMatches[0]);
                                                    $titleContent = preg_replace('/<script[^>]*>.*?<\/script>/is', '', $titleContent);
                                                }

                                                $titleContent = preg_replace('/<p[^>]*>\s*<\/p>/i', '', $titleContent);
                                                $titleContent = preg_replace('/<p[^>]*>(\s*<br\s*\/?>\s*)*<\/p>/i', '', $titleContent);
                                                $titleContent = preg_replace('/<p[^>]*>(.*?)<\/p>/is', '$1', $titleContent);
                                                $titleContent = trim($titleContent);
                                            @endphp
                                            @if($styleTags)
                                                {!! $styleTags !!}
                                            @endif
                                            <div class="text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold leading-tight carousel-title">
                                                {!! $titleContent !!}
                                            </div>
                                            @if($scriptTags)
                                                {!! $scriptTags !!}
                                            @endif
                                        @endif

                                        @if($slide->description)
                                            @php
                                                $descContent = $slide->description;
                                                $descStyleTags = '';
                                                $descScriptTags = '';

                                                if (preg_match_all('/<style[^>]*>.*?<\/style>/is', $descContent, $descStyleMatches)) {
                                                    $descStyleTags = implode("\n", $descStyleMatches[0]);
                                                    $descContent = preg_replace('/<style[^>]*>.*?<\/style>/is', '', $descContent);
                                                }

                                                if (preg_match_all('/<script[^>]*>.*?<\/script>/is', $descContent, $descScriptMatches)) {
                                                    $descScriptTags = implode("\n", $descScriptMatches[0]);
                                                    $descContent = preg_replace('/<script[^>]*>.*?<\/script>/is', '', $descContent);
                                                }

                                                $descContent = preg_replace('/<p[^>]*>\s*<\/p>/i', '', $descContent);
                                                $descContent = preg_replace('/<p[^>]*>(\s*<br\s*\/?>\s*)*<\/p>/i', '', $descContent);
                                                $descContent = preg_replace('/<p[^>]*>(.*?)<\/p>/is', '$1<br>', $descContent);
                                                $descContent = preg_replace('/(<br\s*\/?>\s*)+$/i', '', $descContent);
                                                $descContent = trim($descContent);
                                            @endphp
                                            @if($descStyleTags)
                                                {!! $descStyleTags !!}
                                            @endif
                                            <div class="text-lg md:text-xl lg:text-2xl text-white/95 leading-relaxed carousel-description">
                                                {!! $descContent !!}
                                            </div>
                                            @if($descScriptTags)
                                                {!! $descScriptTags !!}
                                            @endif
                                        @endif

                                        @if($slide->link)
                                            <div class="pt-4">
                                                <a href="{{ $slide->link }}"
                                                   target="{{ str_starts_with($slide->link, 'http') ? '_blank' : '_self' }}"
                                                   class="inline-flex items-center gap-2 bg-white text-emerald-600 px-8 py-4 rounded-xl font-semibold hover:bg-yellow-50 hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                                                    <span>{{ $slide->link_text ?? 'Saiba mais' }}</span>
                                                    <x-icon name="arrow-right" class="w-5 h-5" />
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Navigation Buttons -->
            <button type="button" class="hs-carousel-prev absolute top-1/2 start-4 -translate-y-1/2 w-12 h-12 md:w-14 md:h-14 bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 shadow-lg z-10">
                <span class="sr-only">Anterior</span>
                <x-icon name="chevron-left" class="w-6 h-6 md:w-7 md:h-7" />
            </button>

            <button type="button" class="hs-carousel-next absolute top-1/2 end-4 -translate-y-1/2 w-12 h-12 md:w-14 md:h-14 bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 shadow-lg z-10">
                <span class="sr-only">Próximo</span>
                <x-icon name="chevron-right" class="w-6 h-6 md:w-7 md:h-7" />
            </button>

            <!-- Pagination -->
            <div class="hs-carousel-pagination flex justify-center gap-2 absolute bottom-4 start-0 end-0 z-10">
                @foreach($carouselSlides as $index => $slide)
                    <span class="hs-carousel-pagination-item w-2.5 h-2.5 rounded-full bg-white/50 hover:bg-white/80 transition-colors cursor-pointer"></span>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Hero Section -->
    @if($configs['hero_enabled'] ?? true)
    <section id="inicio" class="relative overflow-hidden bg-gradient-to-br from-emerald-600 via-teal-600 to-green-600 py-16 lg:py-24 {{ ($carouselEnabled && $carouselSlides->count() > 0) ? 'hidden' : '' }}">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.4\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 60px 60px;"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Hero Content -->
                <div class="text-white space-y-6 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm px-5 py-2.5 rounded-full text-sm font-medium">
                        <x-icon name="award" style="duotone" class="w-5 h-5" />
                        <span>Prefeitura Municipal de Coração de Maria - BA</span>
                    </div>

                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold font-poppins leading-tight">
                        {{ $configs['hero_title'] ?? 'Secretaria Municipal de Agricultura' }}
                    </h1>

                    <p class="text-lg md:text-xl text-white/95 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        {{ $configs['hero_subtitle'] ?? 'Trabalhando pelo desenvolvimento rural sustentável e o fortalecimento da agricultura familiar em nosso município.' }}
                    </p>

                    <div class="flex flex-wrap gap-3 sm:gap-4 pt-4 justify-center lg:justify-start">
                        <a href="{{ route('portal.index') }}" class="group inline-flex items-center gap-2 bg-white text-emerald-600 px-5 sm:px-8 py-3 sm:py-4 rounded-xl font-semibold hover:bg-yellow-50 hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl text-sm sm:text-base">
                            <x-icon name="chart-mixed" style="duotone" class="w-4 h-4 sm:w-5 sm:h-5" />
                            <span class="hidden xs:inline">Portal de Transparência</span>
                            <span class="xs:hidden">Transparência</span>
                        </a>

                        @if(\Nwidart\Modules\Facades\Module::isEnabled('Blog'))
                        <a href="{{ route('blog.index') }}" class="group inline-flex items-center gap-2 bg-white text-emerald-600 px-5 sm:px-8 py-3 sm:py-4 rounded-xl font-semibold hover:bg-blue-50 hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl text-sm sm:text-base">
                            <x-icon name="newspaper" style="duotone" class="w-4 h-4 sm:w-5 sm:h-5" />
                            <span class="hidden xs:inline">Blog & Notícias</span>
                            <span class="xs:hidden">Blog</span>
                        </a>
                        @endif
                        <a href="{{ route('demandas.public.consulta') }}" class="group inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm text-white border-2 border-white/30 px-5 sm:px-8 py-3 sm:py-4 rounded-xl font-semibold hover:bg-white/20 hover:scale-105 transition-all duration-300 text-sm sm:text-base">
                            <x-icon name="magnifying-glass" style="duotone" class="w-4 h-4 sm:w-5 sm:h-5" />
                            <span class="hidden xs:inline">Consultar Demanda</span>
                            <span class="xs:hidden">Demandas</span>
                        </a>
                        <a href="#servicos" class="group inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm text-white border-2 border-white/30 px-5 sm:px-8 py-3 sm:py-4 rounded-xl font-semibold hover:bg-white/20 hover:scale-105 transition-all duration-300 text-sm sm:text-base">
                            <x-icon name="grid-2" style="duotone" class="w-4 h-4 sm:w-5 sm:h-5" />
                            <span class="hidden xs:inline">Nossos Serviços</span>
                            <span class="xs:hidden">Serviços</span>
                        </a>
                    </div>

                    <!-- Contato Rápido -->
                    <div class="flex flex-wrap gap-6 pt-6 text-white/90 justify-center lg:justify-start">
                        <div class="flex items-center gap-2">
                            <x-icon name="phone" style="duotone" class="w-5 h-5 text-green-200" />
                            <span class="text-sm">(75) 3248-2489</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-icon name="envelope" style="duotone" class="w-5 h-5 text-green-200" />
                            <span class="text-sm">gabinete@coracaodemaria.ba.gov.br</span>
                        </div>
                    </div>
                </div>

                <!-- Hero Image/Logo -->
                <div class="hidden lg:block animate-float">
                    <div class="relative">
                        <img src="{{ asset('images/logo-vertex-full.svg') }}"
                             alt="SEMAGRI - Secretaria Municipal de Agricultura"
                             class="w-full max-w-lg mx-auto drop-shadow-2xl">
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Avisos no Meio -->
    @if(\Nwidart\Modules\Facades\Module::isEnabled('Avisos'))
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <x-avisos::avisos-por-posicao posicao="meio" />
        </div>
    @endif

    <!-- Serviços Section -->
    @if($configs['servicos_enabled'] ?? true)
    <section id="servicos" class="py-20 bg-gradient-to-br from-gray-50 via-white to-emerald-50/30 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                    <x-icon name="shield-check" style="duotone" class="w-4 h-4" />
                    Serviços ao Cidadão
                </div>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold font-poppins text-gray-900 dark:text-white mb-4">
                    O Que Fazemos Por Você
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto leading-relaxed">
                    Nossa secretaria oferece diversos serviços para apoiar os produtores rurais e o desenvolvimento do campo
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                <!-- Atendimento de Demandas -->
                <div class="group relative bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-2 border-emerald-100 dark:border-emerald-900/50 hover:border-emerald-300 dark:hover:border-emerald-700 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-100/50 to-transparent dark:from-emerald-900/20 rounded-bl-full"></div>
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <x-module-icon module="demandas" class="w-8 h-8 text-white" />
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            Atendimento de Demandas
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300 mb-5 leading-relaxed text-sm">
                            Você pode solicitar serviços como reparos de estradas, instalação de pontos de água, manutenção de poços e muito mais. Acompanhe sua solicitação em tempo real.
                        </p>
                        <ul class="space-y-2.5 mb-6">
                            <li class="flex items-start gap-2.5">
                                <x-icon name="check-circle" style="duotone" class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Solicite melhorias na sua região</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <x-icon name="check-circle" class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Acompanhe o status da sua solicitação</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <x-icon name="check-circle" class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Receba notificações por e-mail</span>
                            </li>
                        </ul>
                        <a href="{{ route('demandas.public.consulta') }}" class="inline-flex items-center gap-2 text-emerald-600 dark:text-emerald-400 font-semibold hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors group-hover:gap-3">
                            <span>Consultar minha demanda</span>
                            <x-icon name="arrow-right" style="duotone" class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                        </a>
                    </div>
                </div>

                <!-- Infraestrutura Rural -->
                <div class="group relative bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-2 border-blue-100 dark:border-blue-900/50 hover:border-blue-300 dark:hover:border-blue-700 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-100/50 to-transparent dark:from-blue-900/20 rounded-bl-full"></div>
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <x-icon name="building-columns" style="duotone" class="w-8 h-8 text-white" />
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            Infraestrutura Rural
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300 mb-5 leading-relaxed text-sm">
                            Cuidamos da manutenção e melhorias da infraestrutura rural, incluindo estradas vicinais, pontos de água, poços artesianos e iluminação pública.
                        </p>
                        <ul class="space-y-2.5 mb-6">
                            <li class="flex items-start gap-2.5">
                                <x-icon name="road" style="duotone" class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Manutenção de estradas e vicinais</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <x-icon name="faucet-drip" style="duotone" class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Gestão de poços artesianos</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <x-icon name="droplet" style="duotone" class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Rede de distribuição de água</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <x-icon name="lightbulb" style="duotone" class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Iluminação pública</span>
                            </li>
                        </ul>
                        <a href="{{ route('portal.index') }}" class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 font-semibold hover:text-blue-700 dark:hover:text-blue-300 transition-colors group-hover:gap-3">
                            <span>Ver infraestrutura disponível</span>
                            <x-icon name="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                        </a>
                    </div>
                </div>

                <!-- Agricultura Familiar -->
                <div class="group relative bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-2 border-amber-100 dark:border-amber-900/50 hover:border-amber-300 dark:hover:border-amber-700 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-amber-100/50 to-transparent dark:from-amber-900/20 rounded-bl-full"></div>
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <x-icon name="tractor" style="duotone" class="w-8 h-8 text-white" />
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            Apoio à Agricultura Familiar
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300 mb-5 leading-relaxed text-sm">
                            Promovemos programas e ações para fortalecer a agricultura familiar, garantindo apoio técnico e fomento à produção sustentável.
                        </p>
                        <ul class="space-y-2.5 mb-6">
                            <li class="flex items-start gap-2.5">
                                <x-icon name="check-circle" class="w-5 h-5 text-amber-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Programas de fomento</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <x-icon name="check-circle" class="w-5 h-5 text-amber-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Assistência técnica</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <x-icon name="check-circle" class="w-5 h-5 text-amber-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Articulação de parcerias</span>
                            </li>
                        </ul>
                        @if(\Nwidart\Modules\Facades\Module::isEnabled('ProgramasAgricultura'))
                        <a href="{{ route('portal.agricultor.index') }}" class="inline-flex items-center gap-2 text-amber-600 dark:text-amber-400 font-semibold hover:text-amber-700 dark:hover:text-amber-300 transition-colors group-hover:gap-3">
                            <span>Ver programas disponíveis</span>
                            <x-icon name="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Desenvolvimento Rural -->
                <div class="group relative bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-2 border-green-100 dark:border-green-900/50 hover:border-green-300 dark:hover:border-green-700 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-green-100/50 to-transparent dark:from-green-900/20 rounded-bl-full"></div>
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <x-icon name="seedling" style="duotone" class="w-8 h-8 text-white" />
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            Desenvolvimento Rural Sustentável
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300 mb-5 leading-relaxed text-sm">
                            Promovemos o desenvolvimento rural com foco na sustentabilidade, fortalecendo a agricultura familiar e melhorando a qualidade de vida no campo.
                        </p>
                        <ul class="space-y-2.5 mb-6">
                            <li class="flex items-start gap-2.5">
                                <x-icon name="check-circle" class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Fortalecimento da agricultura familiar</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <x-icon name="check-circle" class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Práticas agrícolas sustentáveis</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <x-icon name="check-circle" class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Melhoria da qualidade de vida rural</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Programas Governamentais -->
                <div class="group relative bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-2 border-purple-100 dark:border-purple-900/50 hover:border-purple-300 dark:hover:border-purple-700 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-100/50 to-transparent dark:from-purple-900/20 rounded-bl-full"></div>
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <x-icon name="briefcase" style="duotone" class="w-8 h-8 text-white" />
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            Programas e Projetos
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300 mb-5 leading-relaxed text-sm">
                            Articulamos programas governamentais que beneficiam os produtores rurais, como o Seguro Safra e parcerias para comercialização.
                        </p>
                        <ul class="space-y-2.5 mb-6">
                            <li class="flex items-start gap-2.5">
                                <x-icon name="check-circle" class="w-5 h-5 text-purple-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Seguro Safra</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <x-icon name="check-circle" class="w-5 h-5 text-purple-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Parcerias comerciais</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <x-icon name="check-circle" class="w-5 h-5 text-purple-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Doação de equipamentos</span>
                            </li>
                        </ul>
                        @if(\Nwidart\Modules\Facades\Module::isEnabled('ProgramasAgricultura'))
                        <a href="{{ route('portal.agricultor.programas') }}" class="inline-flex items-center gap-2 text-purple-600 dark:text-purple-400 font-semibold hover:text-purple-700 dark:hover:text-purple-300 transition-colors group-hover:gap-3">
                            <span>Ver todos os programas</span>
                            <x-icon name="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Cadastro e Documentação -->
                <div class="group relative bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-2 border-cyan-100 dark:border-cyan-900/50 hover:border-cyan-300 dark:hover:border-cyan-700 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-cyan-100/50 to-transparent dark:from-cyan-900/20 rounded-bl-full"></div>
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-cyan-500 to-teal-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <x-icon name="address-card" style="duotone" class="w-8 h-8 text-white" />
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            Cadastros e Documentação
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300 mb-5 leading-relaxed text-sm">
                            Oferecemos atendimento itinerante para emissão e renovação de cadastros agrícolas, facilitando o acesso aos serviços para produtores rurais em todas as localidades do município.
                        </p>
                        <ul class="space-y-2.5 mb-6">
                            <li class="flex items-start gap-2.5">
                                <x-icon name="check-circle" class="w-5 h-5 text-cyan-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Emissão de cadastros</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <x-icon name="check-circle" class="w-5 h-5 text-cyan-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Renovação de documentação</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <x-icon name="check-circle" class="w-5 h-5 text-cyan-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Atendimento itinerante</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Sobre a SEMAGRI -->
    @if($configs['sobre_enabled'] ?? true)
    <section id="sobre" class="py-20 bg-gradient-to-br from-slate-50 to-gray-100 dark:from-slate-800 dark:to-slate-900">
        <div class="container mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="relative order-2 lg:order-1">
                    <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl p-8 shadow-2xl">
                        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 space-y-4">
                            <div class="flex items-center gap-3 text-white">
                                <x-icon name="goal" style="duotone" class="w-8 h-8" />
                                <div>
                                    <h4 class="font-bold text-lg">Missão</h4>
                                    <p class="text-sm text-white/90">Desenvolver políticas públicas para fortalecer a agricultura familiar e garantir a sustentabilidade</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 text-white">
                                <x-icon name="eye" style="duotone" class="w-8 h-8" />
                                <div>
                                    <h4 class="font-bold text-lg">Visão</h4>
                                    <p class="text-sm text-white/90">Ser referência em desenvolvimento rural sustentável na região</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 text-white">
                                <x-icon name="heart" style="duotone" class="w-8 h-8" />
                                <div>
                                    <h4 class="font-bold text-lg">Valores</h4>
                                    <p class="text-sm text-white/90">Sustentabilidade, transparência e compromisso com o campo</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6 order-1 lg:order-2">
                    <div class="inline-flex items-center gap-2 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 px-4 py-2 rounded-full text-sm font-semibold">
                        <x-icon name="circle-info" style="duotone" class="w-4 h-4" />
                        Sobre Nós
                    </div>

                    <h2 class="text-3xl md:text-4xl font-bold font-poppins text-gray-900 dark:text-white">
                        Secretaria Municipal de Agricultura
                    </h2>

                    <p class="text-lg text-gray-700 dark:text-gray-300 leading-relaxed">
                        A SEMAGRI é responsável por executar políticas públicas voltadas para o desenvolvimento da agricultura, pecuária e pesca em nosso município. Trabalhamos diariamente para fortalecer os produtores rurais e promover a sustentabilidade local.
                    </p>

                    <p class="text-lg text-gray-700 dark:text-gray-300 leading-relaxed">
                        Nossa equipe está comprometida em oferecer serviços de qualidade, apoiar a agricultura familiar e garantir o uso adequado dos recursos naturais, sempre em diálogo constante com a comunidade rural.
                    </p>

                    <div class="grid grid-cols-2 gap-4 pt-4">
                        <div class="bg-white dark:bg-slate-700 rounded-xl p-4 shadow-sm">
                            <div class="text-3xl font-bold text-emerald-600 dark:text-emerald-400 mb-1">45</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Localidades Atendidas</div>
                        </div>
                        <div class="bg-white dark:bg-slate-700 rounded-xl p-4 shadow-sm">
                            <div class="text-3xl font-bold text-emerald-600 dark:text-emerald-400 mb-1">19.000+</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Pessoas Cadastradas</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Serviços Públicos Section -->
    @if($configs['servicos_publicos_enabled'] ?? true)
    <section id="servicos-publicos" class="py-20 bg-gradient-to-br from-gray-50 via-white to-emerald-50/30 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <div class="inline-flex items-center gap-2 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                    <x-icon name="hand-holding-heart" style="duotone" class="w-4 h-4" />
                    Acesso Público
                </div>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold font-poppins text-gray-900 dark:text-white mb-4">
                    Serviços Públicos Online
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto leading-relaxed">
                    Acesse informações e serviços disponíveis para a população de forma transparente e rápida
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 max-w-6xl mx-auto">
                <!-- Portal de Transparência -->
                <a href="{{ route('portal.index') }}" class="group relative bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-2 border-blue-100 dark:border-blue-900/50 hover:border-blue-300 dark:hover:border-blue-700 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-100/50 to-transparent dark:from-blue-900/20 rounded-bl-full"></div>
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <x-icon name="chart-mixed" style="duotone" class="w-8 h-8 text-white" />
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            Portal de Transparência
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300 mb-5 leading-relaxed text-sm">
                            Consulte poços artesianos, pontos de água, iluminação pública e estradas disponíveis em sua localidade.
                        </p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start gap-2.5">
                                <x-icon name="faucet-drip" style="duotone" class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Poços artesianos</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <x-icon name="droplet" style="duotone" class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Pontos de água</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <x-icon name="lightbulb" style="duotone" class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Iluminação pública</span>
                            </li>
                        </ul>
                        <div class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 font-semibold hover:text-blue-700 dark:hover:text-blue-300 transition-colors group-hover:gap-3">
                            <span>Acessar portal</span>
                            <x-icon name="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                        </div>
                    </div>
                </a>

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Blog'))
                <!-- Blog & Notícias -->
                <a href="{{ route('blog.index') }}" class="group relative bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-2 border-emerald-100 dark:border-emerald-900/50 hover:border-emerald-300 dark:hover:border-emerald-700 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-100/50 to-transparent dark:from-emerald-900/20 rounded-bl-full"></div>
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <x-icon name="newspaper" style="duotone" class="w-8 h-8 text-white" />
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            Blog & Notícias
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300 mb-5 leading-relaxed text-sm">
                            Acompanhe as últimas notícias, relatórios mensais e novidades da Secretaria Municipal de Agricultura.
                        </p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start gap-2.5">
                                <x-icon name="memo-circle-check" style="duotone" class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Notícias atualizadas</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <x-icon name="file-chart-column" style="duotone" class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Relatórios mensais</span>
                            </li>
                        </ul>
                        <div class="flex items-center text-emerald-600 dark:text-emerald-400 font-medium group-hover:gap-3 transition-all duration-300">
                            <span class="text-sm">Acessar Blog</span>
                            <x-icon name="arrow-right" class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" />
                        </div>
                    </div>
                </a>
                @endif

                <!-- Portal do Agricultor -->
                @if(\Nwidart\Modules\Facades\Module::isEnabled('ProgramasAgricultura') && Route::has('portal.agricultor.index'))
                <a href="{{ route('portal.agricultor.index') }}" class="group relative bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-2 border-amber-100 dark:border-amber-900/50 hover:border-amber-300 dark:hover:border-amber-700 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-amber-100/50 to-transparent dark:from-amber-900/20 rounded-bl-full"></div>
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <x-icon name="user-cowboy" style="duotone" class="w-8 h-8 text-white" />
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            Portal do Agricultor
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300 mb-5 leading-relaxed text-sm">
                            Consulte programas governamentais, eventos, capacitações e acompanhe seus benefícios usando seu CPF.
                        </p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start gap-2.5">
                                <x-icon name="handshake-angle" style="duotone" class="w-5 h-5 text-amber-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Programas governamentais</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <x-icon name="calendar-days" style="duotone" class="w-5 h-5 text-amber-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Eventos e capacitações</span>
                            </li>
                        </ul>
                        <div class="inline-flex items-center gap-2 text-amber-600 dark:text-amber-400 font-semibold hover:text-amber-700 dark:hover:text-amber-300 transition-colors group-hover:gap-3">
                            <span>Acessar portal</span>
                            <x-icon name="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                        </div>
                    </div>
                </a>
                @endif

                <!-- Consulta de Demandas -->
                <a href="{{ route('demandas.public.consulta') }}" class="group relative bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-2 border-emerald-100 dark:border-emerald-900/50 hover:border-emerald-300 dark:hover:border-emerald-700 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-100/50 to-transparent dark:from-emerald-900/20 rounded-bl-full"></div>
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <x-icon name="magnifying-glass" style="duotone" class="w-8 h-8 text-white" />
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            Consultar Demanda
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300 mb-5 leading-relaxed text-sm">
                            Acompanhe o status da sua solicitação em tempo real usando o código do protocolo.
                        </p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start gap-2.5">
                                <x-icon name="barcode-read" style="duotone" class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Consulta por código/protocolo</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <x-icon name="clock" style="duotone" class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Acompanhamento em tempo real</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <x-icon name="file-contract" style="duotone" class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Histórico completo da solicitação</span>
                            </li>
                        </ul>
                        <div class="inline-flex items-center gap-2 text-emerald-600 dark:text-emerald-400 font-semibold hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors group-hover:gap-3">
                            <span>Consultar agora</span>
                            <x-icon name="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                        </div>
                    </div>
                </a>

                <!-- Portal do Morador (Poço Artesiano) -->
                @if(\Nwidart\Modules\Facades\Module::isEnabled('Pocos') && Route::has('morador-poco.index'))
                <a href="{{ route('morador-poco.index') }}" class="group relative bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-2 border-cyan-100 dark:border-cyan-900/50 hover:border-cyan-300 dark:hover:border-cyan-700 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-cyan-100/50 to-transparent dark:from-cyan-900/20 rounded-bl-full"></div>
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-cyan-500 to-teal-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <x-icon name="house-user" style="duotone" class="w-8 h-8 text-white" />
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            Portal do Morador
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300 mb-5 leading-relaxed text-sm">
                            Acesse seu painel de morador para consultar faturas, emitir segunda via de boletos e acompanhar seus pagamentos do poço artesiano.
                        </p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start gap-2.5">
                                <x-icon name="file-invoice-dollar" style="duotone" class="w-5 h-5 text-cyan-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Emitir segunda via de boleto</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <x-icon name="magnifying-glass-dollar" style="duotone" class="w-5 h-5 text-cyan-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Consultar faturas em aberto</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <x-icon name="clock-rotate-left" style="duotone" class="w-5 h-5 text-cyan-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Histórico completo de pagamentos</span>
                            </li>
                        </ul>
                        <div class="inline-flex items-center gap-2 text-cyan-600 dark:text-cyan-400 font-semibold hover:text-cyan-700 dark:hover:text-cyan-300 transition-colors group-hover:gap-3">
                            <span>Acessar portal</span>
                            <x-icon name="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                        </div>
                    </div>
                </a>
                @endif
            </div>
        </div>
    </section>
    @endif

    <!-- Contato Section -->
    @if($configs['contato_enabled'] ?? true)
    <section id="contato" class="py-20 bg-gradient-to-br from-slate-50 to-gray-100 dark:from-slate-800 dark:to-slate-900">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold font-poppins text-gray-900 dark:text-white mb-4">
                        Entre em Contato
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300">
                        Estamos à disposição para atender você
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-white dark:bg-slate-700 rounded-2xl p-8 shadow-lg text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <x-icon name="phone" style="duotone" class="w-8 h-8 text-white" />
                        </div>
                        <h3 class="font-bold text-gray-900 dark:text-white mb-2">Telefone</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ $configs['telefone'] ?? '(75) 3248-2489' }}</p>
                    </div>

                    <div class="bg-white dark:bg-slate-700 rounded-2xl p-8 shadow-lg text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <x-icon name="envelope" style="duotone" class="w-8 h-8 text-white" />
                        </div>
                        <h3 class="font-bold text-gray-900 dark:text-white mb-2">E-mail</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm break-all">{{ $configs['email'] ?? 'gabinete@coracaodemaria.ba.gov.br' }}</p>
                    </div>

                    <div class="bg-white dark:bg-slate-700 rounded-2xl p-8 shadow-lg text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <x-icon name="map-location-dot" style="duotone" class="w-8 h-8 text-white" />
                        </div>
                        <h3 class="font-bold text-gray-900 dark:text-white mb-2">Endereço</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $configs['endereco'] ?? 'Praça Dr. Araújo Pinho, Centro - CEP 44250-000' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
</div>

@include('homepage::layouts.footer-homepage')

<!-- Back to Top Button -->
<button id="backToTop" class="fixed bottom-8 right-8 w-14 h-14 bg-gradient-to-r from-emerald-500 to-teal-600 dark:from-emerald-600 dark:to-teal-700 text-white rounded-full shadow-lg dark:shadow-emerald-900/50 hover:shadow-xl dark:hover:shadow-emerald-900/70 hover:scale-110 transition-all duration-300 opacity-0 invisible z-50 flex items-center justify-center group">
    <x-icon name="arrow-up" class="w-6 h-6 group-hover:-translate-y-1 transition-transform" />
</button>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll para links âncora
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#' && href.length > 1) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    const offsetTop = target.offsetTop - 80;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });

    // Back to Top Button
    const backToTopBtn = document.getElementById('backToTop');
    if (backToTopBtn) {
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopBtn.classList.remove('opacity-0', 'invisible');
                backToTopBtn.classList.add('opacity-100', 'visible');
            } else {
                backToTopBtn.classList.add('opacity-0', 'invisible');
                backToTopBtn.classList.remove('opacity-100', 'visible');
            }
        });

        backToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // Estilos completos para conteúdo HTML formatado do carousel (Quill Editor)
    const carouselStyle = document.createElement('style');
    carouselStyle.textContent = `
        .carousel-title h1, .carousel-title h2, .carousel-title h3 { color: white !important; font-weight: bold; }
        .carousel-description p { margin: 0.75rem 0; line-height: 1.6; }
    `;
    document.head.appendChild(carouselStyle);

    // Inicializar Preline Carousel
    function initCarousel() {
        if (typeof window.HSStaticMethods !== 'undefined') {
            window.HSStaticMethods.autoInit();
        }
    }
    setTimeout(initCarousel, 100);
});
</script>
@endpush

@endsection
