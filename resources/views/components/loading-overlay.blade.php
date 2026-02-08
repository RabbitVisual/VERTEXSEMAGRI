<div
    x-data="{ loading: false }"
    x-show="loading"
    @loading.window="loading = $event.detail"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center bg-white/30 dark:bg-slate-900/30 backdrop-blur-md"
    style="display: none;"
>
    <div class="flex flex-col items-center justify-center p-6 rounded-2xl bg-white/80 dark:bg-slate-800/80 shadow-2xl border border-white/20 dark:border-slate-700/50">
        <div class="relative mb-4">
            <div class="absolute inset-0 rounded-full bg-emerald-500/20 animate-ping"></div>
            <div class="relative flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 shadow-lg">
                <i class="fa-duotone fa-wheat-awn fa-2x text-white fa-bounce" style="--fa-animation-duration: 2s;"></i>
            </div>
        </div>
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 font-['Poppins']">Processando...</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 font-['Inter']">Por favor, aguarde.</p>
    </div>
</div>
