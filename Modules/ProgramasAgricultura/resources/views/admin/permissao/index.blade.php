@extends('admin.layouts.admin')

@section('title', 'Matriz de Permissões - Agricultura')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12 font-sans italic">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700 font-sans italic">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2 font-sans italic tracking-tighter shadow-sm">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center shadow-lg font-sans italic">
                    <x-icon name="user-shield" class="w-6 h-6 md:w-7 md:h-7 text-white font-sans italic" style="duotone" />
                </div>
                <span>Matriz de Permissões</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 font-sans italic">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors font-sans italic">Admin</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400 font-sans italic" style="duotone" />
                <span class="text-gray-900 dark:text-white font-medium uppercase tracking-widest text-[10px] font-sans italic">Segurança Setorial</span>
            </nav>
        </div>
        <div class="flex gap-2 font-sans italic">
            <button type="submit" form="form-permissoes" class="inline-flex items-center gap-2 px-6 py-3 bg-amber-600 text-white rounded-xl hover:bg-amber-700 transition-all shadow-lg shadow-amber-500/20 font-black uppercase tracking-widest text-[10px] font-sans italic active:scale-95">
                <x-icon name="floppy-disk" class="w-4 h-4 font-sans italic" style="duotone" />
                Consolidar Matriz
            </button>
        </div>
    </div>

    @if(session('success'))
    <div class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-2xl flex items-center gap-3 shadow-sm animate-fade-in font-sans italic uppercase text-[10px] font-black tracking-widest">
        <x-icon name="circle-check" class="w-5 h-5 text-emerald-500 font-sans italic" style="duotone" />
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Matriz de Controle -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-200 dark:border-slate-700/50 overflow-hidden font-sans italic">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 font-sans italic">
             <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic font-sans italic">Checklist de Acesso por Programa</h3>
        </div>
        <form action="{{ route('admin.programas-agricultura.permissao.store') }}" method="POST" id="form-permissoes" class="font-sans italic uppercase text-xs">
            @csrf
            <div class="overflow-x-auto font-sans italic">
                <table class="w-full text-left border-collapse font-sans italic">
                    <thead>
                        <tr class="bg-white dark:bg-slate-800 font-sans italic">
                            <th class="px-6 py-8 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-gray-100 dark:border-slate-700 font-sans italic min-w-[300px]">
                                Co-Administrador Técnico
                            </th>
                            @foreach($programas as $programa)
                            <th class="px-6 py-8 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-gray-100 dark:border-slate-700 text-center min-w-[180px] font-sans italic bg-slate-50/30 dark:bg-slate-900/10">
                                <div class="flex flex-col items-center gap-2 font-sans italic">
                                    <span class="text-amber-600 dark:text-amber-400 font-black italic tracking-tighter uppercase">{{ $programa->codigo }}</span>
                                    <span class="text-[9px] text-slate-600 dark:text-slate-300 italic tracking-tighter font-sans leading-tight">{{ $programa->nome }}</span>
                                </div>
                            </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700 font-sans italic text-xs uppercase">
                        @forelse($users as $user)
                        <tr class="hover:bg-amber-50/30 dark:hover:bg-amber-900/10 transition-colors group font-sans italic text-xs uppercase">
                            <td class="px-6 py-6 font-sans italic text-xs uppercase">
                                <div class="flex items-center gap-4 font-sans italic text-xs uppercase">
                                    <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-slate-900 flex items-center justify-center text-amber-700 dark:text-amber-400 font-black italic shadow-sm border border-amber-100 dark:border-slate-800 group-hover:scale-105 transition-all font-sans italic">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight group-hover:text-amber-600 transition-colors font-sans italic">
                                            {{ $user->name }}
                                        </div>
                                        <div class="text-[10px] font-medium text-gray-500 dark:text-gray-400 italic mt-0.5 font-sans lowercase">
                                            {{ $user->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            @foreach($programas as $programa)
                            <td class="px-6 py-6 text-center italic font-sans text-xs bg-slate-50/10 dark:bg-slate-900/5 group-hover:bg-amber-50/50 transition-colors">
                                <label class="relative inline-flex items-center cursor-pointer group/switch">
                                    <input type="checkbox" name="permissoes[{{ $user->id }}][]" value="{{ $programa->id }}"
                                           class="sr-only peer"
                                           {{ $user->programasResponsaveis->contains($programa->id) ? 'checked' : '' }}>
                                    <div class="w-12 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-amber-600 shadow-inner"></div>
                                </label>
                            </td>
                            @endforeach
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ count($programas) + 1 }}" class="px-6 py-16 text-center font-sans italic">
                                <div class="flex flex-col items-center gap-4 font-sans italic uppercase font-black text-xs text-slate-400">
                                    <x-icon name="user-slash" class="w-12 h-12 opacity-30 font-sans italic text-xs" />
                                    <p class="italic tracking-widest">Nenhum Co-Administrador localizado.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>
    </div>

    <!-- Guia de Operação -->
    <div class="bg-blue-900/90 dark:bg-slate-900/90 rounded-3xl p-8 border border-blue-800/50 shadow-2xl relative overflow-hidden font-sans italic">
        <div class="absolute top-0 right-0 p-8 opacity-10 font-sans italic uppercase text-xs">
            <x-icon name="shield-check" class="w-32 h-32 text-white font-sans italic" />
        </div>
        <div class="relative z-10 font-sans italic">
            <div class="flex items-center gap-3 mb-4 font-sans italic text-xs uppercase">
                <div class="p-2 bg-blue-500/20 rounded-lg font-sans italic">
                    <x-icon name="circle-info" class="w-5 h-5 text-blue-400 font-sans italic" style="duotone" />
                </div>
                <h4 class="text-[11px] font-black text-white uppercase tracking-widest italic font-sans">Diretrizes de Segurança Técnica</h4>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 font-sans italic">
                <div class="font-sans italic uppercase text-[10px] text-blue-100 font-bold leading-relaxed tracking-wide">
                    Os Co-Admins selecionados terão acesso <span class="text-amber-400">EXCLUSIVO</span> aos beneficiários e inscrições vinculados aos programas marcados. Caso um usuário não possua marcações, o módulo de agricultura permanecerá oculto para o mesmo.
                </div>
                <div class="font-sans italic uppercase text-[10px] text-blue-100 font-bold leading-relaxed tracking-wide">
                    Certifique-se de salvar as alterações após cada ajuste. O sistema aplica as novas permissões instantaneamente no próximo carregamento de página do administrador afetado.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
