@props(['defaultTab' => 0])

<div x-data="{ activeTab: {{ $defaultTab }} }" class="space-y-10">
    <!-- Navegação de Abas Premium -->
    <div class="flex items-center gap-2 p-1.5 bg-gray-100/50 dark:bg-slate-900/50 rounded-[1.5rem] border border-gray-100 dark:border-slate-800 w-fit">
        {{ $tabs }}
    </div>

    <!-- Conteúdo das Abas -->
    <div class="animate-fade-in">
        {{ $content }}
    </div>
</div>

{{--
Exemplo de uso:
<x-tabs>
    <x-slot name="tabs">
        <button @click="activeTab = 0" :class="activeTab === 0 ? 'bg-white dark:bg-slate-800 text-emerald-600 shadow-lg' : 'text-slate-400 hover:text-slate-600'" class="px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all">Perfil</button>
        <button @click="activeTab = 1" :class="activeTab === 1 ? 'bg-white dark:bg-slate-800 text-emerald-600 shadow-lg' : 'text-slate-400 hover:text-slate-600'" class="px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all">Segurança</button>
    </x-slot>
    <x-slot name="content">
        <div x-show="activeTab === 0">...</div>
        <div x-show="activeTab === 1">...</div>
    </x-slot>
</x-tabs>
--}}
