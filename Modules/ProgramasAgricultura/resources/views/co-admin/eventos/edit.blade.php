@extends('Co-Admin.layouts.app')

@section('title', 'Editar Evento - Agricultura')

@section('content')
<!-- Page Header -->
<div class="mb-8 pb-4 border-b border-gray-200 dark:border-slate-700">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <x-icon name="pencil" class="w-8 h-8 text-indigo-600 dark:text-indigo-400" />
                Editar Evento / Curso
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <a href="{{ route('co-admin.dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">Dashboard</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('co-admin.eventos.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">Eventos</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white italic">{{ $evento->titulo }}</span>
            </nav>
        </div>
        <div>
            <a href="{{ route('co-admin.eventos.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border-2 border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                <x-icon name="arrow-left" class="w-5 h-5" />
                Voltar
            </a>
        </div>
    </div>
</div>

<div class="max-w-4xl">
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
        <form action="{{ route('co-admin.eventos.update', $evento->id) }}" method="POST" class="p-6 md:p-8">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Informações Básicas -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="titulo" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2 italic">Título do Evento <span class="text-red-500">*</span></label>
                        <input type="text" name="titulo" id="titulo" value="{{ old('titulo', $evento->titulo) }}" required
                               class="block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium">
                        @error('titulo') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="descricao" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2 italic">Descrição / Conteúdo</label>
                        <textarea name="descricao" id="descricao" rows="4"
                                  class="block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">{{ old('descricao', $evento->descricao) }}</textarea>
                        @error('descricao') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="tipo" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2 italic">Tipo de Evento <span class="text-red-500">*</span></label>
                        <select name="tipo" id="tipo" required
                                class="block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                            <option value="capacitacao" {{ old('tipo', $evento->tipo) == 'capacitacao' ? 'selected' : '' }}>Capacitação/Curso</option>
                            <option value="palestra" {{ old('tipo', $evento->tipo) == 'palestra' ? 'selected' : '' }}>Palestra</option>
                            <option value="feira" {{ old('tipo', $evento->tipo) == 'feira' ? 'selected' : '' }}>Feira/Exposição</option>
                            <option value="workshop" {{ old('tipo', $evento->tipo) == 'workshop' ? 'selected' : '' }}>Workshop</option>
                            <option value="outro" {{ old('tipo', $evento->tipo) == 'outro' ? 'selected' : '' }}>Outro</option>
                        </select>
                        @error('tipo') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="localidade_id" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2 italic">Localidade</label>
                        <select name="localidade_id" id="localidade_id"
                                class="block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                            <option value="">Selecione a Localidade...</option>
                            @foreach($localidades as $loc)
                                <option value="{{ $loc->id }}" {{ old('localidade_id', $evento->localidade_id) == $loc->id ? 'selected' : '' }}>{{ $loc->nome }}</option>
                            @endforeach
                        </select>
                        @error('localidade_id') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="endereco" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2 italic">Endereço Detalhado / Ponto de Referência</label>
                        <input type="text" name="endereco" id="endereco" value="{{ old('endereco', $evento->endereco) }}"
                               class="block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                        @error('endereco') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="data_inicio" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2 italic">Data e Hora de Início <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="data_inicio" id="data_inicio" value="{{ old('data_inicio', $evento->data_inicio ? $evento->data_inicio->format('Y-m-d\TH:i') : '') }}" required
                               class="block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                        @error('data_inicio') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="data_fim" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2 italic">Data e Hora de Término</label>
                        <input type="datetime-local" name="data_fim" id="data_fim" value="{{ old('data_fim', $evento->data_fim ? $evento->data_fim->format('Y-m-d\TH:i') : '') }}"
                               class="block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                        @error('data_fim') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="vagas_totais" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2 italic">Limite de Vagas (0 = Ilimitado)</label>
                        <input type="number" name="vagas_totais" id="vagas_totais" value="{{ old('vagas_totais', $evento->vagas_totais) }}" min="0"
                               class="block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                        @error('vagas_totais') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 dark:text-slate-300 mb-2 italic">Status <span class="text-red-500">*</span></label>
                        <select name="status" id="status" required
                                class="block w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                            <option value="agendado" {{ old('status', $evento->status) == 'agendado' ? 'selected' : '' }}>Agendado</option>
                            <option value="em_andamento" {{ old('status', $evento->status) == 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                            <option value="concluido" {{ old('status', $evento->status) == 'concluido' ? 'selected' : '' }}>Concluído</option>
                            <option value="cancelado" {{ old('status', $evento->status) == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                        @error('status') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex flex-col gap-4">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="publico" value="1" class="sr-only peer" {{ old('publico', $evento->publico) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
                            <span class="ml-3 text-sm font-semibold text-gray-700 dark:text-slate-300 uppercase tracking-wider">Evento Público</span>
                        </label>

                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="inscricao_aberta" value="1" class="sr-only peer" {{ old('inscricao_aberta', $evento->inscricao_aberta) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
                            <span class="ml-3 text-sm font-semibold text-gray-700 dark:text-slate-300 uppercase tracking-wider">Inscrições Abertas</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-gray-200 dark:border-slate-700 flex justify-end gap-3">
                <a href="{{ route('co-admin.eventos.index') }}" class="px-6 py-2.5 rounded-lg border border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors font-semibold">
                    Cancelar
                </a>
                <button type="submit" class="px-8 py-2.5 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 dark:shadow-none font-bold">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
