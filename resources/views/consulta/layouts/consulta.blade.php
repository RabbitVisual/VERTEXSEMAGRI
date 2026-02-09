<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Painel Consulta') - VERTEXSEMAGRI</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <!-- Inicialização do tema ANTES do CSS para evitar FOUC -->
    <script>
        (function() {
            try {
                const savedTheme = localStorage.getItem('theme') || 'light';
                const html = document.documentElement;

                // Aplicar tema antes de qualquer CSS ser carregado
                if (savedTheme === 'dark') {
                    html.classList.add('dark');
                } else {
                    html.classList.remove('dark');
                }
            } catch (e) {
                // Fallback silencioso se localStorage não estiver disponível
                console.warn('Theme initialization failed:', e);
            }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full bg-gray-50 dark:bg-slate-900 transition-colors duration-200 antialiased">
    <div id="app" class="min-h-full flex flex-col">
        @auth
            @include('consulta.layouts.navbar-consulta')
            <div class="flex-1 flex overflow-hidden pt-16">
                <!-- Desktop Sidebar -->
                <aside id="consultaSidebar" class="hidden lg:flex lg:flex-shrink-0 lg:w-72">
                    <div class="flex flex-col h-full w-full">
                        @include('consulta.layouts.sidebar-consulta')
                    </div>
                </aside>

                <!-- Mobile Sidebar Overlay -->
                <div id="sidebarOverlay" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-40 lg:hidden hidden transition-opacity duration-300" onclick="toggleConsultaSidebar()"></div>

                <!-- Mobile Sidebar -->
                <aside id="mobileConsultaSidebar" class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-800 dark:bg-slate-900 transform -translate-x-full transition-transform duration-300 ease-in-out lg:hidden shadow-2xl">
                    <div class="flex flex-col h-full">
                        @include('consulta.layouts.sidebar-consulta')
                    </div>
                </aside>

                <!-- Main Content -->
                <main class="flex-1 overflow-y-auto bg-gray-50 dark:bg-slate-900">
                    <div class="py-4 sm:py-6 lg:py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full">
                        <!-- Flash Messages -->
                        @if(session('success'))
                            <div class="mb-4 md:mb-6 rounded-xl bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 p-4 shadow-sm animate-in slide-in-from-top">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-blue-800 dark:text-blue-200">{{ session('success') }}</p>
                                    </div>
                                    <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="mb-4 md:mb-6 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-4 shadow-sm animate-in slide-in-from-top">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-red-800 dark:text-red-200">{{ session('error') }}</p>
                                    </div>
                                    <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endif

                        @if(session('warning'))
                            <div class="mb-4 md:mb-6 rounded-xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 p-4 shadow-sm animate-in slide-in-from-top">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-amber-800 dark:text-amber-200">{!! session('warning') !!}</p>
                                    </div>
                                    <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-amber-600 dark:text-amber-400 hover:text-amber-800 dark:hover:text-amber-200">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="mb-4 md:mb-6 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-4 shadow-sm">
                                <div class="flex items-start gap-3">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-sm font-semibold text-red-800 dark:text-red-200 mb-2">Erros encontrados:</h3>
                                        <ul class="space-y-1 text-sm text-red-700 dark:text-red-300">
                                            @foreach($errors->all() as $error)
                                                <li class="flex items-start gap-2">
                                                    <span class="text-red-500 mt-0.5">•</span>
                                                    <span>{{ $error }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @endif

                        @yield('content')
                    </div>
                </main>
            </div>
        @else
            @yield('content')
        @endauth
    </div>

    <script>
        // Consulta Sidebar toggle function
        function toggleConsultaSidebar() {
            const sidebar = document.getElementById('mobileConsultaSidebar');
            const overlay = document.getElementById('sidebarOverlay');

            if (sidebar && overlay) {
                const isHidden = sidebar.classList.contains('-translate-x-full');
                if (isHidden) {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                } else {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.style.overflow = '';
                }
            }
        }

        // Sidebar toggle button
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('sidebarToggle');
            if (toggleBtn) {
                toggleBtn.addEventListener('click', toggleConsultaSidebar);
            }
        });

        // User menu dropdown toggle
        document.addEventListener('DOMContentLoaded', function() {
            function initDropdowns() {
                const dropdownTriggers = document.querySelectorAll('[data-dropdown-trigger]');
                dropdownTriggers.forEach(trigger => {
                    // Remover listeners anteriores se existirem
                    const newTrigger = trigger.cloneNode(true);
                    trigger.parentNode.replaceChild(newTrigger, trigger);

                    newTrigger.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        const dropdown = this.closest('[data-dropdown]');
                        if (!dropdown) return;

                        const menu = dropdown.querySelector('[data-dropdown-menu]');
                        if (!menu) return;

                        const isHidden = menu.classList.contains('hidden');

                        // Fechar todos os outros dropdowns
                        document.querySelectorAll('[data-dropdown-menu]').forEach(m => {
                            if (m !== menu) {
                                m.classList.add('hidden');
                            }
                        });

                        // Toggle do menu atual
                        if (isHidden) {
                            menu.classList.remove('hidden');
                        } else {
                            menu.classList.add('hidden');
                        }
                    });
                });
            }

            // Inicializar dropdowns
            initDropdowns();

            // Fechar dropdown ao clicar fora
            document.addEventListener('click', function(e) {
                if (!e.target.closest('[data-dropdown]')) {
                    document.querySelectorAll('[data-dropdown-menu]').forEach(menu => {
                        menu.classList.add('hidden');
                    });
                }
            });
        });

        // Theme toggle
        function toggleTheme() {
            const html = document.documentElement;
            const isDark = html.classList.contains('dark');

            if (isDark) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }

        // Theme toggle button
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggle = document.getElementById('themeToggle');
            if (themeToggle) {
                themeToggle.addEventListener('click', toggleTheme);
            }
        });

        // Função para fazer logout com fallback para GET se CSRF expirar
        window.handleLogout = function() {
            const logoutUrl = '{{ route("logout") }}';
            const logoutUrlGet = '{{ route("logout.get") }}';
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            // Tentar fazer logout via POST primeiro
            if (csrfToken) {
                fetch(logoutUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'
                })
                .then(response => {
                    if (response.ok || response.redirected) {
                        window.location.href = '{{ route("login") }}';
                    } else if (response.status === 419) {
                        // Token CSRF expirado, usar GET como fallback
                        window.location.href = logoutUrlGet;
                    } else {
                        // Outro erro, tentar GET mesmo assim
                        window.location.href = logoutUrlGet;
                    }
                })
                .catch(error => {
                    console.error('Erro ao fazer logout:', error);
                    // Em caso de erro, usar GET como fallback
                    window.location.href = logoutUrlGet;
                });
            } else {
                // Sem token CSRF, usar GET diretamente
                window.location.href = logoutUrlGet;
            }
        };
    </script>

    @stack('scripts')

    <!-- Global Loading Overlay -->
    <x-loading-overlay />
</body>
</html>
