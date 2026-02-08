<div x-data="{ open: false }" 
     @keydown.window.cmd.k.prevent="open = !open" 
     @keydown.window.ctrl.k.prevent="open = !open" 
     x-show="open" 
     class="fixed inset-0 z-50 overflow-y-auto" 
     style="display: none;"
     x-transition:enter="ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    
    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="open = false">
            <div class="absolute inset-0 bg-gray-500/75 backdrop-blur-sm"></div>
        </div>

        <div class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white/90 border border-white/20 rounded-xl shadow-2xl backdrop-blur-md sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6 dark:bg-gray-800/90 dark:border-gray-700/50">
            <div>
                <div class="mt-3 text-center sm:mt-5">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white font-poppins flex items-center justify-center gap-2">
                        <x-icon name="duotone-magnifying-glass" class="w-5 h-5 text-gray-500" />
                        Command Palette
                    </h3>
                    <div class="mt-4 relative">
                        <input type="text" 
                               class="w-full p-3 border border-gray-200 rounded-lg dark:bg-gray-700/50 dark:border-gray-600 dark:text-white focus:ring-2 focus:ring-green-500/50 focus:border-green-500 font-sans" 
                               placeholder="Search commands..."
                               autofocus>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
