@extends('pocos::lider-comunidade.layouts.app')

@section('title', 'Usuários do Poço')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-6 md:pb-8 border-b border-gray-200 dark:border-slate-700">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800 flex items-center justify-center text-blue-600 shadow-sm">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Moradores do Poço</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">Gerencie todos os residentes e seus respectivos acessos</p>
            </div>
        </div>
        <a href="{{ route('lider-comunidade.usuarios.create') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 text-xs font-black text-white bg-blue-600 rounded-2xl hover:bg-blue-700 shadow-xl shadow-blue-500/20 active:scale-95 transition-all uppercase tracking-widest">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Novo Morador
        </a>
    </div>

    <!-- Filtros -->
    <form method="GET" action="{{ route('lider-comunidade.usuarios.index') }}" class="premium-card p-5">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-xs font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Buscar</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nome, CPF ou código..." class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:bg-white dark:focus:bg-slate-900 transition-all">
            </div>
            <div>
                <label class="block text-xs font-black text-gray-400 dark:text-slate-500 uppercase tracking-widest mb-2 px-1">Status</label>
                <select name="status" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:bg-white dark:focus:bg-slate-900 transition-all">
                    <option value="">Todos os Status</option>
                    <option value="ativo" {{ request('status') === 'ativo' ? 'selected' : '' }}>Ativo</option>
                    <option value="inativo" {{ request('status') === 'inativo' ? 'selected' : '' }}>Inativo</option>
                    <option value="suspenso" {{ request('status') === 'suspenso' ? 'selected' : '' }}>Suspenso</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full px-5 py-2.5 text-sm font-bold text-white bg-slate-900 dark:bg-blue-600 rounded-xl hover:bg-slate-800 dark:hover:bg-blue-700 transition-all shadow-lg active:scale-[0.98]">
                    Aplicar Filtros
                </button>
            </div>
        </div>
    </form>

    <!-- Tabela -->
    <div class="premium-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-[10px] text-gray-400 uppercase tracking-widest bg-gray-50/50 dark:bg-slate-800/50 border-b border-gray-100 dark:border-slate-800">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-bold">Usuário</th>
                        <th scope="col" class="px-6 py-4 font-bold">Documentos</th>
                        <th scope="col" class="px-6 py-4 font-bold">Contato</th>
                        <th scope="col" class="px-6 py-4 font-bold">Acesso</th>
                        <th scope="col" class="px-6 py-4 font-bold text-center">Status</th>
                        <th scope="col" class="px-6 py-4 font-bold text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-800">
                    @forelse($usuarios as $usuario)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900 dark:text-white">{{ $usuario->nome }}</div>
                            <div class="text-[10px] text-gray-400 uppercase font-black italic">Morador</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-gray-600 dark:text-slate-400 font-medium">{{ $usuario->cpf_formatado }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-gray-600 dark:text-slate-500 font-medium">{{ $usuario->telefone ?? 'N/T' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <code class="px-2 py-1 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-lg text-xs font-black font-mono tracking-tighter border border-blue-100 dark:border-blue-900/30">
                                {{ $usuario->codigo_acesso }}
                            </code>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider {{ $usuario->status === 'ativo' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/20 dark:text-emerald-400' : ($usuario->status === 'suspenso' ? 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400' : 'bg-gray-100 text-gray-800 dark:bg-slate-700 dark:text-slate-400') }}">
                                {{ $usuario->status_texto }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('lider-comunidade.usuarios.show', $usuario->id) }}" class="inline-flex items-center gap-1 text-xs font-black text-blue-600 hover:text-blue-700 dark:text-blue-400 uppercase tracking-tighter hover:underline">
                                Detalhes
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <svg class="w-12 h-12 text-gray-300 dark:text-slate-700" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>
                                </svg>
                                <p class="text-sm font-bold text-gray-500 dark:text-slate-400">Nenhum usuário encontrado</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($usuarios->hasPages())
        <div class="p-6 border-t border-gray-100 dark:border-slate-800">
            {{ $usuarios->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
