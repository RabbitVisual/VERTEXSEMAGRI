<div x-data="{
    loading: false,
    timeout: null,
    message: 'Acessando o sistema...',
    icon: 'wheat',
    icons: ['wheat', 'seedling', 'leaf', 'tree', 'tractor', 'cloud-sun'],
    init() {
        const stop = () => { if (this.timeout) clearTimeout(this.timeout); this.timeout = null; this.loading = false; };
        const start = (msg = null, iconName = null) => {
            stop();
            this.message = msg || 'Processando dados...';
            this.icon = iconName || this.icons[Math.floor(Math.random() * this.icons.length)];
            this.timeout = setTimeout(() => this.loading = true, 50);
        };

        // Browser Events
        window.addEventListener('beforeunload', () => start('Preparando navegação...'));
        window.addEventListener('submit', (e) => {
            if (e.target.hasAttribute('data-no-loading')) return;
            start('Salvando informações...');
        });
        window.addEventListener('pageshow', stop);
        window.addEventListener('load', stop);
        window.addEventListener('DOMContentLoaded', stop);

        // Custom & Livewire Events
        window.addEventListener('stop-loading', stop);
        window.addEventListener('start-loading', (e) => start(e.detail?.message, e.detail?.icon));
        document.addEventListener('livewire:navigating', () => start('Carregando...'));
        document.addEventListener('livewire:navigated', stop);

        // Safety Timeout
        $watch('loading', v => { if (v) setTimeout(() => { if (this.loading) stop(); }, 15000); });
        stop();
    }
}"
    x-show="loading"
    x-cloak
    class="fixed inset-0 z-[9999] flex items-center justify-center bg-white/60 dark:bg-slate-900/80 backdrop-blur-md transition-opacity duration-300"
    x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0">

    <div class="relative flex flex-col items-center p-8 rounded-2xl bg-white/40 dark:bg-slate-800/40 border border-white/50 dark:border-slate-700/50 shadow-2xl backdrop-blur-xl">
        <!-- Icon Container -->
        <div class="relative w-24 h-24 mb-6 flex items-center justify-center">
            <!-- Pulsing Rings (Agri Green) -->
            <div class="absolute inset-0 bg-emerald-500/20 rounded-full animate-ping"></div>
            <div class="absolute inset-2 bg-emerald-500/10 rounded-full animate-pulse"></div>

            <!-- Icon -->
            <div class="relative z-10 text-emerald-600 dark:text-emerald-400 text-5xl drop-shadow-lg transform transition-all duration-500">
                <template x-if="icon === 'wheat'"><x-icon name="wheat" style="duotone" class="fa-bounce" /></template>
                <template x-if="icon === 'seedling'"><x-icon name="seedling" style="duotone" class="fa-beat-fade" /></template>
                <template x-if="icon === 'leaf'"><x-icon name="leaf" style="duotone" class="fa-shake" /></template>
                <template x-if="icon === 'tree'"><x-icon name="tree" style="duotone" class="fa-fade" /></template>
                <template x-if="icon === 'tractor'"><x-icon name="tractor" style="duotone" class="fa-beat" /></template>
                <template x-if="icon === 'cloud-sun'"><x-icon name="cloud-sun" style="duotone" class="fa-beat" /></template>
            </div>
        </div>

        <!-- Message -->
        <h3 x-text="message" class="text-lg font-semibold text-emerald-900 dark:text-emerald-100 tracking-wide text-center font-['Poppins']"></h3>

        <!-- Loading Dots -->
        <div class="flex gap-1.5 mt-3">
            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-bounce [animation-delay:-0.3s]"></div>
            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-bounce [animation-delay:-0.15s]"></div>
            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-bounce"></div>
        </div>
    </div>
</div>
