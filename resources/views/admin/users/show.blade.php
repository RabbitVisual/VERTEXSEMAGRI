@extends('admin.layouts.admin')

@section('title', 'Detalhes do Usuário')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-gray-900 dark:text-white flex items-center gap-3 mb-2 tracking-tight">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 via-indigo-600 to-violet-700 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/20 ring-1 ring-white/20">
                    <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('admin.users.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors font-medium">Usuários</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white font-black uppercase tracking-wider text-xs">{{ $user->name }}</span>
            </nav>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-black text-white bg-gradient-to-r from-indigo-600 to-violet-700 rounded-xl hover:from-indigo-700 hover:to-violet-800 focus:ring-4 focus:ring-indigo-300 dark:focus:ring-indigo-900 transition-all shadow-md shadow-indigo-200 dark:shadow-none transform hover:scale-[1.03] active:scale-95 uppercase tracking-wide">
                <x-icon name="arrow-left" class="w-5 h-5" />
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
                        <x-icon name="file-pdf" class="w-5 h-5" />
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
