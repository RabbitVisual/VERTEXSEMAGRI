<div id="global-loading-overlay"
    x-data="{ show: false, message: 'Processando...' }"
    x-show="show"
    x-on:vertex-loading-show.window="show = true; if($event.detail.message) message = $event.detail.message"
    x-on:vertex-loading-hide.window="show = false"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-[9999] flex items-center justify-center bg-slate-900/60 backdrop-blur-md"
    style="display: none;">

    <div class="relative flex flex-col items-center justify-center p-10 bg-white/10 dark:bg-slate-800/20 border border-white/20 rounded-[2.5rem] shadow-2xl backdrop-blur-xl transform transition-all">
        <!-- Decoration Glow -->
        <div class="absolute -top-10 -left-10 w-32 h-32 bg-emerald-500/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-lime-500/20 rounded-full blur-3xl animate-pulse"></div>

        <!-- Agriculture Themed Icon Container -->
        <div class="relative mb-8">
            <div class="absolute inset-0 bg-gradient-to-tr from-emerald-500/30 to-lime-500/30 blur-2xl rounded-full scale-150 animate-pulse"></div>
            <div class="relative w-24 h-24 bg-white/10 rounded-3xl flex items-center justify-center border border-white/30 shadow-inner group">
                <x-icon name="tractor" style="duotone" class="w-12 h-12 text-emerald-400 group-hover:scale-110 transition-transform duration-500" />

                <!-- Orbiting Seeds -->
                <div class="absolute inset-0 animate-[spin_4s_linear_infinite]">
                    <x-icon name="seedling" style="duotone" class="absolute -top-2 left-1/2 -translate-x-1/2 w-5 h-5 text-lime-400" />
                </div>
            </div>
        </div>

        <!-- Loading Text -->
        <div class="space-y-3 text-center">
            <h3 class="text-2xl font-extrabold text-white tracking-tight font-poppins" x-text="message"></h3>
            <div class="flex items-center justify-center gap-2">
                <span class="flex h-2 w-2 rounded-full bg-emerald-500 animate-bounce"></span>
                <span class="flex h-2 w-2 rounded-full bg-emerald-400 animate-bounce [animation-delay:0.2s]"></span>
                <span class="flex h-2 w-2 rounded-full bg-emerald-300 animate-bounce [animation-delay:0.4s]"></span>
            </div>
        </div>

        <!-- Progress Bar Decoration -->
        <div class="w-56 h-1.5 bg-white/10 rounded-full mt-8 overflow-hidden border border-white/5">
            <div class="h-full bg-gradient-to-r from-emerald-400 via-lime-400 to-emerald-600 animate-[loading_2s_ease-in-out_infinite] w-1/3 rounded-full"></div>
        </div>

        <p class="mt-4 text-[10px] font-bold text-emerald-200/40 uppercase tracking-[0.2em]">Sistemas Semagri Vertex</p>
    </div>
</div>

<style>
    @keyframes loading {
        0% { transform: translateX(-150%) scaleX(0.5); }
        50% { transform: translateX(100%) scaleX(1.2); }
        100% { transform: translateX(350%) scaleX(0.5); }
    }
</style>

<script>
    (function() {
        const showOverlay = (msg = 'Processando...') => {
            window.dispatchEvent(new CustomEvent('vertex-loading-show', { detail: { message: msg } }));
        };

        const hideOverlay = () => {
            window.dispatchEvent(new CustomEvent('vertex-loading-hide'));
        };

        // Livewire Integration
        document.addEventListener('livewire:init', () => {
            Livewire.hook('commit', ({ succeed, fail, respond }) => {
                showOverlay();
                succeed(() => hideOverlay());
                fail(() => hideOverlay());
                respond(() => hideOverlay());
            });

            document.addEventListener('livewire:navigate', () => showOverlay('Navegando...'));
            document.addEventListener('livewire:navigated', hideOverlay);
        });

        // Form Submissions
        document.addEventListener('submit', (e) => {
            const form = e.target;
            // Ignore search forms or forms with data-no-loading
            if (form.method.toLowerCase() === 'get' || form.hasAttribute('data-no-loading')) return;

            showOverlay('Salvando informações...');
        });

        // Global Link Clicks (Safe only)
        document.addEventListener('click', (e) => {
            const link = e.target.closest('a');
            if (!link) return;

            // Only show for standard module navigation links
            const isInternal = link.href && link.href.startsWith(window.location.origin);
            const isNoLoad = link.hasAttribute('data-no-loading') || link.getAttribute('target') === '_blank';
            const isSpecial = e.ctrlKey || e.shiftKey || e.metaKey || link.href.includes('#') || link.href.startsWith('javascript:');

            if (isInternal && !isNoLoad && !isSpecial) {
                // Avoid showing for simple pagination or tabs
                if (!link.classList.contains('page-link') && !link.hasAttribute('role')) {
                    showOverlay('Carregando página...');
                }
            }
        });

        // Handle page history/back button
        window.addEventListener('pageshow', (event) => {
            if (event.persisted) hideOverlay();
            else hideOverlay(); // Always ensure it's hidden on fresh load
        });

        window.addEventListener('load', hideOverlay);

        // Expose globally
        window.VertexLoading = { show: showOverlay, hide: hideOverlay };
    })();
</script>
