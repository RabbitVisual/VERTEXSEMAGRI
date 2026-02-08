<nav class="sticky top-0 z-50 bg-white/80 dark:bg-slate-800/80 backdrop-blur-md border-b border-gray-200 dark:border-slate-700 shadow-sm" id="homepageNavbar">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-20">
            <!-- Logo -->
            <a href="{{ route('homepage') }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity">
                <img src="{{ asset('images/logo-vertex-semagri.svg') }}" alt="Vertex SEMAGRI" class="h-12">
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center gap-8">
                @php
                    $currentPath = trim(request()->path(), '/');
                    $isHomepage = request()->routeIs('homepage') || $currentPath === '' || $currentPath === 'public';
                    $homepageUrl = route('homepage');
                    // Buscar configurações do navbar
                    $navbarConfigs = [
                        'inicio' => (bool) \App\Models\SystemConfig::get('homepage_navbar_inicio_enabled', true),
                        'servicos' => (bool) \App\Models\SystemConfig::get('homepage_navbar_servicos_enabled', true),
                        'sobre' => (bool) \App\Models\SystemConfig::get('homepage_navbar_sobre_enabled', true),
                        'consulta' => (bool) \App\Models\SystemConfig::get('homepage_navbar_consulta_enabled', true),
                        'contato' => (bool) \App\Models\SystemConfig::get('homepage_navbar_contato_enabled', true),
                    ];
                @endphp

                @if($navbarConfigs['inicio'])
                <a href="{{ $isHomepage ? '#inicio' : $homepageUrl . '#inicio' }}" class="nav-link text-gray-700 dark:text-gray-300 hover:text-emerald-600 dark:hover:text-emerald-400 font-medium transition-colors relative group" data-anchor="inicio">
                    <span class="flex items-center gap-2">
                        <x-icon name="home" class="w-4 h-4" />
                        Início
                    </span>
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-emerald-600 transition-all group-hover:w-full"></span>
                </a>
                @endif
                @if($navbarConfigs['servicos'])
                <a href="{{ $isHomepage ? '#servicos' : $homepageUrl . '#servicos' }}" class="nav-link text-gray-700 dark:text-gray-300 hover:text-emerald-600 dark:hover:text-emerald-400 font-medium transition-colors relative group" data-anchor="servicos">
                    <span class="flex items-center gap-2">
                        <x-icon name="squares-2x2" class="w-4 h-4" />
                        Serviços
                    </span>
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-emerald-600 transition-all group-hover:w-full"></span>
                </a>
                @endif
                @if($navbarConfigs['sobre'])
                <a href="{{ $isHomepage ? '#sobre' : $homepageUrl . '#sobre' }}" class="nav-link text-gray-700 dark:text-gray-300 hover:text-emerald-600 dark:hover:text-emerald-400 font-medium transition-colors relative group" data-anchor="sobre">
                    <span class="flex items-center gap-2">
                        <x-icon name="information-circle" class="w-4 h-4" />
                        Sobre
                    </span>
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-emerald-600 transition-all group-hover:w-full"></span>
                </a>
                @endif
                @if(\Nwidart\Modules\Facades\Module::isEnabled('Blog'))
                <a href="{{ route('blog.index') }}" class="nav-link text-gray-700 dark:text-gray-300 hover:text-emerald-600 dark:hover:text-emerald-400 font-medium transition-colors relative group">
                    <span class="flex items-center gap-2">
                        <x-icon name="magnifying-glass" class="w-5 h-5" />
                    <span>Consultar Demanda</span>
                </a>

                <!-- Botão Portal do Morador -->
                @if(\Nwidart\Modules\Facades\Module::isEnabled('Pocos') && Route::has('morador-poco.index'))
                <a href="{{ route('morador-poco.index') }}" class="hidden md:inline-flex items-center gap-1.5 bg-teal-50 dark:bg-teal-900/20 text-teal-700 dark:text-teal-400 border border-teal-200 dark:border-teal-800 px-3 py-1.5 rounded-lg text-sm font-medium hover:bg-teal-100 dark:hover:bg-teal-900/30 transition-colors">
                    <x-icon name="magnifying-glass" class="w-5 h-5" />
                            <span>Consultar Demanda</span>
                        </a>
                        @if(\Nwidart\Modules\Facades\Module::isEnabled('Pocos') && Route::has('morador-poco.index'))
                        <a href="{{ route('morador-poco.index') }}" class="flex items-center justify-center gap-2 bg-teal-50 dark:bg-teal-900/20 text-teal-700 dark:text-teal-400 border border-teal-200 dark:border-teal-800 px-4 py-2 rounded-lg text-sm font-medium hover:bg-teal-100 dark:hover:bg-teal-900/30 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                            </svg>
                            <span>Portal do Morador</span>
                        </a>
                        @endif
                        <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 px-4 py-2 rounded-lg text-sm font-medium hover:bg-emerald-100 dark:hover:bg-emerald-900/30 transition-colors">
                            <x-icon name="arrow-right-on-rectangle" class="w-4 h-4" />
                            Entrar
                        </a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile Menu Toggle
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const mobileMenu = document.getElementById('mobileMenu');

    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // Detectar se estamos na homepage
    const currentPath = window.location.pathname.replace(/\/$/, ''); // Remove trailing slash
    const isHomepage = currentPath === '' || currentPath === '/public' || currentPath === '/' || currentPath.endsWith('/public');
    const homepageUrl = '{{ route("homepage") }}';

    // Smooth Scroll - Funciona tanto na homepage quanto em outras páginas
    document.querySelectorAll('a[data-anchor], a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            const anchorName = this.getAttribute('data-anchor');

            // Se não estiver na homepage e o link tiver âncora, redirecionar para homepage
            if (!isHomepage && (href.startsWith('#') || anchorName)) {
                e.preventDefault();
                const anchor = anchorName || href.substring(1);
                window.location.href = homepageUrl + '#' + anchor;
                return;
            }

            // Se estiver na homepage, fazer scroll suave
            if (isHomepage && href.startsWith('#') && href.length > 1) {
                e.preventDefault();
                const target = document.querySelector(href);
                if (target) {
                    const offsetTop = target.offsetTop - 80;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                    // Fechar menu mobile
                    if (mobileMenu) {
                        mobileMenu.classList.add('hidden');
                    }
                }
            }
        });
    });

    // Active Nav Link on Scroll (apenas na homepage)
    if (isHomepage) {
        const navLinks = document.querySelectorAll('.nav-link');
        window.addEventListener('scroll', function() {
            const sections = document.querySelectorAll('section[id]');
            const scrollPos = window.pageYOffset + 100;

            sections.forEach(section => {
                const top = section.offsetTop;
                const bottom = top + section.offsetHeight;
                const id = section.getAttribute('id');

                if (scrollPos >= top && scrollPos < bottom) {
                    navLinks.forEach(link => {
                        link.classList.remove('text-emerald-600', 'dark:text-emerald-400');
                        const linkHref = link.getAttribute('href');
                        const linkAnchor = link.getAttribute('data-anchor');
                        if (linkHref === `#${id}` || linkAnchor === id) {
                            link.classList.add('text-emerald-600', 'dark:text-emerald-400');
                        }
                    });
                }
            });
        });
    } else {
        // Se não estiver na homepage, destacar o link baseado na URL atual
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.nav-link');

        // Remover destaque de todos os links quando não estiver na homepage
        navLinks.forEach(link => {
            link.classList.remove('text-emerald-600', 'dark:text-emerald-400');
        });
    }

    // O dark-mode.js cuida do toggle de tema e ícones
});
</script>
