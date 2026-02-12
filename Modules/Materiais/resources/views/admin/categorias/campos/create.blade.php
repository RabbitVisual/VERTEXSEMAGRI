@extends('admin.layouts.admin')

@section('title', 'Novo Campo Dinâmico - Admin')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in font-poppins pb-12">
    <!-- Page Header -->
    <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 dark:border-slate-700 transition-all duration-300">
        <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-50/50 dark:bg-emerald-900/10 rounded-full -mr-32 -mt-32 blur-3xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-200 dark:shadow-none text-white transition-transform hover:rotate-3">
                    <x-icon name="plus" style="duotone" class="w-7 h-7 md:w-8 md:h-8" />
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-1">
                        Novo Campo Dinâmico
                    </h1>
                    <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 font-medium">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                        <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                        <a href="{{ route('admin.materiais.categorias.subcategorias.campos.index', [$categoria->id, $subcategoria->id]) }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors font-bold">Atributos</a>
                        <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                        <span class="text-gray-900 dark:text-white">Complemento Técnico</span>
                    </nav>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.materiais.categorias.subcategorias.campos.index', [$categoria->id, $subcategoria->id]) }}" class="inline-flex items-center gap-2 px-5 py-3 text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 transition-all duration-300 shadow-sm active:scale-95">
                    <x-icon name="arrow-left" style="duotone" class="w-5 h-5" />
                    Cancelar
                </a>
            </div>
        </div>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
    <div class="p-6 mb-8 text-sm text-red-800 rounded-2xl bg-red-50 border border-red-100 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800/50 flex items-start gap-3 animate-shake">
        <x-icon name="triangle-exclamation" class="w-6 h-6 mt-0.5" style="duotone" />
        <div>
            <p class="font-black uppercase tracking-wider text-xs mb-2">Restrições de Configuração:</p>
            <ul class="list-disc list-inside space-y-1 font-bold text-xs uppercase">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white dark:bg-slate-800 rounded-[2rem] shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
        <div class="px-8 py-6 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 flex items-center justify-between">
            <h3 class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-[0.2em] flex items-center gap-2">
                <x-icon name="sliders" style="duotone" class="w-4 h-4 text-emerald-500" />
                Parâmetros do Metadado
            </h3>
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-white dark:bg-slate-800 px-3 py-1 rounded-full border border-gray-100 dark:border-slate-700 italic">Vinculado a: {{ strtoupper($subcategoria->nome) }}</span>
        </div>

        <form action="{{ route('admin.materiais.categorias.subcategorias.campos.store', [$categoria->id, $subcategoria->id]) }}" method="POST" class="p-8 md:p-12">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10">
                <div class="space-y-2">
                    <label for="nome" class="text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">
                        Título do Atributo <span class="text-red-500">*</span>
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                            <x-icon name="input-text" class="w-4 h-4" />
                        </div>
                        <input type="text" id="nome" name="nome" value="{{ old('nome') }}" required
                            class="w-full bg-slate-50 dark:bg-slate-900 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500/20 text-gray-900 dark:text-white text-sm font-bold pl-12 p-4 transition-all shadow-inner"
                            placeholder="Ex: Tensão Nominal (V)">
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="tipo" class="text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">
                        Formato de Entrada <span class="text-red-500">*</span>
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                            <x-icon name="list-check" class="w-4 h-4" />
                        </div>
                        <select id="tipo" name="tipo" required
                            class="w-full bg-slate-50 dark:bg-slate-900 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500/20 text-gray-900 dark:text-white text-sm font-bold pl-12 p-4 transition-all shadow-inner appearance-none cursor-pointer">
                            <option value="text" {{ old('tipo') == 'text' ? 'selected' : '' }}>Texto Curto (Linha Única)</option>
                            <option value="number" {{ old('tipo') == 'number' ? 'selected' : '' }}>Valor Numérico (Decimal/Inteiro)</option>
                            <option value="select" {{ old('tipo') == 'select' ? 'selected' : '' }}>Lista de Seleção (Dropdown)</option>
                            <option value="textarea" {{ old('tipo') == 'textarea' ? 'selected' : '' }}>Texto Expandido (Descritivo)</option>
                            <option value="date" {{ old('tipo') == 'date' ? 'selected' : '' }}>Calendário (Data)</option>
                            <option value="boolean" {{ old('tipo') == 'boolean' ? 'selected' : '' }}>Estado Lógico (Sim/Não)</option>
                        </select>
                    </div>
                </div>

                <div id="opcoes-container" class="md:col-span-2 space-y-2 transition-all duration-500 {{ old('tipo') == 'select' ? 'block' : 'hidden' }}">
                    <label for="opcoes" class="text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">
                        Conjunto de Opções (Separadas por Vírgula)
                    </label>
                    <div class="relative group">
                        <div class="absolute top-4 left-4 pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                            <x-icon name="list-ul" class="w-4 h-4" />
                        </div>
                        <textarea id="opcoes" name="opcoes" rows="2"
                            class="w-full bg-slate-50 dark:bg-slate-900 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500/20 text-gray-900 dark:text-white text-sm font-bold pl-12 p-4 transition-all shadow-inner resize-none"
                            placeholder="Ex: 110V, 220V, Bivolt">{{ old('opcoes') }}</textarea>
                    </div>
                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest pl-1 mt-1">Este campo só é requisitado para o formato 'Lista de Seleção'.</p>
                </div>

                <div class="space-y-2">
                    <label for="placeholder" class="text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">
                        Texto de Ajuda Interno (Placeholder)
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                            <x-icon name="circle-question" class="w-4 h-4" />
                        </div>
                        <input type="text" id="placeholder" name="placeholder" value="{{ old('placeholder') }}"
                            class="w-full bg-slate-50 dark:bg-slate-900 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500/20 text-gray-900 dark:text-white text-sm font-bold pl-12 p-4 transition-all shadow-inner"
                            placeholder="Ex: Informe a voltagem padrão...">
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="slug" class="text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">
                        Identificador Interno (Slug)
                    </label>
                    <div class="relative group text-slate-400">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none group-focus-within:text-emerald-500 transition-colors">
                            <x-icon name="code" class="w-4 h-4" />
                        </div>
                        <input type="text" id="slug" name="slug" value="{{ old('slug') }}"
                            class="w-full bg-slate-50 dark:bg-slate-900 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500/20 text-gray-900 dark:text-white text-sm font-bold pl-12 p-4 transition-all shadow-inner"
                            placeholder="ex: voltagem-operacao">
                    </div>
                </div>

                <div class="md:col-span-2 space-y-2">
                    <label for="descricao" class="text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">
                        Instruções Adicionais de Preenchimento
                    </label>
                    <textarea id="descricao" name="descricao" rows="3"
                        class="w-full bg-slate-50 dark:bg-slate-900 border-none rounded-3xl focus:ring-2 focus:ring-emerald-500/20 text-gray-900 dark:text-white text-sm font-bold p-6 transition-all shadow-inner resize-none lg:h-24"
                        placeholder="Oriente o usuário sobre como este dado deve ser coletado/inserido... ">{{ old('descricao') }}</textarea>
                </div>

                <div class="flex flex-col md:flex-row gap-8 pt-4">
                    <div class="space-x-4">
                         <label for="ordem" class="text-[11px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1 block mb-3">Ordem Lógica</label>
                         <input type="number" id="ordem" name="ordem" value="{{ old('ordem', 0) }}" min="0"
                                class="w-24 bg-slate-50 dark:bg-slate-900 border-none rounded-2xl focus:ring-2 focus:ring-emerald-500/20 text-gray-900 dark:text-white text-base font-black p-4 transition-all shadow-inner text-center">
                    </div>

                    <div class="flex items-center gap-10 pt-8">
                        <label class="relative inline-flex items-center cursor-pointer group">
                            <input type="checkbox" name="obrigatorio" value="1" {{ old('obrigatorio') ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-12 h-7 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-amber-500 shadow-inner"></div>
                            <span class="ml-3 text-[10px] font-black text-gray-700 dark:text-gray-300 uppercase tracking-widest">Obrigatório</span>
                        </label>

                        <label class="relative inline-flex items-center cursor-pointer group">
                            <input type="checkbox" name="ativo" value="1" {{ old('ativo', true) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-12 h-7 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-emerald-600 shadow-inner"></div>
                            <span class="ml-3 text-[10px] font-black text-gray-700 dark:text-gray-300 uppercase tracking-widest">Ativo</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 mt-16 pt-8 border-t border-gray-100 dark:border-slate-700">
                <a href="{{ route('admin.materiais.categorias.subcategorias.campos.index', [$categoria->id, $subcategoria->id]) }}" class="px-8 py-4 text-sm font-black text-gray-500 bg-white border-2 border-slate-100 rounded-2xl hover:bg-slate-50 transition-all active:scale-95 shadow-sm">
                    Cancelar
                </a>
                <button type="submit" class="inline-flex items-center gap-3 px-10 py-4 text-sm font-black text-white bg-emerald-600 rounded-2xl hover:bg-emerald-700 shadow-xl shadow-emerald-500/40 transition-all active:scale-95 border-b-4 border-emerald-800">
                    <x-icon name="floppy-disk" style="duotone" class="w-5 h-5" />
                    Efetivar Atributo
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tipoSelect = document.getElementById('tipo');
    const opcoesContainer = document.getElementById('opcoes-container');

    function toggleOpcoes() {
        if (tipoSelect.value === 'select') {
            opcoesContainer.style.display = 'block';
            setTimeout(() => {
                opcoesContainer.style.opacity = '1';
                opcoesContainer.style.transform = 'translateY(0)';
            }, 10);
        } else {
            opcoesContainer.style.opacity = '0';
            opcoesContainer.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                opcoesContainer.style.display = 'none';
            }, 300);
        }
    }

    tipoSelect.addEventListener('change', toggleOpcoes);
    // Initial state
    if (tipoSelect.value !== 'select') {
        opcoesContainer.style.display = 'none';
        opcoesContainer.style.opacity = '0';
    }
});
</script>
@endpush
@endsection
