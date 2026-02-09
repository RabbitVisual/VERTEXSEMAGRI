@extends('admin.layouts.admin')

@section('title', 'Editar Líder de Comunidade')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-800">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-gray-900 dark:text-white flex items-center gap-3 mb-2 uppercase tracking-tight">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center shadow-lg text-white">
                    <x-icon name="user-pen" style="duotone" class="w-6 h-6 md:w-7 md:h-7" />
                </div>
                <span>Editar Gestor</span>
            </h1>
            <nav class="flex items-center gap-2 text-xs font-black uppercase tracking-widest text-slate-400">
                <a href="{{ route('admin.lideres-comunidade.index') }}" class="hover:text-blue-600 transition-colors">Líderes</a>
                <x-icon name="chevron-right" class="w-3 h-3" />
                <span class="text-blue-600">{{ $lider->nome }}</span>
            </nav>
        </div>
        <a href="{{ route('admin.lideres-comunidade.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-[10px] font-black uppercase tracking-widest text-slate-500 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:text-slate-900 transition-all shadow-sm dark:bg-slate-800 dark:border-slate-700 dark:text-slate-400 dark:hover:text-white">
            <x-icon name="arrow-left" class="w-4 h-4" />
            Voltar à Lista
        </a>
    </div>

    <form action="{{ route('admin.lideres-comunidade.update', $lider) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                <!-- Informações do Líder -->
                <div class="premium-card overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-900/50 flex items-center justify-between">
                        <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2">
                            <x-icon name="user-tie" style="duotone" class="w-5 text-blue-500" />
                            Dados de Identificação
                        </h2>
                    </div>
                    <div class="p-8 space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label for="nome" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">
                                    Nome Completo <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="nome" name="nome" value="{{ old('nome', $lider->nome) }}" required
                                    class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white @error('nome') border-red-500 @enderror">
                                @error('nome')
                                    <p class="mt-2 text-[10px] font-bold text-red-600 uppercase tracking-widest">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="cpf" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">CPF</label>
                                <input type="text" id="cpf" name="cpf" value="{{ old('cpf', $lider->cpf_formatado) }}"
                                    class="cpf-mask w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white"
                                    placeholder="000.000.000-00">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label for="telefone" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Telefone de Contato</label>
                                <input type="text" id="telefone" name="telefone" value="{{ old('telefone', $lider->telefone) }}"
                                    class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white"
                                    placeholder="(00) 00000-0000">
                            </div>

                            <div>
                                <label for="email" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Endereço de E-mail</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $lider->email) }}"
                                    class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white"
                                    placeholder="email@exemplo.com">
                            </div>
                        </div>

                        <div>
                            <label for="endereco" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">
                                Localização Geográfica <span class="text-red-500">*</span>
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                     <x-icon name="location-dot" style="duotone" class="w-5 h-5 text-slate-400 group-focus-within:text-blue-500 transition-colors" />
                                </div>
                                <input type="text" id="endereco" name="endereco" value="{{ old('endereco', $lider->endereco) }}" required readonly
                                    class="w-full pl-12 pr-5 py-4 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl text-sm font-bold text-slate-500 dark:text-slate-400 cursor-not-allowed uppercase tracking-tighter">
                            </div>
                            <p class="mt-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-loose px-1">O logradouro é sincronizado automaticamente através da localidade vinculada.</p>
                        </div>
                    </div>
                </div>

                <!-- Vinculação Estrutural -->
                <div class="premium-card overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-900/50">
                        <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2">
                            <x-icon name="link" style="duotone" class="w-5 text-indigo-500" />
                            Relacionamentos do Sistema
                        </h2>
                    </div>
                    <div class="p-8 space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label for="localidade_id" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">
                                    Localidade Atendida <span class="text-red-500">*</span>
                                </label>
                                <select id="localidade_id" name="localidade_id" required
                                    class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                                    <option value="">Selecione...</option>
                                    @foreach($localidades as $localidade)
                                        <option value="{{ $localidade->id }}" {{ old('localidade_id', $lider->localidade_id) == $localidade->id ? 'selected' : '' }}>
                                            {{ $localidade->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="poco_id" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">
                                    Poço Responsável <span class="text-red-500">*</span>
                                </label>
                                <select id="poco_id" name="poco_id" required
                                    class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                                    <option value="">Selecione...</option>
                                    @foreach($pocos as $poco)
                                        <option value="{{ $poco->id }}" {{ old('poco_id', $lider->poco_id) == $poco->id ? 'selected' : '' }}>
                                            {{ $poco->nome_mapa ?? $poco->codigo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label for="user_id" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Acesso ao Painel</label>
                                <select id="user_id" name="user_id"
                                    class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                                    <option value="">Nenhum Vínculo</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id', $lider->user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="pessoa_id" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Vínculo CadÚnico</label>
                                <div class="relative group">
                                     <input type="text" id="pessoa_search_edit" name="pessoa_search"
                                        value="{{ $lider->pessoa ? $lider->pessoa->nom_pessoa : '' }}"
                                        placeholder="Pesquisar..."
                                        class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                                    <div id="pessoa_results_edit" class="hidden absolute z-50 w-full mt-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-2xl shadow-2xl max-h-64 overflow-y-auto"></div>
                                </div>
                                <input type="hidden" id="pessoa_id" name="pessoa_id" value="{{ old('pessoa_id', $lider->pessoa_id) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-8">
                <!-- Status e Controle -->
                <div class="premium-card p-8 space-y-8">
                    <div>
                         <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] mb-6 flex items-center gap-2">
                            <x-icon name="shield-halved" style="duotone" class="w-5 text-emerald-500" />
                            Controle de Status
                        </h2>
                        <label for="status" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Situação do Gestor <span class="text-red-500">*</span></label>
                        <select id="status" name="status" required
                            class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                            <option value="ativo" {{ old('status', $lider->status) === 'ativo' ? 'selected' : '' }}>Ativo / Operacional</option>
                            <option value="inativo" {{ old('status', $lider->status) === 'inativo' ? 'selected' : '' }}>Inativo / Suspenso</option>
                        </select>
                    </div>

                    <div>
                        <label for="observacoes" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Registros Administrativos</label>
                        <textarea id="observacoes" name="observacoes" rows="5"
                            class="w-full px-5 py-4 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-3xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white leading-relaxed"
                            placeholder="Notas importantes sobre este líder...">{{ old('observacoes', $lider->observacoes) }}</textarea>
                    </div>

                    <div class="pt-4 space-y-3">
                         <button type="submit" class="w-full inline-flex items-center justify-center gap-3 px-8 py-4 text-xs font-black uppercase tracking-widest text-white bg-blue-600 rounded-2xl hover:bg-blue-700 transition-all shadow-xl shadow-blue-500/20 active:scale-95 group">
                            <x-icon name="floppy-disk" style="duotone" class="w-5 h-5 group-hover:rotate-12 transition-transform" />
                            Salvar Alterações
                        </button>
                        <a href="{{ route('admin.lideres-comunidade.index') }}" class="w-full inline-flex items-center justify-center gap-2 px-8 py-4 text-xs font-black uppercase tracking-widest text-slate-500 hover:text-slate-900 transition-colors">
                            Desistir
                        </a>
                    </div>
                </div>

                <!-- Card de Ajuda -->
                <div class="bg-indigo-50 dark:bg-indigo-900/10 border border-indigo-100 dark:border-indigo-900/20 rounded-3xl p-6">
                    <div class="flex items-start gap-4">
                        <div class="p-3 bg-white dark:bg-slate-800 rounded-xl shadow-sm text-indigo-500">
                            <x-icon name="circle-info" style="duotone" class="w-6 h-6" />
                        </div>
                        <div>
                            <h4 class="text-xs font-black text-indigo-900 dark:text-indigo-300 uppercase tracking-widest mb-1">Dica de Gestão</h4>
                            <p class="text-[11px] text-indigo-700 dark:text-indigo-400/80 leading-relaxed font-bold uppercase tracking-tight">Vincular um usuário do sistema permite que o líder acesse seu próprio painel para gerenciar mensalidades.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const localidadeSelect = document.getElementById('localidade_id');
    const enderecoInput = document.getElementById('endereco');

    if (localidadeSelect && enderecoInput) {
        localidadeSelect.addEventListener('change', function() {
            const localidadeId = this.value;
            if (localidadeId) {
                fetch(`/localidades/${localidadeId}/dados`)
                .then(response => response.json())
                .then(data => {
                    let enderecoCompleto = data.endereco || '';
                    if (data.numero) enderecoCompleto += (enderecoCompleto ? ', ' : '') + data.numero;
                    if (data.complemento) enderecoCompleto += (enderecoCompleto ? ' - ' : '') + data.complemento;
                    if (data.bairro) enderecoCompleto += (enderecoCompleto ? ', ' : '') + data.bairro;
                    if (data.cidade) enderecoCompleto += (enderecoCompleto ? ' - ' : '') + data.cidade;
                    if (data.cep) enderecoCompleto += (enderecoCompleto ? ' - CEP: ' : '') + data.cep;
                    enderecoInput.value = enderecoCompleto || data.nome || '';
                });
            } else {
                enderecoInput.value = '';
            }
        });
    }
});
</script>
@endpush
@endsection
