@extends('admin.layouts.admin')

@section('title', 'Gerenciar Roles')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-gray-900 dark:text-white flex items-center gap-3 mb-2 tracking-tight">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 via-indigo-600 to-violet-700 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/20 ring-1 ring-white/20">
                    <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                </div>
                <span>Gerenciar Níveis de Acesso</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors font-medium">Admin</a>
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <span class="text-gray-900 dark:text-white font-black uppercase tracking-wider text-xs">Roles & Roles</span>
            </nav>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.permissions.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-black text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:text-gray-300 dark:bg-slate-700 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-all shadow-sm transform hover:scale-[1.03] active:scale-95 uppercase tracking-wide">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                </svg>
                Permissões
            </a>
            <a href="{{ route('admin.roles.create') }}" class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-black text-white bg-gradient-to-r from-indigo-600 to-violet-700 rounded-xl hover:from-indigo-700 hover:to-violet-800 focus:ring-4 focus:ring-indigo-300 dark:focus:ring-indigo-900 transition-all shadow-md shadow-indigo-200 dark:shadow-none transform hover:scale-[1.03] active:scale-95 uppercase tracking-wide">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Nova Role
            </a>
        </div>
    </div>

    <!-- Estatísticas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-200 dark:border-slate-700 p-6 shadow-sm hover:shadow-md transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">Total de Roles</p>
                    <p class="text-3xl font-black text-gray-900 dark:text-white mt-1 tracking-tight">{{ $roles->count() }}</p>
                </div>
                <div class="p-3 bg-indigo-100 rounded-xl dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 group-hover:scale-110 transition-transform duration-300 shadow-sm shadow-indigo-100 dark:shadow-none">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-200 dark:border-slate-700 p-6 shadow-sm hover:shadow-md transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">Permissões Ativas</p>
                    <p class="text-3xl font-black text-gray-900 dark:text-white mt-1 tracking-tight">{{ \Spatie\Permission\Models\Permission::count() }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-xl dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 group-hover:scale-110 transition-transform duration-300 shadow-sm shadow-blue-100 dark:shadow-none">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-200 dark:border-slate-700 p-6 shadow-sm hover:shadow-md transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">Usuários Ativos</p>
                    <p class="text-3xl font-black text-gray-900 dark:text-white mt-1 tracking-tight">{{ \App\Models\User::where('active', true)->count() }}</p>
                </div>
                <div class="p-3 bg-emerald-100 rounded-xl dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 group-hover:scale-110 transition-transform duration-300 shadow-sm shadow-emerald-100 dark:shadow-none">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-2xl border border-gray-200 dark:border-slate-700 p-6 shadow-sm hover:shadow-md transition-all duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">Nível de Acesso</p>
                    <p class="text-3xl font-black text-gray-900 dark:text-white mt-1 tracking-tight">{{ $roles->count() > 0 ? round($roles->sum(fn($r) => $r->permissions->count()) / $roles->count()) : 0 }}%</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-xl dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 group-hover:scale-110 transition-transform duration-300 shadow-sm shadow-purple-100 dark:shadow-none">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Roles -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($roles as $role)
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden hover:shadow-xl hover:shadow-indigo-500/10 transition-all duration-300 group ring-1 ring-black/5">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gradient-to-r from-gray-50 to-white dark:from-slate-900/50 dark:to-slate-800">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-black text-gray-900 dark:text-white flex items-center gap-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors tracking-tight">
                        <div class="p-1.5 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-lg">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
                        </div>
                        {{ ucfirst(str_replace(['-', '_'], ' ', $role->name)) }}
                    </h3>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-black uppercase tracking-wider bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300 ring-1 ring-indigo-200 dark:ring-indigo-800/50">
                        {{ $role->permissions->count() }} {{ $role->permissions->count() === 1 ? 'perm' : 'perms' }}
                    </span>
                </div>
            </div>
            <div class="p-6">
                <div class="mb-5">
                    <h6 class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3 flex items-center gap-2">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                        </svg>
                        Capability Snippet
                    </h6>
                    <div class="flex flex-wrap gap-1.5 max-h-32 overflow-y-auto custom-scrollbar pr-1">
                        @forelse($role->permissions->take(6) as $permission)
                            <span class="inline-flex items-center px-2 py-1 rounded-lg text-[10px] font-bold bg-gray-50 text-gray-600 dark:bg-slate-700/50 dark:text-gray-400 border border-gray-100 dark:border-slate-700 shadow-sm">{{ Str::limit($permission->name, 25) }}</span>
                        @empty
                            <span class="text-xs text-gray-500 dark:text-gray-400 font-medium italic">Sem privilégios específicos</span>
                        @endforelse
                        @if($role->permissions->count() > 6)
                            <span class="inline-flex items-center px-2 py-1 rounded-lg text-[10px] font-black bg-indigo-50 text-indigo-600 dark:bg-indigo-900/40 dark:text-indigo-400 ring-1 ring-indigo-100 dark:ring-indigo-800/50">
                                +{{ $role->permissions->count() - 6 }} plus
                            </span>
                        @endif
                    </div>
                </div>
                <div class="pt-4 border-t border-gray-100 dark:border-slate-700/50 flex items-center justify-between">
                    <div class="flex items-center gap-1.5">
                        <div class="flex -space-x-2">
                            @foreach($role->users->take(3) as $rUser)
                                <div class="w-6 h-6 rounded-full border-2 border-white dark:border-slate-800 bg-indigo-500 flex items-center justify-center text-[8px] text-white font-black uppercase" title="{{ $rUser->name }}">
                                    {{ substr($rUser->name, 0, 1) }}
                                </div>
                            @endforeach
                            @if($role->users->count() > 3)
                                <div class="w-6 h-6 rounded-full border-2 border-white dark:border-slate-800 bg-gray-200 dark:bg-slate-700 flex items-center justify-center text-[8px] text-gray-600 dark:text-gray-400 font-black">
                                    +{{ $role->users->count() - 3 }}
                                </div>
                            @endif
                        </div>
                        <p class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-wider">
                            {{ $role->users->count() === 1 ? 'Usuário Ativo' : 'Usuários Ativos' }}
                        </p>
                    </div>
                    <div class="text-[10px] font-black {{ $role->users->count() > 0 ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-400' }} uppercase">
                        {{ $role->users->count() }} Total
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/30 flex items-center justify-between gap-2">
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.roles.show', $role) }}" class="p-2 text-indigo-600 hover:text-white hover:bg-indigo-600 dark:text-indigo-400 dark:hover:text-white dark:hover:bg-indigo-600 rounded-xl transition-all duration-300 ring-1 ring-indigo-50 dark:ring-indigo-900/30" title="Visualizar Detalhes">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </a>
                    <a href="{{ route('admin.roles.edit', $role) }}" class="p-2 text-amber-600 hover:text-white hover:bg-amber-600 dark:text-amber-400 dark:hover:text-white dark:hover:bg-amber-600 rounded-xl transition-all duration-300 ring-1 ring-amber-50 dark:ring-amber-900/30" title="Editar Role">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                    </a>
                </div>
                @if(!in_array($role->name, ['admin']))
                <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja deletar esta role? Esta ação não pode ser desfeita.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="p-2 text-red-600 hover:text-white hover:bg-red-600 dark:text-red-400 dark:hover:text-white dark:hover:bg-red-600 rounded-xl transition-all duration-300 ring-1 ring-red-50 dark:ring-red-900/30" title="Excluir Role">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                    </button>
                </form>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    @if($roles->isEmpty())
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 p-12">
        <div class="text-center">
            <svg class="w-16 h-16 text-gray-400 dark:text-gray-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
            </svg>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Nenhuma role encontrada</p>
            <a href="{{ route('admin.roles.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Criar Primeira Role
            </a>
        </div>
    </div>
    @endif
</div>

@push('styles')
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    .dark .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #475569;
    }
    .dark .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #64748b;
    }
</style>
@endpush
@endsection
