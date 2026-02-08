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
                        <x-icon name="house" style="duotone" class="w-4 h-4" />
                        Início
                    </span>
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-emerald-600 transition-all group-hover:w-full"></span>
                </a>
                @endif
                @if($navbarConfigs['servicos'])
                <a href="{{ $isHomepage ? '#servicos' : $homepageUrl . '#servicos' }}" class="nav-link text-gray-700 dark:text-gray-300 hover:text-emerald-600 dark:hover:text-emerald-400 font-medium transition-colors relative group" data-anchor="servicos">
                    <span class="flex items-center gap-2">
                        <x-icon name="grid-2" style="duotone" class="w-4 h-4" />
                        Serviços
                    </span>
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-emerald-600 transition-all group-hover:w-full"></span>
                </a>
                @endif
                @if($navbarConfigs['sobre'])
                <a href="{{ $isHomepage ? '#sobre' : $homepageUrl . '#sobre' }}" class="nav-link text-gray-700 dark:text-gray-300 hover:text-emerald-600 dark:hover:text-emerald-400 font-medium transition-colors relative group" data-anchor="sobre">
                    <span class="flex items-center gap-2">
                        <x-icon name="circle-info" style="duotone" class="w-4 h-4" />
                        Sobre
                    </span>
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-emerald-600 transition-all group-hover:w-full"></span>
                </a>
                @endif
                @if(\Nwidart\Modules\Facades\Module::isEnabled('Blog'))
                <a href="{{ route('blog.index') }}" class="nav-link text-gray-700 dark:text-gray-300 hover:text-emerald-600 dark:hover:text-emerald-400 font-medium transition-colors relative group">
                    <span class="flex items-center gap-2">
                        <x-icon name="newspaper" style="duotone" class="w-4 h-4" />
                        Blog
                    </span>
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-emerald-600 transition-all group-hover:w-full"></span>
                </a>
                @endif
                @if($navbarConfigs['consulta'])
                <a href="{{ $isHomepage ? '#consulta' : $homepageUrl . '#consulta' }}" class="nav-link text-gray-700 dark:text-gray-300 hover:text-emerald-600 dark:hover:text-emerald-400 font-medium transition-colors relative group" data-anchor="consulta">
                    <span class="flex items-center gap-2">
                        <x-icon name="magnifying-glass" style="duotone" class="w-4 h-4" />
                        Consultar Demanda
                    </span>
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-emerald-600 transition-all group-hover:w-full"></span>
                </a>
                @endif
                @if($navbarConfigs['contato'])
                <a href="{{ $isHomepage ? '#contato' : $homepageUrl . '#contato' }}" class="nav-link text-gray-700 dark:text-gray-300 hover:text-emerald-600 dark:hover:text-emerald-400 font-medium transition-colors relative group" data-anchor="contato">
                    <span class="flex items-center gap-2">
                        <x-icon name="envelope" style="duotone" class="w-4 h-4" />
                        Contato
                    </span>
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-emerald-600 transition-all group-hover:w-full"></span>
                </a>
                @endif
            </div>

            <!-- Right Side Actions -->
            <div class="flex items-center gap-4">
                <!-- Botão Consultar Demanda -->
                <a href="{{ route('demandas.public.consulta') }}" class="hidden md:inline-flex items-center gap-1.5 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 border border-blue-200 dark:border-blue-800 px-3 py-1.5 rounded-lg text-sm font-medium hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
                    <x-icon name="magnifying-glass" style="duotone" class="w-4 h-4" />
                    <span>Consultar Demanda</span>
                </a>

                <!-- Botão Portal do Morador -->
                @if(\Nwidart\Modules\Facades\Module::isEnabled('Pocos') && Route::has('morador-poco.index'))
                <a href="{{ route('morador-poco.index') }}" class="hidden md:inline-flex items-center gap-1.5 bg-teal-50 dark:bg-teal-900/20 text-teal-700 dark:text-teal-400 border border-teal-200 dark:border-teal-800 px-3 py-1.5 rounded-lg text-sm font-medium hover:bg-teal-100 dark:hover:bg-teal-900/30 transition-colors">
                    <x-icon name="faucet-drip" style="duotone" class="w-4 h-4" />
                    <span>Portal do Morador</span>
                </a>
                @endif

                <!-- Theme Toggle -->
                <button type="button" id="darkModeToggle" onclick="toggleTheme()" class="relative w-12 h-12 rounded-full bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 flex items-center justify-center transition-all duration-300 hover:scale-110 group" aria-label="Alternar tema">
                    <span id="theme-icon-sun" class="absolute transition-all duration-300">
                        <x-icon name="sun" style="duotone" class="w-5 h-5 text-yellow-500" />
                    </span>
                    <span id="theme-icon-moon" class="absolute transition-all duration-300 hidden">
                        <x-icon name="moon" style="duotone" class="w-5 h-5 text-blue-400" />
                    </span>
                </button>

                @auth
                    <a href="{{ route(get_dashboard_route()) }}" class="hidden md:flex items-center gap-2 text-gray-700 dark:text-gray-300 hover:text-emerald-600 dark:hover:text-emerald-400 font-medium transition-colors">
                        <x-icon name="bolt" style="duotone" class="w-5 h-5" />
                        <span>Painel</span>
                    </a>

                    <!-- User Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors">
                            <x-icon name="user" style="duotone" class="w-5 h-5" />
                            <span class="hidden md:inline">{{ Auth::user()->name }}</span>
                            <x-icon name="chevron-down" class="w-4 h-4 transition-transform group-hover:rotate-180" />
                        </button>

                        <div class="absolute right-0 mt-2 w-56 bg-white dark:bg-slate-800 rounded-xl shadow-xl border border-gray-200 dark:border-slate-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                            <div class="p-4 border-b border-gray-200 dark:border-slate-700">
                                <p class="font-semibold text-gray-900 dark:text-white">{{ Auth::user()->name }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ Auth::user()->email }}</p>
                            </div>
                            <div class="p-2">
                                @php
                                    $user = Auth::user();
                                    $role = $user->roles->first();
                                    $profileRoute = null;

                                    if ($role) {
                                        switch ($role->name) {
                                            case 'admin':
                                                $profileRoute = route('admin.profile');
                                                break;
                                            case 'co-admin':
                                                $profileRoute = route('co-admin.profile');
                                                break;
                                            case 'campo':
                                                $profileRoute = route('campo.profile.index');
                                                break;
                                        }
                                    }
                                @endphp

                                @if($profileRoute)
                                <a href="{{ $profileRoute }}" class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-700 text-gray-700 dark:text-gray-300 transition-colors">
                                    <x-icon name="user-gear" style="duotone" class="w-5 h-5" />
                                    <span>Perfil</span>
                                </a>
                                @endif

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20 text-red-600 dark:text-red-400 transition-colors">
                                        <x-icon name="right-from-bracket" style="duotone" class="w-5 h-5" />
                                        <span>Sair</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="hidden md:inline-flex items-center gap-1.5 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 px-3 py-1.5 rounded-lg text-sm font-medium hover:bg-emerald-100 dark:hover:bg-emerald-900/30 transition-colors">
                        <x-icon name="right-to-bracket" style="duotone" class="w-4 h-4" />
                        <span>Entrar</span>
                    </a>
                @endauth

                <!-- Mobile Menu Button -->
                <button id="mobileMenuToggle" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-lg bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors">
                    <x-icon name="bars" class="w-6 h-6 text-gray-700 dark:text-gray-300" />
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden lg:hidden pb-4 border-t border-gray-200 dark:border-slate-700 mt-4">
            <div class="flex flex-col gap-2 pt-4">
                @if($navbarConfigs['inicio'])
                <a href="{{ $isHomepage ? '#inicio' : $homepageUrl . '#inicio' }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors" data-anchor="inicio">
                    <x-icon name="house" style="duotone" class="w-5 h-5" />
                    <span>Início</span>
                </a>
                @endif
                @if($navbarConfigs['servicos'])
                <a href="{{ $isHomepage ? '#servicos' : $homepageUrl . '#servicos' }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors" data-anchor="servicos">
                    <x-icon name="grid-2" style="duotone" class="w-5 h-5" />
                    <span>Serviços</span>
                </a>
                @endif
                @if($navbarConfigs['sobre'])
                <a href="{{ $isHomepage ? '#sobre' : $homepageUrl . '#sobre' }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors" data-anchor="sobre">
                    <x-icon name="circle-info" style="duotone" class="w-5 h-5" />
                    <span>Sobre</span>
                </a>
                @endif
                @if(\Nwidart\Modules\Facades\Module::isEnabled('Blog'))
                <a href="{{ route('blog.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                    <x-icon name="newspaper" style="duotone" class="w-5 h-5" />
                    <span>Blog</span>
                </a>
                @endif
                @if($navbarConfigs['consulta'])
                <a href="{{ $isHomepage ? '#consulta' : $homepageUrl . '#consulta' }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors" data-anchor="consulta">
                    <x-icon name="magnifying-glass" style="duotone" class="w-5 h-5" />
                    <span>Consultar Demanda</span>
                </a>
                @endif
                @if($navbarConfigs['contato'])
                <a href="{{ $isHomepage ? '#contato' : $homepageUrl . '#contato' }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors" data-anchor="contato">
                    <x-icon name="envelope" style="duotone" class="w-5 h-5" />
                    <span>Contato</span>
                </a>
                @endif

                @guest
                    <div class="pt-2 border-t border-gray-200 dark:border-slate-700 mt-2 space-y-2">
                        <a href="{{ route('demandas.public.consulta') }}" class="flex items-center justify-center gap-2 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 border border-blue-200 dark:border-blue-800 px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
                            <x-icon name="magnifying-glass" style="duotone" class="w-4 h-4" />
                            <span>Consultar Demanda</span>
                        </a>
                        @if(\Nwidart\Modules\Facades\Module::isEnabled('Pocos') && Route::has('morador-poco.index'))
                        <a href="{{ route('morador-poco.index') }}" class="flex items-center justify-center gap-2 bg-teal-50 dark:bg-teal-900/20 text-teal-700 dark:text-teal-400 border border-teal-200 dark:border-teal-800 px-4 py-2 rounded-lg text-sm font-medium hover:bg-teal-100 dark:hover:bg-teal-900/30 transition-colors">
                            <x-icon name="faucet-drip" style="duotone" class="w-4 h-4" />
                            <span>Portal do Morador</span>
                        </a>
                        @endif
                        <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 px-4 py-2 rounded-lg text-sm font-medium hover:bg-emerald-100 dark:hover:bg-emerald-900/30 transition-colors">
                            <x-icon name="right-to-bracket" style="duotone" class="w-4 h-4" />
                            <span>Entrar</span>
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
});
</script>
