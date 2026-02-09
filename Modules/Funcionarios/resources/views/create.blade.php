@extends('Co-Admin.layouts.app')

@section('title', 'Novo Agente: Recrutamento')

@section('content')
<div class="max-w-5xl mx-auto space-y-6 md:space-y-10 animate-fade-in pb-12">
    <!-- Header de Cadastro -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6 pb-6 border-b border-gray-200 dark:border-slate-800">
        <div class="flex items-center gap-5">
            <div class="w-16 h-16 bg-gradient-to-br from-emerald-600 to-teal-700 rounded-3xl flex items-center justify-center text-white shadow-2xl transform shadow-emerald-600/20">
                <x-icon name="user-plus" style="duotone" class="w-8 h-8" />
            </div>
            <div>
                <h1 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight uppercase leading-none">Novo Recrutamento</h1>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mt-2 italic">Ingresso de novo agente no sistema operacional</p>
            </div>
        </div>
        <a href="{{ route('funcionarios.index') }}" class="inline-flex items-center gap-2 px-6 py-3 text-[10px] font-black uppercase tracking-widest text-slate-500 bg-gray-50 border border-gray-100 hover:bg-gray-100 rounded-xl transition-all dark:bg-slate-800 dark:text-slate-400 dark:border-slate-700">
            <x-icon name="arrow-left" class="w-4 h-4" />
            Voltar
        </a>
    </div>

    <!-- Alertas de Erro de Validação -->
    @if($errors->any())
    <div class="p-6 bg-rose-50 dark:bg-rose-900/10 border border-rose-100 dark:border-rose-800 rounded-3xl animate-scale-in">
        <div class="flex gap-4">
            <x-icon name="circle-exclamation" style="duotone" class="w-6 h-6 text-rose-600 mt-1" />
            <div>
                <h4 class="text-xs font-black text-rose-800 dark:text-rose-400 uppercase tracking-widest mb-3 italic">Erros de Protocolo Localizados:</h4>
                <ul class="space-y-1">
                    @foreach($errors->all() as $error)
                        <li class="text-xs font-bold text-rose-700 dark:text-rose-500 flex items-center gap-2 italic ring-1 ring-rose-200 dark:ring-rose-800/50 px-2 py-1 rounded bg-white/50 dark:bg-black/20 w-fit">
                            <span class="w-1 h-1 rounded-full bg-rose-500"></span>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <form action="{{ route('funcionarios.store') }}" method="POST" class="space-y-8">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Bloco 1: Identificação -->
            <div class="lg:col-span-8 space-y-8">
                <div class="premium-card p-8">
                    <div class="flex items-center gap-4 mb-8 border-b border-gray-50 dark:border-slate-800 pb-6">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center text-emerald-600">
                            <x-icon name="id-card" style="duotone" class="w-6 h-6" />
                        </div>
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] italic">Identificação Básica do Agente</h3>
                    </div>

                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                            <div class="md:col-span-8">
                                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 italic ml-1">Nome Completo do Candidato</label>
                                <input type="text" name="nome" value="{{ old('nome') }}" required placeholder="Ex: JOÃO DA SILVA SANTOS" class="form-input-premium w-full pr-4 py-4 bg-gray-50 dark:bg-slate-900 border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 dark:text-white transition-all">
                            </div>
                            <div class="md:col-span-4">
                                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 italic ml-1">Registro (CPF)</label>
                                <input type="text" name="cpf" id="cpf" value="{{ old('cpf') }}" required placeholder="000.000.000-00" class="form-input-premium w-full pr-4 py-4 bg-gray-50 dark:bg-slate-900 border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 dark:text-white transition-all">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                            <div class="md:col-span-12">
                                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 italic ml-1">E-mail Corporativo / Pessoal</label>
                                <div class="relative group">
                                    <x-icon name="at" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 transition-colors group-focus-within:text-emerald-500" />
                                    <input type="email" name="email" value="{{ old('email') }}" placeholder="IDENTIDADE@EXEMPLO.COM" class="form-input-premium w-full pl-12 pr-4 py-4 bg-gray-50 dark:bg-slate-900 border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 dark:text-white transition-all">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bloco 2: Profissional -->
                <div class="premium-card p-8">
                    <div class="flex items-center gap-4 mb-8 border-b border-gray-50 dark:border-slate-800 pb-6">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600">
                            <x-icon name="briefcase" style="duotone" class="w-6 h-6" />
                        </div>
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] italic">Qualificação Profissional</h3>
                    </div>

                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 italic ml-1">Função Operacional</label>
                                <select name="funcao" required class="w-full py-4 bg-gray-50 dark:bg-slate-900 border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 dark:text-white transition-all cursor-pointer appearance-none">
                                    <option value="">SELECIONE A QUALIFICAÇÃO</option>
                                    @php
                                        $funcoes_opt = [
                                            'eletricista' => 'ELETRICISTA DE REDE',
                                            'encanador' => 'ENCANADOR HIDRÁULICO',
                                            'operador' => 'OPERADOR DE MÁQUINAS',
                                            'motorista' => 'MOTORISTA OPERACIONAL',
                                            'supervisor' => 'SUPERVISOR DE CAMPO',
                                            'tecnico' => 'TÉCNICO ESPECIALISTA',
                                            'outro' => 'OUTRA CATEGORIA'
                                        ];
                                    @endphp
                                    @foreach($funcoes_opt as $val => $lbl)
                                        <option value="{{ $val }}" {{ old('funcao') == $val ? 'selected' : '' }}>{{ $lbl }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 italic ml-1">Contato Telefônico</label>
                                <div class="relative group">
                                    <x-icon name="phone" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400 transition-colors group-focus-within:text-emerald-500" />
                                    <input type="text" name="telefone" id="telefone" value="{{ old('telefone') }}" placeholder="(00) 00000-0000" class="form-input-premium w-full pl-12 pr-4 py-4 bg-gray-50 dark:bg-slate-900 border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 dark:text-white transition-all">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 italic ml-1">Data de Admissão</label>
                                <input type="date" name="data_admissao" value="{{ old('data_admissao') }}" class="w-full py-4 px-4 bg-gray-50 dark:bg-slate-900 border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 dark:text-white transition-all">
                            </div>
                            <div>
                                <label class="block text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 italic ml-1">Data de Demissão (Opcional)</label>
                                <input type="date" name="data_demissao" value="{{ old('data_demissao') }}" class="w-full py-4 px-4 bg-gray-50 dark:bg-slate-900 border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 dark:text-white transition-all">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bloco Lateral: Sistema e Observações -->
            <div class="lg:col-span-4 space-y-8">
                <div class="premium-card p-8">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-3 italic">
                        <x-icon name="gears" style="duotone" class="w-5 h-5 text-emerald-500" />
                        Acesso ao Sistema
                    </h3>

                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800">
                        <label for="ativo" class="text-[10px] font-black text-slate-600 dark:text-slate-300 uppercase tracking-widest cursor-pointer">Status Operacional</label>
                        <div class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="ativo" id="ativo" value="1" {{ old('ativo', true) ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-emerald-300 dark:peer-focus:ring-emerald-800 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-emerald-600"></div>
                        </div>
                    </div>
                    <p class="text-[9px] text-slate-400 mt-4 leading-relaxed font-bold uppercase tracking-tighter italic">Se ativado, o sistema poderá enviar credenciais de acesso ao e-mail informado caso possua integração ativa.</p>
                </div>

                <div class="premium-card p-8">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-3 italic">
                        <x-icon name="comment-medical" style="duotone" class="w-5 h-5 text-emerald-500" />
                        Notas Extras
                    </h3>
                    <textarea name="observacoes" rows="6" placeholder="ANOTAÇÕES TÉCNICAS E OBSERVACÕES DO RECRUTAMENTO..." class="w-full p-5 bg-gray-50 dark:bg-slate-900 border-gray-100 dark:border-slate-800 rounded-[2rem] text-[10px] font-black uppercase tracking-widest focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 dark:text-white placeholder:text-slate-400 transition-all resize-none">{{ old('observacoes') }}</textarea>
                </div>

                <button type="submit" class="w-full py-6 bg-gradient-to-r from-emerald-600 to-teal-700 text-white rounded-[2rem] text-[12px] font-black uppercase tracking-[0.2em] hover:shadow-2xl hover:shadow-emerald-600/30 hover:-translate-y-1 active:scale-95 transition-all shadow-xl">
                    Finalizar Cadastro
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Máscara CPF
    const cpfField = document.getElementById('cpf');
    if (cpfField) {
        cpfField.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                e.target.value = value;
            }
        });
    }

    // Máscara Telefone
    const telField = document.getElementById('telefone');
    if (telField) {
        telField.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                if (value.length <= 10) {
                    value = value.replace(/(\d{2})(\d)/, '($1) $2');
                    value = value.replace(/(\d{4})(\d)/, '$1-$2');
                } else {
                    value = value.replace(/(\d{2})(\d)/, '($1) $2');
                    value = value.replace(/(\d{5})(\d)/, '$1-$2');
                }
                e.target.value = value;
            }
        });
    }
});
</script>
@endpush
@endsection
