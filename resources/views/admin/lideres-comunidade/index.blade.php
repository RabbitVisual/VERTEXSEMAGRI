@extends('admin.layouts.admin')

@section('title', 'Gestão de Líderes Comunitários')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-800">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-gray-900 dark:text-white flex items-center gap-3 mb-2 uppercase tracking-tight">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center shadow-lg text-white">
                    <x-icon name="users-gear" style="duotone" class="w-6 h-6 md:w-7 md:h-7" />
                </div>
                <span>Líderes de Comunidade</span>
            </h1>
            <nav class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-2.5 h-2.5" />
                <span class="text-blue-600">Corpo de Agentes</span>
            </nav>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.lideres-comunidade.create') }}" class="group inline-flex items-center justify-center gap-2 px-8 py-3.5 text-xs font-black text-white bg-blue-600 rounded-2xl hover:bg-blue-700 shadow-xl shadow-blue-500/20 active:scale-95 transition-all uppercase tracking-widest">
                <x-icon name="user-plus" class="w-4 h-4 group-hover:scale-110 transition-transform" />
                Novo Agente Líder
            </a>
        </div>
    </div>

    <!-- Central de Inteligência e Filtros -->
    <div class="premium-card p-6 md:p-8">
        <form action="{{ route('admin.lideres-comunidade.index') }}" method="GET" class="flex flex-col md:flex-row gap-6 items-end">
            <div class="relative flex-1 group">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Busca Avançada</label>
                <div class="absolute inset-y-0 left-5 top-8 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-500 transition-colors">
                    <x-icon name="magnifying-glass" class="w-5 h-5" />
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="w-full pl-12 pr-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white"
                    placeholder="Nome, CPF, Código ou Localidade...">
            </div>
            <button type="submit" class="w-full md:w-auto px-10 py-3.5 text-xs font-black text-white bg-slate-900 dark:bg-blue-600 rounded-2xl hover:bg-slate-800 dark:hover:bg-blue-700 transition-all shadow-xl active:scale-95 uppercase tracking-widest flex items-center justify-center gap-2">
                <x-icon name="sliders" style="duotone" class="w-4 h-4" />
                Filtrar Bases
            </button>
        </form>
    </div>

    <!-- Grade de Resultados -->
    <div class="premium-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-[9px] text-slate-400 uppercase tracking-[0.2em] bg-gray-50/50 dark:bg-slate-800/50 border-b border-gray-100 dark:border-slate-800">
                    <tr>
                        <th scope="col" class="px-8 py-5 font-black">Identidade & Código</th>
                        <th scope="col" class="px-8 py-5 font-black">Jurisdição / Ativo</th>
                        <th scope="col" class="px-8 py-5 font-black text-center">Contatos Oficiais</th>
                        <th scope="col" class="px-8 py-5 font-black text-center">Status</th>
                        <th scope="col" class="px-8 py-5 font-black text-right">Controles</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-800 font-bold">
                    @forelse($lideres as $lider)
                    <tr class="hover:bg-gray-50/30 dark:hover:bg-slate-800/30 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-base shadow-lg group-hover:scale-110 transition-transform">
                                    {{ strtoupper(substr($lider->nome, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="text-gray-900 dark:text-white font-black uppercase tracking-tight text-base mb-0.5">{{ $lider->nome }}</div>
                                    <div class="text-[10px] text-slate-400 uppercase tracking-widest flex items-center gap-1.5 font-black italic">
                                        <x-icon name="id-card" class="w-3 h-3 text-blue-500" />
                                        REF: {{ $lider->codigo }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col gap-1">
                                <span class="text-[11px] font-black text-gray-900 dark:text-white uppercase tracking-tighter">{{ $lider->localidade->nome ?? 'S/L' }}</span>
                                <span class="text-[10px] text-slate-400 flex items-center gap-1.5 font-bold uppercase italic tracking-widest">
                                    <x-icon name="faucet-drip" style="duotone" class="w-3.5 h-3.5 text-blue-400" />
                                    {{ $lider->poco->nome_mapa ?? $lider->poco->codigo ?? 'N/D' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <div class="flex flex-col items-center gap-1">
                                <div class="flex items-center gap-2 text-[10px] text-slate-500 dark:text-slate-400 font-bold tracking-tight">
                                    <x-icon name="envelope" class="w-3.5 h-3.5 text-blue-500" />
                                    {{ $lider->email ?? $lider->user->email ?? 'N/A' }}
                                </div>
                                @if($lider->telefone)
                                <div class="flex items-center gap-2 text-[10px] text-slate-500 dark:text-slate-400 font-black tracking-widest">
                                    <x-icon name="whatsapp" class="w-3.5 h-3.5 text-emerald-500" />
                                    {{ $lider->telefone }}
                                </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            @php
                                $statusStyle = $lider->status === 'ativo'
                                    ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400'
                                    : 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400 shadow-[0_0_15px_-5px_theme(colors.rose.500)]';
                            @endphp
                            <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-[0.15em] {{ $statusStyle }}">
                                <span class="w-1.5 h-1.5 rounded-full mr-2 {{ $lider->status === 'ativo' ? 'bg-emerald-500 shadow-[0_0_8px_theme(colors.emerald.500)]' : 'bg-rose-500 shadow-[0_0_8px_theme(colors.rose.500)]' }}"></span>
                                {{ $lider->status_texto }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end gap-2 shrink-0">
                                <a href="{{ route('admin.lideres-comunidade.show', $lider) }}" class="p-2.5 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-xl transition-all" title="Ver Prontuário">
                                    <x-icon name="id-badge" style="duotone" class="w-5 h-5" />
                                </a>
                                <a href="{{ route('admin.lideres-comunidade.edit', $lider) }}" class="p-2.5 text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 rounded-xl transition-all" title="Editar Credenciais">
                                    <x-icon name="user-pen" style="duotone" class="w-5 h-5" />
                                </a>
                                <form action="{{ route('admin.lideres-comunidade.destroy', $lider) }}" method="POST" class="inline-block" onsubmit="return confirm('ATENÇÃO: Desativar este líder pode interromper os ciclos de cobrança da localidade. Confirmar?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2.5 text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-xl transition-all" title="Remover Líder">
                                        <x-icon name="user-minus" style="duotone" class="w-5 h-5" />
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-24 text-center">
                            <div class="max-w-md mx-auto flex flex-col items-center gap-6">
                                <div class="w-24 h-24 bg-gray-50 dark:bg-slate-900 rounded-full flex items-center justify-center text-gray-200 dark:text-slate-800 scale-125">
                                    <x-icon name="users-slash" style="duotone" class="w-10 h-10" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tight">Base de Líderes Vazia</h3>
                                    <p class="text-[11px] text-slate-400 font-black uppercase tracking-widest mt-1 italic">Nenhum agente comunitário mapeado nos registros atuais.</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($lideres->hasPages())
        <div class="p-8 bg-gray-50/30 dark:bg-slate-900/50 border-t border-gray-100 dark:border-slate-800">
            {{ $lideres->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
