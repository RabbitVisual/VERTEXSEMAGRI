@extends('campo.layouts.app')

@section('title', 'Dashboard Campo')

@section('content')

<style>[x-cloak] { display: none !important; }</style>

<div x-data="{
    status: 'online',
    filtrosOpen: false,
    exportOpen: false,
    currentTip: 0,
    tips: [
        'Use EPIs sempre que manusear produtos químicos.',
        'Verifique a pressão da água antes de iniciar os reparos.',
        'Mantenha as ferramentas limpas para maior durabilidade.',
        'Reporte qualquer incidente de segurança imediatamente.'
    ],
    init() {
        setInterval(() => {
            this.currentTip = (this.currentTip + 1) % this.tips.length;
        }, 8000);
    }
}" class="space-y-6 md:space-y-8">
    <!-- Hero Section & Status -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 pb-6 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-violet-600 dark:from-indigo-400 dark:to-violet-400">
                    Olá, {{ Auth::user()->name }}
                </span>
            </h1>
            <p class="text-gray-600 dark:text-gray-400 flex items-center gap-2">
                <span class="relative flex h-2.5 w-2.5">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                </span>
                Painel Operacional Ativo
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-4">
            <!-- Status Toggle (Pill Switch) -->
            <div class="flex items-center gap-3 bg-white dark:bg-gray-800 p-1.5 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <span class="text-xs font-bold text-gray-500 dark:text-gray-400 pl-2 uppercase tracking-wide">Status:</span>
                <div class="flex bg-gray-100 dark:bg-gray-700 rounded-lg p-1">
                    <button @click="status = 'online'"
                            class="px-3 py-1.5 rounded-md text-xs font-bold transition-all duration-200"
                            :class="status === 'online' ? 'bg-white dark:bg-gray-600 text-emerald-600 dark:text-emerald-400 shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'">
                        DISPONÍVEL
                    </button>
                    <button @click="status = 'busy'"
                            class="px-3 py-1.5 rounded-md text-xs font-bold transition-all duration-200"
                            :class="status === 'busy' ? 'bg-white dark:bg-gray-600 text-red-600 dark:text-red-400 shadow-sm' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300'">
                        OCUPADO
                    </button>
                </div>
            </div>

            <!-- Exportar -->
            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                <button @click="open = !open" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-700 dark:text-gray-300 font-medium transition-colors shadow-sm">
                    <x-icon name="file-pdf" class="w-5 h-5" />
                        <span class="text-sm font-medium text-gray-900 dark:text-white">Solicitar Material</span>
                    </a>

                    <a href="{{ route('campo.profile.index') }}" class="flex items-center gap-3 p-3 rounded-xl bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-800 hover:bg-indigo-100 dark:hover:bg-indigo-900/30 transition-colors">
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">Meu Perfil</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Função para fechar o alerta de ordens pendentes
    function dismissOrdensAlerta() {
        const alerta = document.getElementById('ordens-alerta');
        if (alerta) {
            // Salvar no localStorage que o usuário fechou o alerta
            const hoje = new Date().toDateString();
            localStorage.setItem('ordens-alerta-dismissed', hoje);

            // Animação de fade out
            alerta.style.transition = 'opacity 0.3s ease-out, transform 0.3s ease-out';
            alerta.style.opacity = '0';
            alerta.style.transform = 'translateY(-10px)';

            setTimeout(() => {
                alerta.remove();
            }, 300);
        }
    }

    // Verificar se o alerta foi fechado hoje
    document.addEventListener('DOMContentLoaded', function() {
        const alerta = document.getElementById('ordens-alerta');
        if (alerta) {
            const hoje = new Date().toDateString();
            const dismissed = localStorage.getItem('ordens-alerta-dismissed');

            // Se foi fechado hoje, não mostrar
            if (dismissed === hoje) {
                alerta.remove();
            } else {
                // Limpar dismiss antigo se for de outro dia
                if (dismissed && dismissed !== hoje) {
                    localStorage.removeItem('ordens-alerta-dismissed');
                }

                // Animação de entrada
                alerta.style.opacity = '0';
                alerta.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    alerta.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
                    alerta.style.opacity = '1';
                    alerta.style.transform = 'translateY(0)';
                }, 100);
            }
        }
    });

    // Atualizar alerta quando houver mudanças offline
    if (window.campoOffline) {
        // Verificar ordens pendentes do cache offline periodicamente
        async function verificarOrdensOffline() {
            try {
                const ordens = await window.campoOffline.getAllOrdens();
                const pendentes = ordens.filter(o => o.status === 'pendente');
                const alerta = document.getElementById('ordens-alerta');

                // Se houver pendentes offline e não houver alerta, atualizar contador
                if (pendentes.length > 0) {
                    if (typeof logger !== 'undefined') {
                        logger.log('[Campo Alerta] Ordens pendentes detectadas offline:', pendentes.length);
                    }

                    // Atualizar contador se existir
                    const contador = document.querySelector('[data-pendentes-count]');
                    if (contador) {
                        contador.textContent = pendentes.length;
                    }
                }
            } catch (err) {
                if (typeof logger !== 'undefined') {
                    logger.warn('[Campo Alerta] Erro ao verificar ordens offline:', err);
                }
            }
        }

        // Verificar a cada 30 segundos quando offline
        if (!navigator.onLine) {
            verificarOrdensOffline();
            setInterval(verificarOrdensOffline, 30000);
        }
    }

    // ============================================
    // FUNCIONALIDADES AVANÇADAS
    // ============================================

    // Toggle Export & Filtros
    // (Funcionalidade movida para Alpine.js)

    // Carregar localidades para filtro
    async function carregarLocalidades() {
        try {
            const response = await fetch('{{ route("campo.dashboard.filtros") }}');
            const data = await response.json();

            if (data.success && data.localidades) {
                const select = document.getElementById('filtro-localidade');
                data.localidades.forEach(localidade => {
                    const option = document.createElement('option');
                    option.value = localidade.id;
                    option.textContent = `${localidade.nome} (${localidade.tipo})`;
                    select.appendChild(option);
                });
            }
        } catch (error) {
            console.error('Erro ao carregar localidades:', error);
        }
    }

    // Aplicar Filtros
    function aplicarFiltros() {
        const form = document.getElementById('filtros-form');
        const formData = new FormData(form);
        const params = new URLSearchParams();

        for (const [key, value] of formData.entries()) {
            if (value && key !== 'periodo') params.append(key, value);
        }

        // Processar período
        const periodo = formData.get('periodo');
        if (periodo && periodo !== 'custom') {
            fetch('{{ route("campo.dashboard.filtros") }}')
                .then(r => r.json())
                .then(data => {
                    if (data.periodos && data.periodos[periodo]) {
                        params.set('data_inicio', data.periodos[periodo].inicio);
                        params.set('data_fim', data.periodos[periodo].fim);
                        window.location.href = '{{ route("campo.ordens.index") }}?' + params.toString();
                    }
                });
        } else if (periodo === 'custom') {
            window.location.href = '{{ route("campo.ordens.index") }}?' + params.toString();
        } else {
            window.location.href = '{{ route("campo.ordens.index") }}?' + params.toString();
        }
    }

    // Limpar Filtros
    function limparFiltros() {
        document.getElementById('filtros-form').reset();
        window.location.href = '{{ route("campo.ordens.index") }}';
    }

    // Mostrar campos de data customizada
    document.addEventListener('DOMContentLoaded', function() {
        const periodoSelect = document.getElementById('filtro-periodo');
        if (periodoSelect) {
            periodoSelect.addEventListener('change', function() {
                const custom = this.value === 'custom';
                document.getElementById('filtro-data-inicio-container').classList.toggle('hidden', !custom);
                document.getElementById('filtro-data-fim-container').classList.toggle('hidden', !custom);
            });
        }
    });

    // ============================================
    // GRÁFICOS COM CHART.JS (Local via Vite)
    // Chart.js já está disponível via resources/js/chart-admin.js importado no app.js
    // chart-admin.js disponibiliza Chart globalmente como window.Chart
    // ============================================
    @if(isset($dadosGraficos))
    // Aguardar Chart.js estar disponível (carregado via app.js -> chart-admin.js)
    function inicializarGraficos() {
        // Verificar se Chart está disponível (disponibilizado globalmente em chart-admin.js)
        if (typeof window.Chart === 'undefined' && typeof Chart === 'undefined') {
            console.warn('Chart.js não está disponível. Aguardando...');
            setTimeout(inicializarGraficos, 100);
            return;
        }

        // Usar Chart disponível globalmente (window.Chart do chart-admin.js)
        const ChartClass = window.Chart || Chart;

        // Gráfico de Ordens por Dia
        const ctxOrdens = document.getElementById('graficoOrdensPorDia');
        if (ctxOrdens && ChartClass) {
            const dados = @json($dadosGraficos['ordens_por_dia'] ?? []);
            new ChartClass(ctxOrdens, {
                type: 'line',
                data: {
                    labels: dados.map(d => d.label),
                    datasets: [
                        {
                            label: 'Pendentes',
                            data: dados.map(d => d.pendente),
                            borderColor: 'rgb(245, 158, 11)',
                            backgroundColor: 'rgba(245, 158, 11, 0.1)',
                            tension: 0.4
                        },
                        {
                            label: 'Em Execução',
                            data: dados.map(d => d.em_execucao),
                            borderColor: 'rgb(59, 130, 246)',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.4
                        },
                        {
                            label: 'Concluídas',
                            data: dados.map(d => d.concluida),
                            borderColor: 'rgb(16, 185, 129)',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Gráfico de Prioridades
        const ctxPrioridades = document.getElementById('graficoPrioridades');
        if (ctxPrioridades && ChartClass) {
            const dados = @json($dadosGraficos['ordens_por_prioridade'] ?? []);
            new ChartClass(ctxPrioridades, {
                type: 'doughnut',
                data: {
                    labels: ['Alta', 'Média', 'Baixa'],
                    datasets: [{
                        data: [
                            dados.alta || 0,
                            dados.media || 0,
                            dados.baixa || 0
                        ],
                        backgroundColor: [
                            'rgb(239, 68, 68)',
                            'rgb(245, 158, 11)',
                            'rgb(16, 185, 129)'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                        }
                    }
                }
            });
        }
    }

    // Inicializar gráficos quando DOM estiver pronto e Chart.js disponível
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', inicializarGraficos);
    } else {
        inicializarGraficos();
    }
    @endif

    // ============================================
    // WIDGET DE CLIMA (Open-Meteo - API Pública Gratuita)
    // ============================================
    async function carregarClima() {
        // Carregar clima no dashboard
        await carregarClimaDashboard();

        // Carregar clima no sidebar (se existir)
        await carregarClimaSidebar();
    }

    async function carregarClimaDashboard() {
        const widget = document.getElementById('widget-clima-dashboard');
        if (!widget) return;

        // Bloquear se offline
        if (!navigator.onLine) {
            widget.innerHTML = `
                <div class="space-y-2">
                    <div class="text-4xl">🌤️</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">--°C</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Offline - Requer conexão</div>
                </div>
            `;
            return;
        }

        try {
            // Coordenadas padrão (Coração de Maria - BA)
            const lat = -12.2333;
            const lon = -38.7500;

            // Open-Meteo API - Pública e gratuita, sem necessidade de chave
            const response = await fetch(`https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current=temperature_2m,relative_humidity_2m,weather_code,wind_speed_10m&timezone=America/Bahia&forecast_days=1`);

            if (!response.ok) {
                throw new Error('Erro ao buscar clima');
            }

            const data = await response.json();
            const current = data.current;

            // Mapear códigos de clima do WMO (World Meteorological Organization)
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
                56: { icon: '🌨️', desc: 'Chuva congelante leve' },
                57: { icon: '🌨️', desc: 'Chuva congelante forte' },
                61: { icon: '🌧️', desc: 'Chuva leve' },
                63: { icon: '🌧️', desc: 'Chuva moderada' },
                65: { icon: '🌧️', desc: 'Chuva forte' },
                66: { icon: '🌨️', desc: 'Chuva congelante leve' },
                67: { icon: '🌨️', desc: 'Chuva congelante forte' },
                71: { icon: '❄️', desc: 'Neve leve' },
                73: { icon: '❄️', desc: 'Neve moderada' },
                75: { icon: '❄️', desc: 'Neve forte' },
                77: { icon: '❄️', desc: 'Grãos de neve' },
                80: { icon: '🌦️', desc: 'Pancadas de chuva leve' },
                81: { icon: '🌦️', desc: 'Pancadas de chuva moderada' },
                82: { icon: '🌧️', desc: 'Pancadas de chuva forte' },
                85: { icon: '❄️', desc: 'Pancadas de neve leve' },
                86: { icon: '❄️', desc: 'Pancadas de neve forte' },
                95: { icon: '⛈️', desc: 'Trovoada' },
                96: { icon: '⛈️', desc: 'Trovoada com granizo leve' },
                99: { icon: '⛈️', desc: 'Trovoada com granizo forte' }
            };

            const weatherInfo = weatherCodeMap[current.weather_code] || { icon: '🌤️', desc: 'Condições desconhecidas' };
            const temp = Math.round(current.temperature_2m);
            const umidade = Math.round(current.relative_humidity_2m);
            const vento = Math.round(current.wind_speed_10m * 3.6); // Converter m/s para km/h

            widget.innerHTML = `
                <div class="space-y-3">
                    <div class="flex items-center justify-center gap-2">
                        <div class="text-5xl">${weatherInfo.icon}</div>
                        <div>
                            <div class="text-3xl font-bold text-gray-900 dark:text-white">${temp}°C</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">${weatherInfo.desc}</div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3 pt-2 border-t border-blue-200 dark:border-blue-800">
                        <div class="text-center">
                            <div class="text-xs text-gray-500 dark:text-gray-400">Umidade</div>
                            <div class="text-sm font-semibold text-gray-900 dark:text-white">${umidade}%</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xs text-gray-500 dark:text-gray-400">Vento</div>
                            <div class="text-sm font-semibold text-gray-900 dark:text-white">${vento} km/h</div>
                        </div>
                    </div>
                    <div class="text-xs text-center text-gray-500 dark:text-gray-500 pt-1">
                        Coração de Maria - BA
                    </div>
                </div>
            `;
        } catch (error) {
            console.error('Erro ao carregar clima no dashboard:', error);
            widget.innerHTML = `
                <div class="space-y-2">
                    <div class="text-4xl">🌤️</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">--°C</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Erro ao carregar</div>
                </div>
            `;
        }
    }

    // Função para carregar clima no sidebar (reutilizável)
    async function carregarClimaSidebar() {
        const widget = document.getElementById('widget-clima');
        if (!widget) return;

        // Bloquear se offline
        if (!navigator.onLine) {
            widget.innerHTML = `
                <div class="space-y-2">
                    <div class="text-3xl">🌤️</div>
                    <div class="text-xl font-bold text-gray-900 dark:text-white">--°C</div>
                    <div class="text-xs text-gray-600 dark:text-gray-400">Offline</div>
                </div>
            `;
            return;
        }

        try {
            // Coordenadas padrão (Coração de Maria - BA)
            const lat = -12.2333;
            const lon = -38.7500;

            // Open-Meteo API - Pública e gratuita, sem necessidade de chave
            const response = await fetch(`https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current=temperature_2m,relative_humidity_2m,weather_code&timezone=America/Bahia&forecast_days=1`);

            if (!response.ok) {
                throw new Error('Erro ao buscar clima');
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
                    </div>
                </div>
            `;
        } catch (error) {
            console.error('Erro ao carregar clima no sidebar:', error);
            widget.innerHTML = `
                <div class="space-y-2">
                    <div class="text-3xl">🌤️</div>
                    <div class="text-xl font-bold text-gray-900 dark:text-white">--°C</div>
                    <div class="text-xs text-gray-600 dark:text-gray-400">Erro ao carregar</div>
                </div>
            `;
        }
    }

    // ============================================
    // WIDGET DE CHAT
    // ============================================
    let chatWidgetAberto = false;
    let chatSessoes = [];

    function toggleChatWidget() {
        const container = document.getElementById('chat-widget-container');
        const text = document.getElementById('chat-toggle-text');
        chatWidgetAberto = !chatWidgetAberto;
        container.classList.toggle('hidden', !chatWidgetAberto);
        text.textContent = chatWidgetAberto ? 'Fechar' : 'Abrir';

        if (chatWidgetAberto) {
            carregarConversas();
        }
    }

    async function carregarConversas() {
        try {
            const response = await fetch('{{ route("campo.chat.index") }}', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                const text = await response.text();
                console.error('Resposta não é JSON. Status:', response.status);
                console.error('Conteúdo recebido:', text.substring(0, 500));
                throw new Error('Resposta não é JSON. Status: ' + response.status);
            }

            const data = await response.json();

            if (data.success) {
                chatSessoes = data.sessoes.data || [];
                atualizarListaConversas();
            } else {
                console.warn('Resposta sem success:', data);
            }
        } catch (error) {
            console.error('Erro ao carregar conversas:', error);
            const container = document.getElementById('chat-conversas');
            if (container) {
                container.innerHTML = '<div class="text-center text-sm text-red-500 dark:text-red-400 py-8">Erro ao carregar conversas. Verifique o console.</div>';
            }
        }
    }

    function atualizarListaConversas() {
        const container = document.getElementById('chat-conversas');
        if (chatSessoes.length === 0) {
            container.innerHTML = '<div class="text-center text-sm text-gray-500 dark:text-gray-400 py-8">Nenhuma conversa</div>';
            return;
        }

        container.innerHTML = chatSessoes.map(sessao => `
            <div onclick="abrirConversa('${sessao.session_id}')" class="p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer transition-colors">
                <div class="flex items-center justify-between">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">
                            ${sessao.assigned_to ? sessao.assigned_to.name : 'Sistema'}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                            ${sessao.last_message ? sessao.last_message.message : 'Sem mensagens'}
                        </p>
                    </div>
                    ${sessao.unread_count_user > 0 ? `<span class="ml-2 px-2 py-0.5 text-xs font-bold text-white bg-red-500 rounded-full">${sessao.unread_count_user}</span>` : ''}
                </div>
            </div>
        `).join('');
    }

    function abrirConversa(sessionId) {
        // Redirecionar para página de chat com a sessão selecionada
        window.location.href = '{{ route("campo.chat.page") }}?session=' + sessionId;
    }

    // ============================================
    // INICIALIZAÇÃO
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        carregarLocalidades();
        carregarClima(); // Carrega clima no dashboard e sidebar

        // Atualizar clima a cada 10 minutos
        setInterval(carregarClima, 600000);

        // Atualizar chat a cada 30 segundos se widget estiver aberto
        setInterval(() => {
            if (chatWidgetAberto) {
                carregarConversas();
            }
        }, 30000);
    });
</script>
@endpush
@endsection
