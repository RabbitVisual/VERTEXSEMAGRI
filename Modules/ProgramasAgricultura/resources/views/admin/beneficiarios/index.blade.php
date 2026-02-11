@extends('admin.layouts.admin')

@section('title', 'Gestão de Beneficiários - Agricultura')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12 font-sans">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center shadow-lg font-sans">
                    <x-icon name="users" class="w-6 h-6 md:w-7 md:h-7 text-white font-sans" style="duotone" />
                </div>
                <span>Gestão de Beneficiários</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 font-sans italic">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400 font-sans" style="duotone" />
                <span class="text-gray-900 dark:text-white font-medium uppercase tracking-widest text-[10px] font-sans">Agricultura</span>
            </nav>
        </div>
        <div class="flex gap-2 font-sans">
            <a href="{{ route('admin.programas-agricultura.programas.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 transition-colors font-sans">
                <x-icon name="leaf" class="w-5 h-5 font-sans" style="duotone" />
                Ver Programas
            </a>
        </div>
    </div>

    <!-- Estatísticas Premium -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 font-sans text-xs">
        <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow font-sans">
            <div class="flex items-center justify-between font-sans">
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest font-sans">Total de Cadastros</p>
                    <p class="text-2xl font-black text-gray-900 dark:text-white mt-1 italic tracking-tighter font-sans">{{ $estatisticas['total'] }}</p>
                </div>
                <div class="p-3 bg-amber-50 dark:bg-amber-900/20 rounded-xl border border-amber-100 dark:border-amber-800/50">
                    <x-icon name="users" class="w-6 h-6 text-amber-600 dark:text-amber-400 font-sans" style="duotone" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow font-sans">
            <div class="flex items-center justify-between font-sans">
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest font-sans italic">Habilitados / Ativos</p>
                    <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400 mt-1 italic tracking-tighter font-sans">{{ $estatisticas['aprovados'] }}</p>
                </div>
                <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl border border-emerald-100 dark:border-emerald-800/50 font-sans">
                    <x-icon name="circle-check" class="w-6 h-6 text-emerald-600 dark:text-emerald-400 font-sans" style="duotone" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow font-sans">
            <div class="flex items-center justify-between font-sans">
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest font-sans italic tracking-tighter">Impacto Social</p>
                    <p class="text-2xl font-black text-blue-600 dark:text-blue-400 mt-1 italic tracking-tighter font-sans">{{ $estatisticas['beneficiados'] }}</p>
                </div>
                <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800/50 font-sans">
                    <x-icon name="award" class="w-6 h-6 text-blue-600 dark:text-blue-400 font-sans" style="duotone" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-2xl shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow font-sans">
            <div class="flex items-center justify-between font-sans">
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest font-sans">Novas Inscrições</p>
                    <p class="text-2xl font-black text-amber-500 mt-1 italic tracking-tighter font-sans">{{ $estatisticas['inscritos'] }}</p>
                </div>
                <div class="p-3 bg-amber-50 dark:bg-amber-900/20 rounded-xl border border-amber-100 dark:border-amber-800/50 font-sans">
                    <x-icon name="clock" class="w-6 h-6 text-amber-500 font-sans" style="duotone" />
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros de Inteligência -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-200 dark:border-slate-700/50 overflow-hidden font-sans">
        <form method="GET" action="{{ route('admin.programas-agricultura.beneficiarios.index') }}" class="p-6 font-sans">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 font-sans italic">
                <div class="md:col-span-4 font-sans">
                    <div class="relative font-sans">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none font-sans">
                            <x-icon name="magnifying-glass" class="w-4 h-4 text-gray-400 font-sans" />
                        </div>
                        <input type="text" name="search" id="search" value="{{ $filters['search'] ?? '' }}" placeholder="Nome ou CPF do beneficiário..." class="block w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 transition-all dark:bg-slate-900 dark:border-slate-700 dark:text-white font-sans italic">
                    </div>
                </div>
                <div class="md:col-span-3 font-sans">
                    <select name="programa_id" class="bg-gray-50 border border-gray-200 text-gray-900 text-[10px] font-black uppercase tracking-widest rounded-xl focus:ring-amber-500 focus:border-amber-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white font-sans italic">
                        <option value="">Todos os Programas</option>
                        @foreach($programas as $prog)
                            <option value="{{ $prog->id }}" {{ ($filters['programa_id'] ?? '') == $prog->id ? 'selected' : '' }}>{{ $prog->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-3 font-sans">
                    <select name="status" class="bg-gray-50 border border-gray-200 text-gray-900 text-[10px] font-black uppercase tracking-widest rounded-xl focus:ring-amber-500 focus:border-amber-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white font-sans italic">
                        <option value="">Todos os Status</option>
                        <option value="inscrito" {{ ($filters['status'] ?? '') == 'inscrito' ? 'selected' : '' }}>Novo / Inscrito</option>
                        <option value="aprovado" {{ ($filters['status'] ?? '') == 'aprovado' ? 'selected' : '' }}>Aprovado</option>
                        <option value="beneficiado" {{ ($filters['status'] ?? '') == 'beneficiado' ? 'selected' : '' }}>Já Beneficiado</option>
                        <option value="rejeitado" {{ ($filters['status'] ?? '') == 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
                    </select>
                </div>
                <div class="md:col-span-2 flex gap-2 font-sans italic">
                    <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 text-[10px] font-black text-white bg-slate-900 dark:bg-amber-600 rounded-xl hover:bg-slate-800 transition-all active:scale-95 font-sans italic tracking-widest uppercase">
                        Buscar
                    </button>
                    <a href="{{ route('admin.programas-agricultura.beneficiarios.index') }}" class="inline-flex items-center justify-center p-3 text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors dark:bg-slate-700 dark:text-slate-300 font-sans italic">
                        <x-icon name="rotate-right" class="w-5 h-5 font-sans italic" style="duotone" />
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabela Hierárquica -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-200 dark:border-slate-700/50 overflow-hidden font-sans italic">
        <div class="overflow-x-auto font-sans italic">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 font-sans italic">
                <thead class="text-[10px] font-black text-slate-400 uppercase bg-gray-50/50 dark:bg-slate-900/50 tracking-widest font-sans italic text-xs">
                    <tr>
                        <th scope="col" class="px-6 py-5">Perfil / Beneficiário</th>
                        <th scope="col" class="px-6 py-5">Vinculação / Programa</th>
                        <th scope="col" class="px-6 py-5">Território / Localidade</th>
                        <th scope="col" class="px-6 py-5 text-center">Data Cadastro</th>
                        <th scope="col" class="px-6 py-5 text-right font-sans italic">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50 font-sans italic text-xs">
                    @forelse($beneficiarios as $beneficiario)
                    <tr class="hover:bg-amber-50/30 dark:hover:bg-amber-900/10 transition-colors group font-sans italic text-xs">
                        <td class="px-6 py-5 font-sans italic">
                            <div class="flex items-center gap-4 font-sans italic">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-100 to-amber-200 dark:from-amber-900/30 dark:to-amber-900/50 flex items-center justify-center text-amber-700 dark:text-amber-400 font-black shadow-sm group-hover:scale-110 transition-transform font-sans italic border-2 border-white dark:border-slate-800">
                                    {{ substr($beneficiario->pessoa->nom_pessoa, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight group-hover:text-amber-600 transition-colors font-sans italic">
                                        {{ $beneficiario->pessoa->nom_pessoa }}
                                    </div>
                                    <div class="text-[10px] font-mono font-bold text-gray-400 uppercase tracking-widest mt-1 italic">
                                        CPF: {{ $beneficiario->pessoa->num_cpf_pessoa }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 font-sans italic text-xs">
                            <div class="text-[10px] font-black text-slate-700 dark:text-slate-300 uppercase tracking-widest max-w-[200px] truncate italic">
                                {{ $beneficiario->programa->nome }}
                            </div>
                            <div class="flex items-center gap-1.5 mt-1 font-sans italic">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse italic"></span>
                                <span class="text-[9px] font-black text-amber-500 uppercase tracking-widest italic tracking-tighter">{{ $beneficiario->status }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5 italic text-xs text-gray-500 dark:text-gray-400 font-sans italic uppercase">
                             <div class="flex items-center gap-2 font-sans italic">
                                <x-icon name="location-pin" class="w-3.5 h-3.5 text-slate-400 font-sans italic" />
                                <span class="font-bold tracking-tight">{{ $beneficiario->localidade->nome ?? 'CENTRO' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center text-xs font-black text-gray-900 dark:text-white italic font-sans italic tracking-tighter uppercase">
                            {{ $beneficiario->data_inscricao->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-5 text-right font-sans italic text-xs">
                            <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all font-sans italic text-xs">
                                <a href="{{ route('admin.programas-agricultura.beneficiarios.show', $beneficiario->id) }}" class="inline-flex items-center justify-center w-10 h-10 text-amber-600 bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-800 rounded-xl hover:bg-amber-600 hover:text-white transition-all shadow-sm font-sans italic" title="Explorar Ficha">
                                    <x-icon name="user-check" class="w-5 h-5 font-sans italic text-xs" style="duotone" />
                                </a>
                                <form action="{{ route('admin.programas-agricultura.beneficiarios.destroy', $beneficiario->id) }}" method="POST" onsubmit="return confirm('Deseja realmente remover este beneficiário?')" class="inline italic">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-10 h-10 text-red-600 bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800 rounded-xl hover:bg-red-600 hover:text-white transition-all shadow-sm font-sans italic">
                                        <x-icon name="trash" class="w-5 h-5 font-sans italic text-xs" style="duotone" />
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500 font-medium italic">Nenhum beneficiário localizado no sistema de gestão.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($beneficiarios->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-700/50 bg-slate-50/30">
            {{ $beneficiarios->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
