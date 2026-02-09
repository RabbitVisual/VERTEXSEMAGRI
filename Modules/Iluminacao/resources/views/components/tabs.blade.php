@props(['defaultTab' => 0, 'tabs' => []])

<div x-data="{ activeTab: {{ $defaultTab }} }" class="space-y-6">
    <!-- Tabs Navigation -->
    <div class="border-b border-slate-200 dark:border-slate-700/50">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            @foreach($tabs as $index => $tab)
                <button
                    type="button"
                    @click="activeTab = {{ $index }}"
                    :class="{
                        'border-indigo-500 text-indigo-600 dark:text-indigo-400': activeTab === {{ $index }},
                        'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300 dark:text-slate-400 dark:hover:text-slate-300': activeTab !== {{ $index }}
                    }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-all duration-200"
                >
                    <div class="flex items-center gap-2">
                        @if(isset($tab['icon']))
                            <x-icon :name="$tab['icon']" class="w-4 h-4" />
                        @endif
                        <span>{{ $tab['label'] }}</span>
                    </div>
                </button>
            @endforeach
        </nav>
    </div>

    <!-- Tabs Content -->
    <div class="relative min-h-[200px]">
        {{ $slot }}
    </div>
</div>
