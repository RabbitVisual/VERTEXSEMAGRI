<nav class="flex flex-col h-full bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700">
    <!-- Header Sidebar - HyperUI Card Style -->
    <div class="flex items-center justify-between p-4 lg:p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-md">
                <x-icon name="file-pdf" class="w-5 h-5" />
            </div>
            <span class="flex-1">Minhas Solicitações</span>
            @if(request()->routeIs('campo.materiais.solicitacoes.*'))
            <div class="w-1.5 h-1.5 rounded-full bg-emerald-600 dark:bg-emerald-400"></div>
            @endif
        </a>

        <!-- Separador -->
        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Filtros Rápidos</h3>
            </div>
        </div>

        <!-- Ordens Pendentes -->
        <a href="{{ route('campo.ordens.index', ['status' => 'pendente']) }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->get('status') === 'pendente' ? 'bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 shadow-sm' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->get('status') === 'pendente' ? 'bg-amber-500 dark:bg-amber-600' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-amber-100 dark:group-hover:bg-amber-900/30' }} transition-colors">
                <x-icon name="file-pdf" class="w-5 h-5" />
            </div>
            <span class="flex-1">Solicitar Material</span>
            @if(request()->routeIs('campo.materiais.*'))
            <div class="w-1.5 h-1.5 rounded-full bg-emerald-600 dark:bg-emerald-400"></div>
            @endif
        </a>

        <!-- Chat Interno -->
        <a href="{{ route('campo.chat.page') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('campo.chat.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('campo.chat.*') ? 'bg-blue-500 dark:bg-blue-600' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-blue-100 dark:group-hover:bg-blue-900/30' }} transition-colors">
                <svg class="w-5 h-5 {{ request()->routeIs('campo.chat.*') ? 'text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 01-.825-.242m9.345-8.334a2.126 2.126 0 00-.476-.095 48.64 48.64 0 00-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0011.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
                </svg>
            </div>
            <span class="flex-1">Chat</span>
            @if(request()->routeIs('campo.chat.*'))
            <div class="w-1.5 h-1.5 rounded-full bg-blue-600 dark:bg-blue-400"></div>
            @endif
        </a>

        <!-- Separador -->
        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Conta</h3>
            </div>
        </div>

        <!-- Meu Perfil -->
        <a href="{{ route('campo.profile.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('campo.profile.*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 shadow-sm' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('campo.profile.*') ? 'bg-indigo-500 dark:bg-indigo-600' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/30' }} transition-colors">
                <svg class="w-5 h-5 {{ request()->routeIs('campo.profile.*') ? 'text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <span class="flex-1">Meu Perfil</span>
            @if(request()->routeIs('campo.profile.*'))
            <div class="w-1.5 h-1.5 rounded-full bg-indigo-600 dark:bg-indigo-400"></div>
            @endif
        </a>
    </div>

    <!-- Widget de Clima no Sidebar -->
    <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700">
        <div class="px-3 mb-3">
            <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Informações</h3>
        </div>
    </div>

    <!-- Widget de Clima -->
    <div class="px-3 mb-3">
        <div class="bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 rounded-xl border border-blue-200 dark:border-blue-800 overflow-hidden">
            <div class="px-4 py-3 border-b border-blue-200 dark:border-blue-800 bg-white/50 dark:bg-gray-800/50">
                <h3 class="text-xs font-bold text-gray-900 dark:text-white flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15a4.5 4.5 0 004.5 4.5H9a3 3 0 003-3V9a3 3 0 00-3-3H6.75a4.5 4.5 0 00-4.5 4.5v6zM2.25 19h19.5M2.25 19l1.5-7.5M21.75 19l-1.5-7.5" />
                    </svg>
                    <span>Clima</span>
                </h3>
            </div>
            <div class="p-4">
                <div id="widget-clima" class="text-center">
                    <div class="animate-pulse space-y-2">
                        <div class="h-12 bg-gray-200 dark:bg-gray-700 rounded-lg"></div>
                        <div class="h-3 bg-gray-200 dark:bg-gray-700 rounded w-3/4 mx-auto"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Sidebar - HyperUI Card Style -->
    <div class="flex-shrink-0 p-4 border-t border-gray-200 dark:border-gray-700 bg-gradient-to-br from-gray-50 to-white dark:from-gray-900/50 dark:to-gray-800">
        <div class="text-center space-y-2">
            <p class="text-xs font-semibold text-gray-600 dark:text-gray-400">Painel Campo</p>
            <p class="text-xs text-gray-500 dark:text-gray-500">v3.0.0</p>
            <!-- Status de Conexão -->
            <div id="sidebar-connection-status" class="inline-flex items-center justify-center gap-1.5 text-xs px-3 py-1.5 rounded-lg transition-all duration-300">
                <span class="status-dot w-2 h-2 rounded-full animate-pulse"></span>
                <span class="status-text font-medium">Verificando...</span>
            </div>
        </div>
    </div>

    <!-- Script inline para garantir execução imediata -->
    <script>
        (function() {
            'use strict';

            function atualizarStatusConexao() {
                const statusEl = document.getElementById('sidebar-connection-status');
                if (!statusEl) {
                    // Tentar novamente após um pequeno delay
                    setTimeout(atualizarStatusConexao, 100);
                    return;
                }

                const statusDot = statusEl.querySelector('.status-dot');
                const statusText = statusEl.querySelector('.status-text');
                if (!statusDot || !statusText) {
                    setTimeout(atualizarStatusConexao, 100);
                    return;
                }

                const isOnline = navigator.onLine;

                // Remover todas as classes de status anteriores
                statusEl.className = 'inline-flex items-center justify-center gap-1.5 text-xs px-3 py-1.5 rounded-lg transition-all duration-300';

                if (isOnline) {
                    statusEl.classList.add('bg-green-50', 'dark:bg-green-900/20', 'border', 'border-green-200', 'dark:border-green-800');
                    statusDot.className = 'status-dot w-2 h-2 rounded-full bg-green-500 dark:bg-green-400';
                    statusText.className = 'status-text font-medium text-green-700 dark:text-green-400';
                    statusText.textContent = 'Online';
                } else {
                    statusEl.classList.add('bg-red-50', 'dark:bg-red-900/20', 'border', 'border-red-200', 'dark:border-red-800');
                    statusDot.className = 'status-dot w-2 h-2 rounded-full bg-red-500 dark:bg-red-400';
                    statusText.className = 'status-text font-medium text-red-700 dark:text-red-400';
                    statusText.textContent = 'Offline';
                }
            }

            // Função para inicializar quando DOM estiver pronto
            function inicializarStatus() {
                atualizarStatusConexao();

                // Event listeners para mudanças de conexão
                window.addEventListener('online', function() {
                    atualizarStatusConexao();
                });

                window.addEventListener('offline', function() {
                    atualizarStatusConexao();
                });

                // Verificar periodicamente (a cada 10 segundos)
                setInterval(function() {
                    atualizarStatusConexao();
                }, 10000);
            }

            // Executar quando DOM estiver pronto
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', inicializarStatus);
            } else {
                // DOM já está pronto, executar imediatamente
                inicializarStatus();
            }

            // Também executar após um pequeno delay para garantir que o elemento esteja disponível
            setTimeout(function() {
                atualizarStatusConexao();
            }, 200);
        })();
    </script>

    <!-- Script inline para garantir execução em produção -->
    <script>
        (function() {
            'use strict';

            // Função para carregar clima no sidebar (Open-Meteo - API Pública Gratuita)
            async function carregarClimaSidebar() {
                const widget = document.getElementById('widget-clima');
                if (!widget) {
                    // Tentar novamente após um pequeno delay se o elemento não existir
                    setTimeout(carregarClimaSidebar, 100);
                    return;
                }

                // Bloquear se offline - mostrar mensagem apropriada
                if (!navigator.onLine) {
                    widget.innerHTML = `
                        <div class="space-y-2">
                            <div class="text-3xl">🌤️</div>
                            <div class="text-xl font-bold text-gray-900 dark:text-white">--°C</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">Offline</div>
                            <div class="text-xs text-gray-500 dark:text-gray-500 pt-1">Requer conexão</div>
                        </div>
                    `;
                    return;
                }

                try {
                    // Coordenadas padrão (Coração de Maria - BA)
                    const lat = -12.2333;
                    const lon = -38.7500;

                    // Open-Meteo API - Pública e gratuita, sem necessidade de chave
                    const response = await fetch(`https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current=temperature_2m,relative_humidity_2m,weather_code&timezone=America/Bahia&forecast_days=1`, {
                        method: 'GET',
                        mode: 'cors',
                        cache: 'no-cache'
                    });

                    if (!response.ok) {
                        throw new Error('Erro ao buscar clima: ' + response.status);
                    }

                    const data = await response.json();
                    const current = data.current;

                    // Mapear códigos de clima do WMO
                    const weatherCodeMap = {
                        0: { icon: '☀️', desc: 'Céu limpo' },
                        1: { icon: '🌤️', desc: 'Principalmente limpo' },
                        2: { icon: '⛅', desc: 'Parcialmente nublado' },
                        3: { icon: '☁️', desc: 'Nublado' },
                        45: { icon: '🌫️', desc: 'Nevoeiro' },
                        48: { icon: '🌫️', desc: 'Nevoeiro gelado' },
                        51: { icon: '🌦️', desc: 'Chuva leve' },
                        53: { icon: '🌦️', desc: 'Chuva moderada' },
                        55: { icon: '🌧️', desc: 'Chuva forte' },
                        61: { icon: '🌧️', desc: 'Chuva leve' },
                        63: { icon: '🌧️', desc: 'Chuva moderada' },
                        65: { icon: '🌧️', desc: 'Chuva forte' },
                        71: { icon: '❄️', desc: 'Neve leve' },
                        73: { icon: '❄️', desc: 'Neve moderada' },
                        75: { icon: '❄️', desc: 'Neve forte' },
                        80: { icon: '🌦️', desc: 'Pancadas de chuva leve' },
                        81: { icon: '🌦️', desc: 'Pancadas de chuva moderada' },
                        82: { icon: '🌧️', desc: 'Pancadas de chuva forte' },
                        95: { icon: '⛈️', desc: 'Trovoada' },
                        96: { icon: '⛈️', desc: 'Trovoada com granizo' },
                        99: { icon: '⛈️', desc: 'Trovoada forte' }
                    };

                    const weatherInfo = weatherCodeMap[current.weather_code] || { icon: '🌤️', desc: 'Condições desconhecidas' };
                    const temp = Math.round(current.temperature_2m);
                    const umidade = Math.round(current.relative_humidity_2m);

                    widget.innerHTML = `
                        <div class="space-y-2">
                            <div class="flex items-center justify-center gap-2">
                                <div class="text-4xl">${weatherInfo.icon}</div>
                                <div>
                                    <div class="text-2xl font-bold text-gray-900 dark:text-white">${temp}°C</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">${weatherInfo.desc}</div>
                                </div>
                            </div>
                            <div class="pt-2 border-t border-blue-200 dark:border-blue-800">
                                <div class="text-xs text-gray-500 dark:text-gray-400">Umidade: <span class="font-semibold text-gray-900 dark:text-white">${umidade}%</span></div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Coração de Maria - BA</div>
                            </div>
                        </div>
                    `;
                } catch (error) {
                    if (typeof logger !== 'undefined') {
                        logger.error('[Sidebar Clima] Erro ao carregar clima:', error);
                    }
                    widget.innerHTML = `
                        <div class="space-y-2">
                            <div class="text-3xl">🌤️</div>
                            <div class="text-xl font-bold text-gray-900 dark:text-white">--°C</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">Erro ao carregar</div>
                        </div>
                    `;
                }
            }

            // Função de inicialização robusta
            function inicializarClima() {
                // Múltiplas tentativas para garantir que o elemento esteja disponível
                let tentativas = 0;
                const maxTentativas = 10;

                function tentarCarregar() {
                    const widget = document.getElementById('widget-clima');
                    if (widget) {
                        carregarClimaSidebar();
                        // Atualizar clima a cada 10 minutos quando online
                        setInterval(function() {
                            if (navigator.onLine) {
                                carregarClimaSidebar();
                            }
                        }, 600000);
                    } else if (tentativas < maxTentativas) {
                        tentativas++;
                        setTimeout(tentarCarregar, 200);
                    }
                }

                // Tentar carregar imediatamente
                tentarCarregar();
            }

            // Executar quando DOM estiver pronto
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', inicializarClima);
            } else {
                // DOM já está pronto
                inicializarClima();
            }

            // Recarregar clima quando voltar online
            window.addEventListener('online', function() {
                carregarClimaSidebar();
            });

            // Tornar função disponível globalmente para debug
            window.carregarClimaSidebar = carregarClimaSidebar;
        })();
    </script>
</nav>
