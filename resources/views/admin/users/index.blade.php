@extends('admin.layouts.admin')

@section('title', 'Gerenciar Usuários')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 001.904-3.7c0-1.11-.89-2.01-2.01-2.01a1.99 1.99 0 00-1.915 1.25 5.25 5.25 0 01-4.237 3.25 5.25 5.25 0 01-4.237-3.25 1.99 1.99 0 00-1.915-1.25c-1.12 0-2.01.9-2.01 2.01a4.125 4.125 0 001.904 3.7 9.337 9.337 0 004.121.952 9.38 9.38 0 002.625-.372m0 0a9.344 9.344 0 002.25-.568 9.344 9.344 0 002.25.568m-4.5 0v-.75a6 6 0 00-1.5-.131m4.5 0v.75a6 6 0 01-1.5.131m-4.5 0v-.75a6 6 0 011.5-.131m4.5 0v.75a6 6 0 001.5.131" />
                    </svg>
                </div>
                <span>Gerenciar Usuários</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors font-medium">Admin</a>
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <span class="text-gray-900 dark:text-white font-black uppercase tracking-wider text-xs">Usuários</span>
            </nav>
        </div>
        <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-black text-white bg-gradient-to-r from-indigo-600 to-violet-700 rounded-xl hover:from-indigo-700 hover:to-violet-800 focus:ring-4 focus:ring-indigo-300 dark:focus:ring-indigo-900 transition-all shadow-md shadow-indigo-200 dark:shadow-none transform hover:scale-[1.03] active:scale-95 uppercase tracking-wide">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Novo Usuário
        </a>
    </div>

    <!-- Filtros - Flowbite Card -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Filtros de Busca</h3>
        </div>
        <form method="GET" action="{{ route('admin.users.index') }}" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="md:col-span-2">
                    <label for="search" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Buscar</label>
                    <input type="text" name="search" id="search" value="{{ $filters['search'] ?? '' }}" placeholder="Buscar por nome ou email..." class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                </div>
                <div>
                    <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                    <select name="role" id="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                        <option value="">Todas as roles</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ ($filters['role'] ?? '') == $role->name ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="active" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                    <select name="active" id="active" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                        <option value="">Todos os status</option>
                        <option value="1" {{ ($filters['active'] ?? '') === '1' ? 'selected' : '' }}>Ativos</option>
                        <option value="0" {{ ($filters['active'] ?? '') === '0' ? 'selected' : '' }}>Inativos</option>
                    </select>
                </div>
            </div>
            <div class="mt-4 flex justify-end">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-black text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800 transition-all shadow-md shadow-indigo-200 dark:shadow-none transform hover:scale-[1.03] active:scale-95 uppercase tracking-wide">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    Filtrar Resultados
                </button>
            </div>
        </form>
    </div>

    <!-- Tabela de Usuários - Flowbite Card -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Usuários</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50/50 dark:bg-slate-900/50 border-b border-gray-200 dark:border-slate-700">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-black tracking-wider">Usuário</th>
                        <th scope="col" class="px-6 py-4 font-black tracking-wider">Contato</th>
                        <th scope="col" class="px-6 py-4 font-black tracking-wider text-center">Nível de Acesso</th>
                        <th scope="col" class="px-6 py-4 font-black tracking-wider text-center">Status</th>
                        <th scope="col" class="px-6 py-4 font-black tracking-wider">Cadastro</th>
                        <th scope="col" class="px-6 py-4 font-black tracking-wider text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="bg-white border-b dark:bg-slate-800 dark:border-slate-700/50 hover:bg-indigo-50/30 dark:hover:bg-indigo-900/10 transition-all duration-200 group">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="relative flex-shrink-0">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 dark:from-slate-700 dark:to-slate-600 flex items-center justify-center text-gray-700 dark:text-gray-300 font-black text-sm shadow-inner ring-1 ring-black/5 dark:ring-white/5 uppercase">
                                        {{ substr($user->name, 0, 2) }}
                                    </div>
                                    @if($user->active)
                                        <div class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-emerald-500 border-2 border-white dark:border-slate-800 rounded-full shadow-sm"></div>
                                    @endif
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ $user->name }}</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400 font-medium">UID: #{{ $user->id }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 lowercase leading-tight">{{ $user->email }}</span>
                                @if($user->phone)
                                    <span class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $user->phone }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex flex-wrap justify-center gap-1.5">
                                @foreach($user->roles as $role)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-black uppercase tracking-wider bg-indigo-50 text-indigo-700 border border-indigo-100 dark:bg-indigo-900/30 dark:text-indigo-300 dark:border-indigo-800/50 shadow-sm">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if($user->active)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400 shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Ativo
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                    Inativo
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-xs font-bold text-gray-600 dark:text-gray-400 flex flex-col">
                                <span>{{ $user->created_at->format('d/m/Y') }}</span>
                                <span class="font-medium opacity-60">{{ $user->created_at->format('H:i') }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.users.show', $user) }}" class="p-2 text-indigo-600 hover:text-white hover:bg-indigo-600 dark:text-indigo-400 dark:hover:bg-indigo-600 transition-all duration-200 rounded-xl shadow-sm hover:shadow-indigo-200 dark:hover:shadow-none ring-1 ring-indigo-100 dark:ring-indigo-900/50" title="Visualizar Perfil">
                                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="p-2 text-amber-600 hover:text-white hover:bg-amber-600 dark:text-amber-400 dark:hover:bg-amber-600 transition-all duration-200 rounded-xl shadow-sm hover:shadow-amber-200 dark:hover:shadow-none ring-1 ring-amber-100 dark:ring-amber-900/50" title="Editar Usuário">
                                    <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="p-2 {{ $user->active ? 'text-gray-600 hover:bg-gray-600' : 'text-emerald-600 hover:bg-emerald-600' }} hover:text-white transition-all duration-200 rounded-xl shadow-sm ring-1 {{ $user->active ? 'ring-gray-100 dark:ring-gray-800' : 'ring-emerald-100 dark:ring-emerald-900/50' }}" title="{{ $user->active ? 'Desativar Acesso' : 'Ativar Acesso' }}">
                                        <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            @if($user->active)
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                            @else
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            @endif
                                        </svg>
                                    </button>
                                </form>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja deletar este usuário?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:text-white hover:bg-red-600 dark:text-red-400 dark:hover:bg-red-600 transition-all duration-200 rounded-xl shadow-sm hover:shadow-red-200 dark:hover:shadow-none ring-1 ring-red-100 dark:ring-red-900/50" title="Excluir Permanentemente">
                                        <svg class="w-4.5 h-4.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400 dark:text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 001.904-3.7c0-1.11-.89-2.01-2.01-2.01a1.99 1.99 0 00-1.915 1.25 5.25 5.25 0 01-4.237 3.25 5.25 5.25 0 01-4.237-3.25 1.99 1.99 0 00-1.915-1.25c-1.12 0-2.01.9-2.01 2.01a4.125 4.125 0 001.904 3.7 9.337 9.337 0 004.121.952 9.38 9.38 0 002.625-.372m0 0a9.344 9.344 0 002.25-.568 9.344 9.344 0 002.25.568m-4.5 0v-.75a6 6 0 00-1.5-.131m4.5 0v.75a6 6 0 01-1.5.131m-4.5 0v-.75a6 6 0 011.5-.131m4.5 0v.75a6 6 0 001.5.131" />
                                </svg>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Nenhum usuário encontrado</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
