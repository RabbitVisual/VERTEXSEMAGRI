<div id="global-loading-overlay" class="fixed inset-0 z-[9999] flex items-center justify-center bg-gray-900/60 backdrop-blur-sm transition-opacity duration-300 opacity-0 pointer-events-none" style="display: none;">
    <div class="relative flex flex-col items-center justify-center p-8 bg-white/10 border border-white/20 rounded-2xl shadow-2xl backdrop-blur-md transform transition-all scale-95 duration-300">
        <!-- Agriculture Themed Icon -->
        <div class="relative mb-4">
            <div class="absolute inset-0 bg-green-500/20 blur-xl rounded-full animate-pulse"></div>
            <x-icon name="wheat" class="w-16 h-16 text-green-400 animate-[bounce_2s_infinite]" />
        </div>

        <!-- Loading Text -->
        <div class="space-y-2 text-center">
            <h3 class="text-xl font-bold text-white tracking-wide font-poppins">Processando...</h3>
            <p class="text-sm text-green-200/80 animate-pulse">Por favor, aguarde</p>
        </div>

        <!-- Progress Bar Decoration -->
        <div class="w-48 h-1 bg-white/10 rounded-full mt-6 overflow-hidden">
            <div class="h-full bg-gradient-to-r from-green-400 to-emerald-600 animate-[loading_1.5s_ease-in-out_infinite] w-1/3 rounded-full"></div>
        </div>
    </div>
</div>

<style>
    @keyframes loading {
        0% { transform: translateX(-150%); }
        100% { transform: translateX(350%); }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const overlay = document.getElementById('global-loading-overlay');
        let safetyTimeout;

        // Show overlay function
        const showOverlay = () => {
            if (!overlay) return;
            overlay.style.display = 'flex';
            // Force reflow
            overlay.offsetHeight;
            overlay.classList.remove('opacity-0', 'pointer-events-none');
            overlay.querySelector('div').classList.remove('scale-95');
            overlay.querySelector('div').classList.add('scale-100');

            // Safety timeout - hide after 8 seconds if stuck
            clearTimeout(safetyTimeout);
            safetyTimeout = setTimeout(hideOverlay, 8000);
        };

        // Hide overlay function
        const hideOverlay = () => {
            if (!overlay) return;
            overlay.classList.add('opacity-0', 'pointer-events-none');
            overlay.querySelector('div').classList.remove('scale-100');
            overlay.querySelector('div').classList.add('scale-95');

            setTimeout(() => {
                if (overlay.classList.contains('opacity-0')) {
                    overlay.style.display = 'none';
                }
            }, 300);

            clearTimeout(safetyTimeout);
        };

        // Listen for Livewire events
        if (typeof Livewire !== 'undefined') {
            Livewire.hook('commit', ({ succeed, fail, respond }) => {
                showOverlay();
                succeed(() => hideOverlay());
                fail(() => hideOverlay());
                respond(() => hideOverlay());
            });

            // Navigation events (Wire:navigate)
            document.addEventListener('livewire:navigate', showOverlay);
            document.addEventListener('livewire:navigated', hideOverlay);
        }

        // Standard link clicks (optional - can be aggressive)
        // document.querySelectorAll('a').forEach(link => {
        //     link.addEventListener('click', (e) => {
        //         if (!e.ctrlKey && !e.shiftKey && !e.metaKey && link.target !== '_blank' && link.href && !link.href.startsWith('#')) {
        //             showOverlay();
        //         }
        //     });
        // });

        // Form submissions
        document.addEventListener('submit', (e) => {
            if (!e.defaultPrevented) {
                showOverlay();
            }
        });

        // Browser Native Navigation (Before Unload)
        window.addEventListener('beforeunload', () => {
            // Only show if not a download link or similar (basic check)
            showOverlay();
        });

        // Hide on page load (in case it was stuck from previous navigation)
        hideOverlay();
        window.addEventListener('load', hideOverlay);

        // Expose globally
        window.VertexLoading = { show: showOverlay, hide: hideOverlay };
    });
</script>
