@extends('admin.layouts.admin')

@section('title', 'Detalhes do Usuário')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-gray-900 dark:text-white flex items-center gap-3 mb-2 tracking-tight">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 via-indigo-600 to-violet-700 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/20 ring-1 ring-white/20">
                    <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </div>
                <span>Perfil: {{ $user->name }}</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors font-medium">Admin</a>
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <a href="{{ route('admin.users.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors font-medium">Usuários</a>
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <span class="text-gray-900 dark:text-white font-black uppercase tracking-wider text-xs">{{ $user->name }}</span>
            </nav>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-black text-white bg-gradient-to-r from-indigo-600 to-violet-700 rounded-xl hover:from-indigo-700 hover:to-violet-800 focus:ring-4 focus:ring-indigo-300 dark:focus:ring-indigo-900 transition-all shadow-md shadow-indigo-200 dark:shadow-none transform hover:scale-[1.03] active:scale-95 uppercase tracking-wide">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                </svg>
                Editar Perfil
            </a>
            <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-black text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:text-gray-300 dark:bg-slate-700 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-all shadow-sm transform hover:scale-[1.03] active:scale-95 uppercase tracking-wide">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Voltar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Foto e Informações - Flowbite Card -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
                <div class="h-24 bg-gradient-to-r from-indigo-500 via-indigo-600 to-violet-700"></div>
                <div class="px-6 pb-8 text-center -mt-12">
                    <div class="mb-4">
                        @if($user->photo)
                            <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto de Perfil"
                                 class="rounded-2xl border-4 border-white dark:border-slate-800 mx-auto object-cover w-32 h-32 shadow-xl ring-1 ring-black/5">
                        @else
                            <div class="rounded-2xl border-4 border-white dark:border-slate-800 mx-auto bg-gradient-to-br from-indigo-500 to-indigo-600 text-white flex items-center justify-center w-32 h-32 text-4xl font-black shadow-xl uppercase tracking-tighter">
                                {{ substr($user->name, 0, 2) }}
                            </div>
                        @endif
                    </div>
                    <h4 class="text-xl font-black text-gray-900 dark:text-white mb-1 tracking-tight">{{ $user->name }}</h4>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-4 break-all font-medium uppercase tracking-widest">{{ $user->email }}</p>

                    @if($user->active)
                        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-400 shadow-sm border border-emerald-200 dark:border-emerald-800/50 mb-6">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Conta Ativa
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-400 shadow-sm border border-red-200 dark:border-red-800/50 mb-6">
                            <span class="w-2 h-2 rounded-full bg-red-500"></span>
                            Conta Inativa
                        </span>
                    @endif

                    <div class="pt-6 border-t border-gray-100 dark:border-slate-700/50">
                        <p class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-3">Níveis de Acesso</p>
                        <div class="flex flex-wrap justify-center gap-1.5">
                            @forelse($user->roles as $role)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-indigo-50 text-indigo-700 border border-indigo-100 dark:bg-indigo-900/30 dark:text-indigo-300 dark:border-indigo-800/50 shadow-sm">
                                    {{ $role->name }}
                                </span>
                            @empty
                                <span class="text-xs text-gray-500 dark:text-gray-400 font-medium italic">Nenhuma role atribuída</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informações - Flowbite Card -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 flex items-center gap-3">
                    <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-lg">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-black text-gray-900 dark:text-white tracking-tight">Detalhes do Usuário</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                            <tr class="bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400 w-48">Nome:</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $user->name }}</td>
                            </tr>
                            <tr class="bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">Email:</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $user->email }}</td>
                            </tr>
                            <tr class="bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">Telefone:</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $user->phone ?? '-' }}</td>
                            </tr>
                            <tr class="bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">Roles:</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($user->roles as $role)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 dark:bg-slate-700 dark:text-gray-300">{{ $role->name }}</span>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                            <tr class="bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">Status:</td>
                                <td class="px-6 py-4">
                                    @if($user->active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">Ativo</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300">Inativo</span>
                                    @endif
                                </td>
                            </tr>
                            <tr class="bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">Cadastrado em:</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr class="bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">Última atualização:</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $user->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Histórico de Atividades - Flowbite Card -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 flex items-center gap-3">
            <div class="p-2 bg-violet-100 dark:bg-violet-900/30 text-violet-600 dark:text-violet-400 rounded-lg">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <h2 class="text-lg font-black text-gray-900 dark:text-white tracking-tight">Registro de Atividades Recentes</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50/30 dark:bg-slate-900/30 border-b border-gray-100 dark:border-slate-700">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-black tracking-wider">Ação Realizada</th>
                        <th scope="col" class="px-6 py-4 font-black tracking-wider">Módulo Afetado</th>
                        <th scope="col" class="px-6 py-4 font-black tracking-wider">Descrição Detalhada</th>
                        <th scope="col" class="px-6 py-4 font-black tracking-wider text-right">Data e Hora</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($auditLogs as $log)
                    <tr class="bg-white border-b dark:bg-slate-800 dark:border-slate-700/50 hover:bg-indigo-50/30 dark:hover:bg-indigo-900/10 transition-all duration-200 group">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wider bg-gray-100 text-gray-700 dark:bg-slate-700 dark:text-gray-300 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full bg-indigo-400"></div>
                                <span class="text-xs font-bold text-gray-600 dark:text-gray-400 uppercase tracking-tight">{{ $log->module ?? 'SISTEMA' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-gray-900 dark:text-white leading-relaxed">{{ $log->description }}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="text-xs font-bold text-gray-600 dark:text-gray-400 flex flex-col">
                                <span>{{ $log->created_at->format('d/m/Y') }}</span>
                                <span class="font-medium opacity-60">{{ $log->created_at->format('H:i:s') }}</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-20 text-center">
                            <div class="max-w-xs mx-auto flex flex-col items-center justify-center opacity-40">
                                <div class="w-16 h-16 bg-gray-100 dark:bg-slate-700 rounded-2xl flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest">Nenhuma atividade</p>
                                <p class="text-[11px] font-medium text-gray-500 dark:text-gray-400 mt-1">Este usuário ainda não realizou ações registradas.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
