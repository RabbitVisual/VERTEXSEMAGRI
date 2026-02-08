@props(['headers', 'exportRoute' => null, 'showActions' => true, 'data' => null])

<div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl border-2 border-gray-200 dark:border-gray-700 overflow-hidden">
    <div class="px-6 py-5 border-b-2 border-gray-200 dark:border-gray-700 bg-gradient-to-r from-indigo-50 via-gray-50 to-indigo-50 dark:from-gray-900/50 dark:via-gray-800/50 dark:to-gray-900/50 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-gradient-to-br from-indigo-100 to-indigo-200 dark:from-indigo-900/40 dark:to-indigo-800/40 rounded-xl shadow-sm">
                <x-materiais::icon name="cube" class="w-6 h-6 text-indigo-600 dark:text-indigo-400" />
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Listagem de Materiais</h3>
                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1 font-medium">Gerencie seu estoque de forma eficiente e profissional</p>
            </div>
        </div>
        @if($exportRoute)
            <div class="relative inline-block" id="export-dropdown-{{ uniqid() }}">
                <button type="button" onclick="toggleDropdown(this)" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-indigo-700 border-0 rounded-xl hover:from-indigo-700 hover:to-indigo-800 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:from-indigo-500 dark:to-indigo-600 dark:hover:from-indigo-600 dark:hover:to-indigo-700 shadow-lg hover:shadow-xl transition-all">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    Exportar
                </button>
                <div id="dropdown-menu-{{ uniqid() }}" class="hidden absolute right-0 z-20 mt-2 w-56 origin-top-right rounded-xl bg-white dark:bg-gray-800 shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="py-2">
                        <a href="{{ $exportRoute }}?format=csv{{ request()->getQueryString() ? '&' . request()->getQueryString() : '' }}" class="flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-indigo-50 dark:text-gray-300 dark:hover:bg-indigo-900/30 transition-colors">
                            <x-materiais::icon name="document-text" class="w-4 h-4" />
                            Exportar CSV
                        </a>
                        <a href="{{ $exportRoute }}?format=excel{{ request()->getQueryString() ? '&' . request()->getQueryString() : '' }}" class="flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-indigo-50 dark:text-gray-300 dark:hover:bg-indigo-900/30 transition-colors">
                            <x-materiais::icon name="document-text" class="w-4 h-4" />
                            Exportar Excel
                        </a>
                        <a href="{{ $exportRoute }}?format=pdf{{ request()->getQueryString() ? '&' . request()->getQueryString() : '' }}" class="flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-indigo-50 dark:text-gray-300 dark:hover:bg-indigo-900/30 transition-colors">
                            <x-materiais::icon name="document-text" class="w-4 h-4" />
                            Exportar PDF
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gradient-to-r from-gray-100 to-gray-50 dark:from-gray-900 dark:to-gray-800">
                <tr>
                    @foreach($headers as $header)
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider border-b-2 border-gray-200 dark:border-gray-700">
                            <div class="flex items-center gap-2">
                                <span>{{ $header }}</span>
                            </div>
                        </th>
                    @endforeach
                    @if($showActions)
                        <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider border-b-2 border-gray-200 dark:border-gray-700">
                            Ações
                        </th>
                    @endif
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                {{ $slot }}
            </tbody>
        </table>
    </div>
    @if($data && is_object($data) && method_exists($data, 'hasPages') && $data->hasPages())
        <div class="border-t-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
            <x-materiais::pagination :paginator="$data" />
        </div>
    @endif
</div>

<script>
function toggleDropdown(button) {
    const dropdown = button.closest('.relative');
    const menu = dropdown.querySelector('[id^="dropdown-menu-"]');
    if (menu) {
        menu.classList.toggle('hidden');
    }
}

document.addEventListener('click', function(event) {
    if (!event.target.closest('.relative[id^="export-dropdown-"]')) {
        document.querySelectorAll('[id^="dropdown-menu-"]').forEach(menu => {
            menu.classList.add('hidden');
        });
    }
});
</script>

