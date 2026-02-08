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
                                                    <x-icon name="magnifying-glass" class="w-5 h-5" />
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
        </div>
    </section>
    @endif

    <!-- Serviços Públicos Section -->
    @if($configs['servicos_publicos_enabled'] ?? true)
    <section class="py-12 -mt-12 relative z-20">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Consultar Demanda Card -->
                <a href="{{ route('demandas.public.consulta') }}" class="group block">
                    <div class="bg-white dark:bg-slate-800 rounded-3xl p-8 border border-emerald-100 dark:border-slate-700 shadow-xl hover:shadow-2xl hover:scale-[1.02] transition-all duration-500 overflow-hidden relative">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-cyan-500/10 rounded-bl-full -mr-16 -mt-16 group-hover:scale-110 transition-transform"></div>
                        <div class="w-14 h-14 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:rotate-6 transition-transform shadow-lg shadow-cyan-500/30">
                            <x-icon name="magnifying-glass" class="w-7 h-7 text-white" />
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                            Consultar Demanda
                        </h3>
                        <p class="text-gray-700 dark:text-gray-300 mb-5 leading-relaxed text-sm">
                            Acompanhe o status da sua solicitação em tempo real usando o código do protocolo.
                        </p>
                        <ul class="space-y-2 mb-6">
                            <li class="flex items-start gap-2.5">
                                <x-icon name="file-pdf" class="w-5 h-5 text-cyan-500" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Emitir segunda via de boleto</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <x-icon name="invoice" class="w-5 h-5 text-cyan-500" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Consultar faturas em aberto</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <x-icon name="history" class="w-5 h-5 text-cyan-500" />
                                <span class="text-sm text-gray-600 dark:text-gray-400">Histórico completo de pagamentos</span>
                            </li>
                        </ul>
                        <div class="inline-flex items-center gap-2 text-cyan-600 dark:text-cyan-400 font-semibold hover:text-cyan-700 dark:hover:text-cyan-300 transition-colors group-hover:gap-3">
                            <span>Acessar portal</span>
                            <x-icon name="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                        </div>
                    </div>
                </a>
            </div>

            <!-- Informações Adicionais -->
            <div class="mt-16 max-w-4xl mx-auto">
                <div class="bg-white dark:bg-slate-800 rounded-2xl p-8 border-2 border-gray-200 dark:border-slate-700 shadow-lg">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0 w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center">
                            <x-icon name="circle-info" class="w-6 h-6 text-emerald-600 dark:text-emerald-400" />
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
