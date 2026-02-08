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
                                                // Extrair tags <style> e <script> do conteúdo
                                                $titleContent = $slide->title;
                                                $styleTags = '';
                                                $scriptTags = '';

                                                // Extrair <style> tags
                                                if (preg_match_all('/<style[^>]*>.*?<\/style>/is', $titleContent, $styleMatches)) {
                                                    $styleTags = implode("\n", $styleMatches[0]);
                                                    $titleContent = preg_replace('/<style[^>]*>.*?<\/style>/is', '', $titleContent);
                                                }

                                                // Extrair <script> tags
                                                if (preg_match_all('/<script[^>]*>.*?<\/script>/is', $titleContent, $scriptMatches)) {
                                                    $scriptTags = implode("\n", $scriptMatches[0]);
                                                    $titleContent = preg_replace('/<script[^>]*>.*?<\/script>/is', '', $titleContent);
                                                }

                                                // Limpar tags <p> vazias ou que envolvem apenas espaços
                                                $titleContent = preg_replace('/<p[^>]*>\s*<\/p>/i', '', $titleContent);
                                                $titleContent = preg_replace('/<p[^>]*>(\s*<br\s*\/?>\s*)*<\/p>/i', '', $titleContent);

                                                // Remover <p> tags mas manter o conteúdo formatado
                                                $titleContent = preg_replace('/<p[^>]*>(.*?)<\/p>/is', '$1', $titleContent);

                                                // Limpar espaços em branco extras
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
                                                // Extrair tags <style> e <script> do conteúdo
                                                $descContent = $slide->description;
                                                $descStyleTags = '';
                                                $descScriptTags = '';

                                                // Extrair <style> tags
                                                if (preg_match_all('/<style[^>]*>.*?<\/style>/is', $descContent, $descStyleMatches)) {
                                                    $descStyleTags = implode("\n", $descStyleMatches[0]);
                                                    $descContent = preg_replace('/<style[^>]*>.*?<\/style>/is', '', $descContent);
                                                }

                                                // Extrair <script> tags
                                                if (preg_match_all('/<script[^>]*>.*?<\/script>/is', $descContent, $descScriptMatches)) {
                                                    $descScriptTags = implode("\n", $descScriptMatches[0]);
                                                    $descContent = preg_replace('/<script[^>]*>.*?<\/script>/is', '', $descContent);
                                                }

                                                // Limpar tags <p> vazias
                                                $descContent = preg_replace('/<p[^>]*>\s*<\/p>/i', '', $descContent);
                                                $descContent = preg_replace('/<p[^>]*>(\s*<br\s*\/?>\s*)*<\/p>/i', '', $descContent);

                                                // Remover <p> tags mas manter o conteúdo formatado
                                                $descContent = preg_replace('/<p[^>]*>(.*?)<\/p>/is', '$1<br>', $descContent);

                                                // Limpar <br> extras no final
                                                $descContent = preg_replace('/(<br\s*\/?>\s*)+$/i', '', $descContent);

                                                // Limpar espaços em branco extras
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
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                                    </svg>
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
                <svg class="w-6 h-6 md:w-7 md:h-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </button>

            <button type="button" class="hs-carousel-next absolute top-1/2 end-4 -translate-y-1/2 w-12 h-12 md:w-14 md:h-14 bg-white/20 backdrop-blur-sm hover:bg-white/30 text-white rounded-full flex items-center justify-center transition-all duration-300 hover:scale-110 shadow-lg z-10">
                <span class="sr-only">Próximo</span>
                <svg class="w-6 h-6 md:w-7 md:h-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
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
                              <x-icon name="academic-cap" class="w-5 h-5" />
                              <span>Prefeitura Municipal de Coração de Maria - BA</span>
                          </div>

                          <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                              {{ $configs['hero_title'] ?? 'Secretaria Municipal de Agricultura' }}
                          </h1>

                          <p class="text-lg md:text-xl text-white/95 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                              {{ $configs['hero_subtitle'] ?? 'Trabalhando pelo desenvolvimento rural sustentável e o fortalecimento da agricultura familiar em nosso município.' }}
                          </p>

                    <div class="flex flex-wrap gap-3 sm:gap-4 pt-4 justify-center lg:justify-start">
                        <!-- Portal de Transparência -->
                        <a href="{{ route('portal.index') }}" class="group inline-flex items-center gap-2 bg-white text-emerald-600 px-5 sm:px-8 py-3 sm:py-4 rounded-xl font-semibold hover:bg-yellow-50 hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl text-sm sm:text-base">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                            </svg>
                            <span class="hidden xs:inline">Portal de Transparência</span>
                            <span class="xs:hidden">Transparência</span>
                        </a>
                        
                        @if(\Nwidart\Modules\Facades\Module::isEnabled('Blog'))
                        <!-- Blog -->
                        <a href="{{ route('blog.index') }}" class="group inline-flex items-center gap-2 bg-white text-emerald-600 px-5 sm:px-8 py-3 sm:py-4 rounded-xl font-semibold hover:bg-blue-50 hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl text-sm sm:text-base">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                {!! \App\Helpers\ModuleIcons::getIconPath('Blog') !!}
                            </svg>
                            <span class="hidden xs:inline">Blog & Notícias</span>
                            <span class="xs:hidden">Blog</span>
                        </a>
                        @endif
                        <a href="{{ route('demandas.public.consulta') }}" class="group inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm text-white border-2 border-white/30 px-5 sm:px-8 py-3 sm:py-4 rounded-xl font-semibold hover:bg-white/20 hover:scale-105 transition-all duration-300 text-sm sm:text-base">
                            <x-icon name="magnifying-glass" class="w-4 h-4 sm:w-5 sm:h-5" />
                            <span class="hidden xs:inline">Consultar Demanda</span>
                            <span class="xs:hidden">Demandas</span>
                        </a>
                        <a href="#servicos" class="group inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm text-white border-2 border-white/30 px-5 sm:px-8 py-3 sm:py-4 rounded-xl font-semibold hover:bg-white/20 hover:scale-105 transition-all duration-300 text-sm sm:text-base">
                            <x-icon name="squares-2x2" class="w-4 h-4 sm:w-5 sm:h-5" />
                            <span class="hidden xs:inline">Nossos Serviços</span>
                            <span class="xs:hidden">Serviços</span>
                        </a>
                    </div>

                    <!-- Contato Rápido -->
                    <div class="flex flex-wrap gap-6 pt-6 text-white/90 justify-center lg:justify-start">
                        <div class="flex items-center gap-2">
                            <x-icon name="phone" class="w-5 h-5 text-green-200" />
                            <span class="text-sm">(75) 3248-2489</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-icon name="envelope" class="w-5 h-5 text-green-200" />
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
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                    Serviços ao Cidadão
                </div>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4">
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
                                <svg class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Solicite melhorias na sua região</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Acompanhe o status da sua solicitação</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Receba notificações por e-mail</span>
                            </li>
                        </ul>
                        <a href="{{ route('demandas.public.consulta') }}" class="inline-flex items-center gap-2 text-emerald-600 dark:text-emerald-400 font-semibold hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors group-hover:gap-3">
                            <span>Consultar minha demanda</span>
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Infraestrutura Rural -->
                <div class="group relative bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-2 border-blue-100 dark:border-blue-900/50 hover:border-blue-300 dark:hover:border-blue-700 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-100/50 to-transparent dark:from-blue-900/20 rounded-bl-full"></div>
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15m-16.5 18V9.75m0 0l3-3m-3 3l3 3m8.25-3V9.75m0 0l-3-3m3 3l-3 3M9.75 9.75h.008v.008H9.75zm0 3h.008v.008H9.75zm0 3h.008v.008H9.75z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            Infraestrutura Rural
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300 mb-5 leading-relaxed text-sm">
                            Cuidamos da manutenção e melhorias da infraestrutura rural, incluindo estradas vicinais, pontos de água, poços artesianos e iluminação pública.
                        </p>
                        <ul class="space-y-2.5 mb-6">
                            <li class="flex items-start gap-2.5">
                                <x-module-icon module="estradas" class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Manutenção de estradas e vicinais</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <x-module-icon module="pocos" class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Gestão de poços artesianos</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <x-module-icon module="agua" class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Rede de distribuição de água</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <x-module-icon module="iluminacao" class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Iluminação pública</span>
                            </li>
                        </ul>
                        <a href="{{ route('portal.index') }}" class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 font-semibold hover:text-blue-700 dark:hover:text-blue-300 transition-colors group-hover:gap-3">
                            <span>Ver infraestrutura disponível</span>
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Agricultura Familiar -->
                <div class="group relative bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-2 border-amber-100 dark:border-amber-900/50 hover:border-amber-300 dark:hover:border-amber-700 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-amber-100/50 to-transparent dark:from-amber-900/20 rounded-bl-full"></div>
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <x-module-icon module="caf" class="w-8 h-8 text-white" />
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            Apoio à Agricultura Familiar
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300 mb-5 leading-relaxed text-sm">
                            Promovemos programas e ações para fortalecer a agricultura familiar, garantindo apoio técnico e fomento à produção sustentável.
                        </p>
                        <ul class="space-y-2.5 mb-6">
                            <li class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-amber-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Programas de fomento</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-amber-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Assistência técnica</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-amber-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Articulação de parcerias</span>
                            </li>
                        </ul>
                        @if(\Nwidart\Modules\Facades\Module::isEnabled('ProgramasAgricultura'))
                        <a href="{{ route('portal.agricultor.index') }}" class="inline-flex items-center gap-2 text-amber-600 dark:text-amber-400 font-semibold hover:text-amber-700 dark:hover:text-amber-300 transition-colors group-hover:gap-3">
                            <span>Ver programas disponíveis</span>
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Desenvolvimento Rural -->
                <div class="group relative bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-2 border-green-100 dark:border-green-900/50 hover:border-green-300 dark:hover:border-green-700 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-green-100/50 to-transparent dark:from-green-900/20 rounded-bl-full"></div>
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.224 48.224 0 0012 4.5c-2.48 0-4.785.685-6.75 1.97m13.5 0c1.01.003 2.01.107 2.995.292m-10.5 0a51.964 51.964 0 014.5 0m0 0c.93.003 1.857.092 2.75.292M6.75 4.97l-.016.005M6.75 4.97l-.016.005M6.75 4.97l-.016.005m13.516.005m-13.516 0l.016-.005m13.516-.005L18.75 4.97m-13.5 13.5c1.01.003 2.01.107 2.995.292M6.75 20.25c-1.472 0-2.882-.265-4.185-.75M18.75 20.25c1.472 0 2.882-.265 4.185-.75m-10.5 0a51.964 51.964 0 01-4.5 0m10.5 0a48.225 48.225 0 005.25-15.28" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            Desenvolvimento Rural Sustentável
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300 mb-5 leading-relaxed text-sm">
                            Promovemos o desenvolvimento rural com foco na sustentabilidade, fortalecendo a agricultura familiar e melhorando a qualidade de vida no campo.
                        </p>
                        <ul class="space-y-2.5 mb-6">
                            <li class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Fortalecimento da agricultura familiar</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Práticas agrícolas sustentáveis</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
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
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            Programas e Projetos
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300 mb-5 leading-relaxed text-sm">
                            Articulamos programas governamentais que beneficiam os produtores rurais, como o Seguro Safra e parcerias para comercialização.
                        </p>
                        <ul class="space-y-2.5 mb-6">
                            <li class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-purple-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Seguro Safra</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-purple-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Parcerias comerciais</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-purple-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Doação de equipamentos</span>
                            </li>
                        </ul>
                        @if(\Nwidart\Modules\Facades\Module::isEnabled('ProgramasAgricultura'))
                        <a href="{{ route('portal.agricultor.programas') }}" class="inline-flex items-center gap-2 text-purple-600 dark:text-purple-400 font-semibold hover:text-purple-700 dark:hover:text-purple-300 transition-colors group-hover:gap-3">
                            <span>Ver todos os programas</span>
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Cadastro e Documentação -->
                <div class="group relative bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-2 border-cyan-100 dark:border-cyan-900/50 hover:border-cyan-300 dark:hover:border-cyan-700 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-cyan-100/50 to-transparent dark:from-cyan-900/20 rounded-bl-full"></div>
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-cyan-500 to-teal-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 9a3 3 0 11-6 0 3 3 0 016 0zM4.5 9.75a8.25 8.25 0 1116.5 0 .75.75 0 01-.75.75h-15a.75.75 0 01-.75-.75zM18 9a3 3 0 11-6 0 3 3 0 016 0zm-3.75 3.75a.75.75 0 00-.75.75v3.75a.75.75 0 001.5 0V13.5a.75.75 0 00-.75-.75z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            Cadastros e Documentação
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300 mb-5 leading-relaxed text-sm">
                            Oferecemos atendimento itinerante para emissão e renovação de cadastros agrícolas, facilitando o acesso aos serviços para produtores rurais em todas as localidades do município.
                        </p>
                        <ul class="space-y-2.5 mb-6">
                            <li class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-cyan-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Emissão de cadastros</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-cyan-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Renovação de documentação</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-cyan-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
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
                                <x-icon name="academic-cap" class="w-8 h-8" />
                                <div>
                                    <h4 class="font-bold text-lg">Missão</h4>
                                    <p class="text-sm text-white/90">Desenvolver políticas públicas para fortalecer a agricultura familiar e garantir a sustentabilidade</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 text-white">
                                <x-icon name="eye" class="w-8 h-8" />
                                <div>
                                    <h4 class="font-bold text-lg">Visão</h4>
                                    <p class="text-sm text-white/90">Ser referência em desenvolvimento rural sustentável na região</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 text-white">
                                <x-icon name="heart" class="w-8 h-8" />
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
                        <x-icon name="information-circle" class="w-4 h-4" />
                        Sobre Nós
                    </div>

                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">
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
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                    </svg>
                    Acesso Público
                </div>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                    Serviços Públicos Online
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto leading-relaxed">
                    Acesse informações e serviços disponíveis para a população de forma transparente e rápida
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 max-w-6xl mx-auto">
                <!-- Portal de Transparência (Infraestrutura) -->
                <a href="{{ route('portal.index') }}" class="group relative bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-2 border-blue-100 dark:border-blue-900/50 hover:border-blue-300 dark:hover:border-blue-700 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-100/50 to-transparent dark:from-blue-900/20 rounded-bl-full"></div>
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            Portal de Transparência
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300 mb-5 leading-relaxed text-sm">
                            Consulte poços artesianos, pontos de água, iluminação pública e estradas disponíveis em sua localidade.
                        </p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start gap-2.5">
                                <x-module-icon module="pocos" class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Poços artesianos</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <x-module-icon module="agua" class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Pontos de água</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <x-module-icon module="iluminacao" class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Iluminação pública</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <x-module-icon module="estradas" class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Estradas e vicinais</span>
                            </li>
                        </ul>
                        <div class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 font-semibold hover:text-blue-700 dark:hover:text-blue-300 transition-colors group-hover:gap-3">
                            <span>Acessar portal</span>
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </div>
                    </div>
                </a>

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Blog'))
                <!-- Blog & Notícias -->
                <a href="{{ route('blog.index') }}" class="group relative bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-2 border-emerald-100 dark:border-emerald-900/50 hover:border-emerald-300 dark:hover:border-emerald-700 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-100/50 to-transparent dark:from-emerald-900/20 rounded-bl-full"></div>
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                {!! \App\Helpers\ModuleIcons::getIconPath('Blog') !!}
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            Blog & Notícias
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300 mb-5 leading-relaxed text-sm">
                            Acompanhe as últimas notícias, relatórios mensais e novidades da Secretaria Municipal de Agricultura.
                        </p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Notícias atualizadas</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Relatórios mensais</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Transparência ativa</span>
                            </li>
                        </ul>
                        <div class="flex items-center text-emerald-600 dark:text-emerald-400 font-medium group-hover:gap-3 transition-all duration-300">
                            <span class="text-sm">Acessar Blog</span>
                            <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </div>
                    </div>
                </a>
                @endif

                <!-- Portal do Agricultor (apenas se o módulo estiver ativo) -->
                @if(\Nwidart\Modules\Facades\Module::isEnabled('ProgramasAgricultura') && Route::has('portal.agricultor.index'))
                <a href="{{ route('portal.agricultor.index') }}" class="group relative bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-2 border-amber-100 dark:border-amber-900/50 hover:border-amber-300 dark:hover:border-amber-700 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-amber-100/50 to-transparent dark:from-amber-900/20 rounded-bl-full"></div>
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            Portal do Agricultor
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300 mb-5 leading-relaxed text-sm">
                            Consulte programas governamentais, eventos, capacitações e acompanhe seus benefícios usando seu CPF.
                        </p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-amber-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Programas governamentais</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-amber-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Eventos e capacitações</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-amber-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Acompanhamento de benefícios</span>
                            </li>
                        </ul>
                        <div class="inline-flex items-center gap-2 text-amber-600 dark:text-amber-400 font-semibold hover:text-amber-700 dark:hover:text-amber-300 transition-colors group-hover:gap-3">
                            <span>Acessar portal</span>
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </div>
                    </div>
                </a>
                @endif

                <!-- Consulta de Demandas -->
                <a href="{{ route('demandas.public.consulta') }}" class="group relative bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-2 border-emerald-100 dark:border-emerald-900/50 hover:border-emerald-300 dark:hover:border-emerald-700 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-emerald-100/50 to-transparent dark:from-emerald-900/20 rounded-bl-full"></div>
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            Consultar Demanda
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300 mb-5 leading-relaxed text-sm">
                            Acompanhe o status da sua solicitação em tempo real usando o código do protocolo.
                        </p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h11.25c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Consulta por código/protocolo</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Acompanhamento em tempo real</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-emerald-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Histórico completo da solicitação</span>
                            </li>
                        </ul>
                        <div class="inline-flex items-center gap-2 text-emerald-600 dark:text-emerald-400 font-semibold hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors group-hover:gap-3">
                            <span>Consultar agora</span>
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </div>
                    </div>
                </a>

                <!-- Portal do Morador (Poço Artesiano) -->
                @if(\Nwidart\Modules\Facades\Module::isEnabled('Pocos') && Route::has('morador-poco.index'))
                <a href="{{ route('morador-poco.index') }}" class="group relative bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-2 border-cyan-100 dark:border-cyan-900/50 hover:border-cyan-300 dark:hover:border-cyan-700 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-cyan-100/50 to-transparent dark:from-cyan-900/20 rounded-bl-full"></div>
                    <div class="relative">
                        <div class="w-16 h-16 bg-gradient-to-br from-cyan-500 to-teal-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            Portal do Morador
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300 mb-5 leading-relaxed text-sm">
                            Acesse seu painel de morador para consultar faturas, emitir segunda via de boletos e acompanhar seus pagamentos do poço artesiano.
                        </p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-cyan-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Emitir segunda via de boleto</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-cyan-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Consultar faturas em aberto</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <svg class="w-5 h-5 text-cyan-500 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h11.25c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                </svg>
                                <span class="text-sm text-gray-600 dark:text-gray-400">Histórico completo de pagamentos</span>
                            </li>
                        </ul>
                        <div class="inline-flex items-center gap-2 text-cyan-600 dark:text-cyan-400 font-semibold hover:text-cyan-700 dark:hover:text-cyan-300 transition-colors group-hover:gap-3">
                            <span>Acessar portal</span>
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </div>
                    </div>
                </a>
                @endif
            </div>

            <!-- Informações Adicionais -->
            <div class="mt-16 max-w-4xl mx-auto">
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-8 border-2 border-gray-200 dark:border-slate-700 shadow-lg">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Sobre os Serviços Públicos Online</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed mb-3">
                                Nossos serviços online foram desenvolvidos para proporcionar <strong class="text-gray-900 dark:text-white">transparência</strong> e <strong class="text-gray-900 dark:text-white">facilidade de acesso</strong> às informações públicas.
                                Todos os dados são atualizados em tempo real e estão em conformidade com a <strong class="text-gray-900 dark:text-white">Lei Geral de Proteção de Dados (LGPD)</strong>.
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                                Você pode consultar a infraestrutura disponível em sua localidade ou acompanhar o status de suas solicitações sem sair de casa, de forma <strong class="text-gray-900 dark:text-white">rápida, segura e transparente</strong>.
                            </p>
                        </div>
                    </div>
                </div>
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
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                        Entre em Contato
                    </h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300">
                        Estamos à disposição para atender você
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-white dark:bg-slate-700 rounded-2xl p-8 shadow-lg text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <x-icon name="phone" class="w-8 h-8 text-white" />
                        </div>
                        <h3 class="font-bold text-gray-900 dark:text-white mb-2">Telefone</h3>
                        <p class="text-gray-600 dark:text-gray-400">{{ $configs['telefone'] ?? '(75) 3248-2489' }}</p>
                    </div>

                    <div class="bg-white dark:bg-slate-700 rounded-2xl p-8 shadow-lg text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-teal-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <x-icon name="envelope" class="w-8 h-8 text-white" />
                        </div>
                        <h3 class="font-bold text-gray-900 dark:text-white mb-2">E-mail</h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm break-all">{{ $configs['email'] ?? 'gabinete@coracaodemaria.ba.gov.br' }}</p>
                    </div>

                    <div class="bg-white dark:bg-slate-700 rounded-2xl p-8 shadow-lg text-center">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                            <x-icon name="map-pin" class="w-8 h-8 text-white" />
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
        /* Estilos para Título do Carousel */
        .carousel-title {
            display: block;
            width: 100%;
        }
        .carousel-title h1, .carousel-title h2, .carousel-title h3,
        .carousel-title h4, .carousel-title h5, .carousel-title h6 {
            color: white !important;
            font-weight: bold;
            margin: 0.5rem 0;
            line-height: 1.2;
        }
        .carousel-title h1 { font-size: 3rem; }
        .carousel-title h2 { font-size: 2.5rem; }
        .carousel-title h3 { font-size: 2rem; }
        .carousel-title h4 { font-size: 1.75rem; }
        .carousel-title h5 { font-size: 1.5rem; }
        .carousel-title h6 { font-size: 1.25rem; }
        .carousel-title p {
            color: white !important;
            margin: 0.5rem 0;
            line-height: 1.5;
        }
        /* Permitir cores customizadas em parágrafos também */
        .carousel-title p[style*="color"] {
            /* Preservar cor do Quill */
        }
        .carousel-title strong, .carousel-title b {
            font-weight: 900 !important;
            /* Remover color: white !important para permitir cores customizadas */
        }
        /* Se strong/b tiver cor customizada, preservar */
        .carousel-title strong[style*="color"], .carousel-title b[style*="color"] {
            /* Preservar cor do Quill */
        }
        .carousel-title em, .carousel-title i {
            font-style: italic;
        }
        .carousel-title u {
            text-decoration: underline;
        }
        .carousel-title s, .carousel-title strike {
            text-decoration: line-through;
        }
        /* Permitir cores customizadas do Quill - não sobrescrever */
        .carousel-title span[style*="color"] {
            /* Remover !important para permitir cores do Quill */
        }
        .carousel-title span[style*="background"] {
            /* Manter background do Quill, apenas adicionar padding se necessário */
            padding: 0.125rem 0.25rem;
            border-radius: 0.25rem;
        }

        /* Estilos para Descrição do Carousel */
        .carousel-description {
            /* Removido color: white !important para permitir cores customizadas do Quill */
            display: block;
            width: 100%;
        }
        .carousel-description p {
            /* Removido color: white !important para permitir cores customizadas do Quill */
            margin: 0.75rem 0;
            line-height: 1.6;
        }
        /* Preservar cores customizadas em parágrafos */
        .carousel-description p[style*="color"] {
            /* Preservar cor do Quill */
        }
        .carousel-description p:first-child {
            margin-top: 0;
        }
        .carousel-description p:last-child {
            margin-bottom: 0;
        }
        .carousel-description h1, .carousel-description h2, .carousel-description h3,
        .carousel-description h4, .carousel-description h5, .carousel-description h6 {
            color: white !important;
            font-weight: bold;
            margin: 1rem 0 0.75rem 0;
            line-height: 1.3;
        }
        .carousel-description h1 { font-size: 2.5rem; }
        .carousel-description h2 { font-size: 2rem; }
        .carousel-description h3 { font-size: 1.75rem; }
        .carousel-description h4 { font-size: 1.5rem; }
        .carousel-description h5 { font-size: 1.25rem; }
        .carousel-description h6 { font-size: 1.125rem; }
        .carousel-description strong, .carousel-description b {
            font-weight: 700 !important;
            /* Removido color: white !important para permitir cores customizadas do Quill */
        }
        /* Preservar cores customizadas do Quill em strong/b */
        .carousel-description strong[style*="color"], .carousel-description b[style*="color"] {
            /* Preservar cor do Quill - não sobrescrever */
        }
        .carousel-description em, .carousel-description i {
            font-style: italic;
        }
        .carousel-description u {
            text-decoration: underline;
        }
        .carousel-description s, .carousel-description strike {
            text-decoration: line-through;
        }
        .carousel-description ul, .carousel-description ol {
            margin: 1rem 0;
            padding-left: 2rem;
            /* Removido color: white !important para permitir cores customizadas */
        }
        .carousel-description li {
            margin: 0.5rem 0;
            /* Removido color: white !important para permitir cores customizadas */
            line-height: 1.5;
        }
        .carousel-description a {
            color: #fef3c7 !important;
            text-decoration: underline;
            font-weight: 600;
            transition: color 0.2s;
        }
        .carousel-description a:hover {
            color: #fde68a !important;
        }
        .carousel-description blockquote {
            border-left: 4px solid rgba(255, 255, 255, 0.5);
            padding-left: 1rem;
            margin: 1rem 0;
            font-style: italic;
            color: rgba(255, 255, 255, 0.9) !important;
        }
        .carousel-description code {
            background: rgba(0, 0, 0, 0.3);
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-family: 'Courier New', monospace;
            color: #fef3c7 !important;
            font-size: 0.9em;
        }
        .carousel-description pre {
            background: rgba(0, 0, 0, 0.3);
            padding: 1rem;
            border-radius: 0.5rem;
            margin: 1rem 0;
            overflow-x: auto;
        }
        .carousel-description pre code {
            background: transparent;
            padding: 0;
        }
        /* Cores customizadas do Quill - preservar cores e adicionar sombra para legibilidade */
        .carousel-description span[style*="color"] {
            /* Preservar cor do Quill, apenas adicionar sombra para legibilidade */
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }
        .carousel-title span[style*="color"] {
            /* Preservar cor do Quill, apenas adicionar sombra para legibilidade */
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }
        .carousel-description span[style*="background"] {
            /* Manter background do Quill */
            padding: 0.125rem 0.375rem;
            border-radius: 0.25rem;
        }
        /* Alinhamento de texto */
        .carousel-description[style*="text-align: center"],
        .carousel-description p[style*="text-align: center"],
        .carousel-title[style*="text-align: center"],
        .carousel-title p[style*="text-align: center"] {
            text-align: center !important;
        }
        .carousel-description[style*="text-align: right"],
        .carousel-description p[style*="text-align: right"],
        .carousel-title[style*="text-align: right"],
        .carousel-title p[style*="text-align: right"] {
            text-align: right !important;
        }
        .carousel-description[style*="text-align: left"],
        .carousel-description p[style*="text-align: left"],
        .carousel-title[style*="text-align: left"],
        .carousel-title p[style*="text-align: left"] {
            text-align: left !important;
        }
        /* Tamanhos de fonte customizados */
        .carousel-description .ql-size-small {
            font-size: 0.875em;
        }
        .carousel-description .ql-size-large {
            font-size: 1.25em;
        }
        .carousel-description .ql-size-huge {
            font-size: 1.5em;
        }
        .carousel-title .ql-size-small {
            font-size: 0.875em;
        }
        .carousel-title .ql-size-large {
            font-size: 1.25em;
        }
        .carousel-title .ql-size-huge {
            font-size: 1.5em;
        }
        /* Imagens no carousel */
        .carousel-description img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin: 1rem 0;
        }
        /* Vídeos no carousel */
        .carousel-description iframe,
        .carousel-description video {
            max-width: 100%;
            border-radius: 0.5rem;
            margin: 1rem 0;
        }
    `;
    document.head.appendChild(carouselStyle);

    // Inicializar Preline Carousel
    function initCarousel() {
        const carouselElement = document.getElementById('homepageCarousel') || document.querySelector('[data-hs-carousel]');

        if (!carouselElement) {
            return; // Não há carrossel na página
        }

        // Verificar se Preline está carregado
        if (typeof window.HSStaticMethods !== 'undefined') {
            try {
                // Forçar inicialização do carrossel
                window.HSStaticMethods.autoInit();

                // Garantir que o carrossel seja visível
                const carouselBody = carouselElement.querySelector('.hs-carousel-body');
                if (carouselBody) {
                    // Remover opacity-0 se existir
                    carouselBody.classList.remove('opacity-0');
                    carouselBody.style.opacity = '1';
                }

                // Verificar se o carrossel foi inicializado corretamente após um delay
                setTimeout(function() {
                    const carouselBody = carouselElement.querySelector('.hs-carousel-body');
                    if (carouselBody) {
                        // Garantir visibilidade
                        if (carouselBody.style.opacity === '0' || carouselBody.classList.contains('opacity-0')) {
                            carouselBody.style.opacity = '1';
                            carouselBody.classList.remove('opacity-0');
                        }
                    }
                }, 300);
            } catch (error) {
                console.error('Erro ao inicializar carrossel:', error);
            }
        } else {
            // Se Preline ainda não carregou, tentar novamente
            setTimeout(initCarousel, 200);
        }
    }

    // Tentar inicializar quando o DOM estiver pronto
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(initCarousel, 100);
        });
    } else {
        // DOM já está pronto
        setTimeout(initCarousel, 100);
    }

    // Também tentar quando a janela carregar completamente (após todos os recursos)
    window.addEventListener('load', function() {
        setTimeout(initCarousel, 500);
    });
});
</script>
@endpush

@endsection
