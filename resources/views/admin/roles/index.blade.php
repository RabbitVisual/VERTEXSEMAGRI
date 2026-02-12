@extends('admin.layouts.admin')

@section('title', 'Gerenciar Funções')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12 font-sans">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 to-violet-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="user-shield" class="w-6 h-6 md:w-7 md:h-7 text-white" style="duotone" />
                </div>
                <span>Controle de <span class="text-indigo-600 dark:text-indigo-400">Funções</span></span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                <span class="text-gray-900 dark:text-white font-medium">Controle de Acesso (RBAC)</span>
            </nav>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.permissions.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 focus:ring-4 focus:ring-gray-100 dark:focus:ring-slate-700 transition-all shadow-sm">
                <x-icon name="key" class="w-5 h-5" style="duotone" />
                Ver Permissões
            </a>
            <a href="{{ route('admin.roles.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 dark:focus:ring-indigo-800 transition-all shadow-md shadow-indigo-500/20 active:scale-95">
                <x-icon name="plus" class="w-5 h-5" />
                Nova Função
            </a>
        </div>
    </div>

    <!-- Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-slate-700 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-indigo-50 dark:bg-indigo-900/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <p class="text-xs font-bold text-indigo-500 uppercase tracking-wider mb-2">Total de Funções</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-gray-900 dark:text-white">{{ $roles->count() }}</span>
                    <span class="text-xs text-slate-500">registradas</span>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-slate-700 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-purple-50 dark:bg-purple-900/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <p class="text-xs font-bold text-purple-500 uppercase tracking-wider mb-2">Funções com Acesso Total</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-gray-900 dark:text-white">
                        {{ $roles->filter(fn($r) => $r->name === 'admin' || $r->name === 'super-admin')->count() }}
                    </span>
                    <span class="text-xs text-purple-600 dark:text-purple-400 font-medium flex items-center gap-1">
                        <x-icon name="shield-check" class="w-3 h-3" style="solid" />
                        Privilegiadas
                    </span>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-slate-700 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-blue-50 dark:bg-blue-900/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <p class="text-xs font-bold text-blue-500 uppercase tracking-wider mb-2">Média de Permissões</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-gray-900 dark:text-white">
                        {{ $roles->count() > 0 ? round($roles->sum(fn($r) => $r->permissions->count()) / $roles->count()) : 0 }}
                    </span>
                    <span class="text-xs text-slate-500">por função</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid de Roles -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($roles as $role)
            <div class="group bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-slate-700 hover:shadow-md transition-all flex flex-col h-full relative overflow-hidden">
                <!-- Header Card -->
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                             @if($role->name === 'admin' || $role->name === 'super-admin')
                                <x-icon name="crown" style="duotone" class="w-6 h-6" />
                            @else
                                <x-icon name="user-tag" style="duotone" class="w-6 h-6" />
                            @endif
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                {{ $role->name }}
                            </h3>
                            <span class="text-xs font-medium text-slate-500">GD {{ $role->guard_name }}</span>
                        </div>
                    </div>

                    <div class="relative">
                         <button id="dropdownMenuIconButton{{ $role->id }}" data-dropdown-toggle="dropdownDots{{ $role->id }}" class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-slate-800 dark:hover:bg-slate-700 dark:focus:ring-gray-600" type="button">
                            <x-icon name="ellipsis-vertical" class="w-5 h-5" />
                        </button>
                    </div>
                </div>

                <!-- Estatísticas do Card -->
                <div class="grid grid-cols-2 gap-4 py-4 border-t border-b border-gray-100 dark:border-slate-700 mb-4 bg-gray-50/50 dark:bg-slate-900/30 -mx-6 px-6">
                    <div class="text-center">
                        <span class="block text-2xl font-bold text-gray-900 dark:text-white">{{ $role->users->count() }}</span>
                        <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Usuários</span>
                    </div>
                    <div class="text-center border-l border-gray-200 dark:border-slate-700">
                        <span class="block text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $role->permissions->count() }}</span>
                        <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Permissões</span>
                    </div>
                </div>

                <div class="flex-grow">
                     @if($role->permissions->count() > 0)
                        <div class="flex flex-wrap gap-1.5 mb-2 max-h-24 overflow-hidden relative">
                            @foreach($role->permissions->take(5) as $permission)
                                <span class="inline-flex items-center px-2 py-1 rounded text-[10px] font-medium bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300">
                                    {{ $permission->name }}
                                </span>
                            @endforeach
                            @if($role->permissions->count() > 5)
                                <span class="inline-flex items-center px-2 py-1 rounded text-[10px] font-medium bg-indigo-50 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-300">
                                    +{{ $role->permissions->count() - 5 }}
                                </span>
                            @endif
                        </div>
                    @else
                        <p class="text-sm text-slate-400 italic">Nenhuma permissão específica atribuída.</p>
                    @endif
                </div>

                 <div class="mt-4 pt-4 border-t border-gray-100 dark:border-slate-700 flex items-center justify-between">
                    <a href="{{ route('admin.roles.show', $role->id) }}" class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors flex items-center gap-1">
                        Ver Detalhes
                        <x-icon name="arrow-right" class="w-4 h-4" />
                    </a>
                </div>

                <!-- Dropdown Menu -->
                <div id="dropdownDots{{ $role->id }}" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-xl shadow-xl w-44 dark:bg-slate-800 dark:divide-slate-700 border border-gray-100 dark:border-slate-700">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownMenuIconButton{{ $role->id }}">
                        <li>
                            <a href="{{ route('admin.roles.edit', $role->id) }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-slate-700 flex items-center gap-2">
                                <x-icon name="pen-to-square" class="w-4 h-4 text-slate-400" />
                                Editar
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.roles.show', $role->id) }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-slate-700 flex items-center gap-2">
                                <x-icon name="eye" class="w-4 h-4 text-slate-400" />
                                Visualizar
                            </a>
                        </li>
                    </ul>
                    @if($role->name !== 'admin' && $role->name !== 'super-admin')
                    <div class="py-2">
                        <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta função?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-rose-600 hover:bg-gray-100 dark:hover:bg-slate-700 flex items-center gap-2">
                                <x-icon name="trash" class="w-4 h-4" />
                                Excluir
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full py-24 text-center">
                 <div class="w-20 h-20 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center text-slate-300 mx-auto mb-4">
                    <x-icon name="shield-slash" style="duotone" class="w-10 h-10" />
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Nenhuma função encontrada</h3>
                <p class="text-sm text-slate-500 mt-1">Comece criando uma nova função para os usuários.</p>
                <a href="{{ route('admin.roles.create') }}" class="inline-flex items-center gap-2 mt-4 px-6 py-2.5 text-sm font-bold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-all shadow-md">
                    <x-icon name="plus" class="w-5 h-5" />
                    Criar Primeira Função
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection
