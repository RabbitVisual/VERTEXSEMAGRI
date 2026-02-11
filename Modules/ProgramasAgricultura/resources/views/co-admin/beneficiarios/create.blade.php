@extends('Co-Admin.layouts.app')

@section('title', 'Novo Beneficiário - Agricultura')

@section('content')
<!-- Page Header -->
<div class="mb-8 pb-4 border-b border-gray-200 dark:border-slate-700">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <x-icon name="user-plus" class="w-8 h-8 text-indigo-600 dark:text-indigo-400" />
                Novo Beneficiário
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <a href="{{ route('co-admin.dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">Dashboard</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('co-admin.beneficiarios.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">Beneficiários</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white">Novo</span>
            </nav>
        </div>
        <div>
            <a href="{{ route('co-admin.beneficiarios.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border-2 border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                <x-icon name="arrow-left" class="w-5 h-5" />
                Voltar
            </a>
        </div>
    </div>
</div>

<div class="max-w-4xl">
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
        <form action="{{ route('co-admin.beneficiarios.store') }}" method="POST" class="p-6 md:p-8">
            @csrf

            <div class="space-y-6">
                <!-- Seleção de Pessoa e Programa -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b border-gray-100 dark:border-slate-700 pb-8 mb-8">
                    <div class="md:col-span-2">
                        <label for="pessoa_id" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2 italic">Cidadão / Produtor Rural <span class="text-red-500">*</span></label>
                        <!-- Aqui idealmente teria um select2 ou busca dinâmica, mas para o CRUD básico vamos usar o que temos -->
                        <select name="pessoa_id" id="pessoa_id" required
                                class="block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium">
                            <option value="">Selecione a pessoa...</option>
                            @foreach(\App\Models\Pessoa::orderBy('nom_pessoa')->limit(100)->get() as $pessoa)
                                <option value="{{ $pessoa->id_pessoa }}" {{ old('pessoa_id') == $pessoa->id_pessoa ? 'selected' : '' }}>
                                    {{ $pessoa->nom_pessoa }} ({{ $pessoa->num_cpf_pessoa }})
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500 italic">Pesquise pelo nome ou CPF.</p>
                        @error('pessoa_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="programa_id" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2 italic">Programa Relacionado <span class="text-red-500">*</span></label>
                        <select name="programa_id" id="programa_id" required
                                class="block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                            <option value="">Selecione o programa...</option>
                            @foreach($programas as $prog)
                                <option value="{{ $prog->id }}" {{ (old('programa_id') == $prog->id || request('programa_id') == $prog->id) ? 'selected' : '' }}>
                                    {{ $prog->nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('programa_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="localidade_id" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2 italic">Localidade de Atendimento <span class="text-red-500">*</span></label>
                        <select name="localidade_id" id="localidade_id" required
                                class="block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                            <option value="">Selecione a localidade...</option>
                            @foreach($localidades as $loc)
                                <option value="{{ $loc->id }}" {{ old('localidade_id') == $loc->id ? 'selected' : '' }}>{{ $loc->nome }}</option>
                            @endforeach
                        </select>
                        @error('localidade_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Datas e Status -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="data_inscricao" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2 italic">Data da Inscrição <span class="text-red-500">*</span></label>
                        <input type="date" name="data_inscricao" id="data_inscricao" value="{{ old('data_inscricao', date('Y-m-d')) }}" required
                               class="block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                        @error('data_inscricao') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2 italic">Status Inicial <span class="text-red-500">*</span></label>
                        <select name="status" id="status" required
                                class="block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                            <option value="inscrito" {{ old('status') == 'inscrito' ? 'selected' : '' }}>Inscrito</option>
                            <option value="aprovado" {{ old('status') == 'aprovado' ? 'selected' : '' }}>Aprovado / Ativo</option>
                            <option value="beneficiado" {{ old('status') == 'beneficiado' ? 'selected' : '' }}>Já Beneficiado</option>
                            <option value="rejeitado" {{ old('status') == 'rejeitado' ? 'selected' : '' }}>Rejeitado / Pendente</option>
                        </select>
                        @error('status') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="observacoes" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2 italic">Observações / Histórico</label>
                        <textarea name="observacoes" id="observacoes" rows="4"
                                  class="block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                                  placeholder="Notas sobre o atendimento, documentos entregues, etc...">{{ old('observacoes') }}</textarea>
                        @error('observacoes') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-gray-200 dark:border-slate-700 flex justify-end gap-3">
                <a href="{{ route('co-admin.beneficiarios.index') }}" class="px-6 py-2.5 rounded-lg border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors font-semibold">
                    Cancelar
                </a>
                <button type="submit" class="px-8 py-2.5 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 dark:shadow-none font-bold">
                    Cadastrar Beneficiário
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
