<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="titulo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Título do Evento <span class="text-red-500">*</span></label>
            <input type="text" id="titulo" name="titulo" value="{{ old('titulo', $evento->titulo ?? '') }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500 {{ $errors->has('titulo') ? 'border-red-500 dark:border-red-500' : '' }}">
            @error('titulo')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="tipo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo <span class="text-red-500">*</span></label>
            <select id="tipo" name="tipo" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500 {{ $errors->has('tipo') ? 'border-red-500 dark:border-red-500' : '' }}">
                <option value="">Selecione...</option>
                <option value="capacitacao" {{ old('tipo', $evento->tipo ?? '') == 'capacitacao' ? 'selected' : '' }}>Capacitação</option>
                <option value="palestra" {{ old('tipo', $evento->tipo ?? '') == 'palestra' ? 'selected' : '' }}>Palestra</option>
                <option value="feira" {{ old('tipo', $evento->tipo ?? '') == 'feira' ? 'selected' : '' }}>Feira</option>
                <option value="workshop" {{ old('tipo', $evento->tipo ?? '') == 'workshop' ? 'selected' : '' }}>Workshop</option>
                <option value="outro" {{ old('tipo', $evento->tipo ?? '') == 'outro' ? 'selected' : '' }}>Outro</option>
            </select>
            @error('tipo')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="descricao" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descrição</label>
        <textarea id="descricao" name="descricao" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500 {{ $errors->has('descricao') ? 'border-red-500 dark:border-red-500' : '' }}">{{ old('descricao', $evento->descricao ?? '') }}</textarea>
        @error('descricao')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="data_inicio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Data de Início <span class="text-red-500">*</span></label>
            <input type="date" id="data_inicio" name="data_inicio" value="{{ old('data_inicio', isset($evento) && $evento->data_inicio ? $evento->data_inicio->format('Y-m-d') : '') }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500 {{ $errors->has('data_inicio') ? 'border-red-500 dark:border-red-500' : '' }}">
            @error('data_inicio')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="data_fim" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Data de Término</label>
            <input type="date" id="data_fim" name="data_fim" value="{{ old('data_fim', isset($evento) && $evento->data_fim ? $evento->data_fim->format('Y-m-d') : '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500 {{ $errors->has('data_fim') ? 'border-red-500 dark:border-red-500' : '' }}">
            @error('data_fim')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="hora_inicio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hora de Início</label>
            <input type="time" id="hora_inicio" name="hora_inicio" value="{{ old('hora_inicio', isset($evento) && $evento->hora_inicio ? $evento->hora_inicio->format('H:i') : '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500 {{ $errors->has('hora_inicio') ? 'border-red-500 dark:border-red-500' : '' }}">
            @error('hora_inicio')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="hora_fim" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hora de Término</label>
            <input type="time" id="hora_fim" name="hora_fim" value="{{ old('hora_fim', isset($evento) && $evento->hora_fim ? $evento->hora_fim->format('H:i') : '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500 {{ $errors->has('hora_fim') ? 'border-red-500 dark:border-red-500' : '' }}">
            @error('hora_fim')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="localidade_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Localidade</label>
            <select id="localidade_id" name="localidade_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500 {{ $errors->has('localidade_id') ? 'border-red-500 dark:border-red-500' : '' }}">
                <option value="">Selecione...</option>
                @foreach($localidades as $localidade)
                    <option value="{{ $localidade->id }}" {{ old('localidade_id', $evento->localidade_id ?? '') == $localidade->id ? 'selected' : '' }}>{{ $localidade->nome }}</option>
                @endforeach
            </select>
            @error('localidade_id')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status <span class="text-red-500">*</span></label>
            <select id="status" name="status" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500 {{ $errors->has('status') ? 'border-red-500 dark:border-red-500' : '' }}">
                <option value="agendado" {{ old('status', $evento->status ?? 'agendado') == 'agendado' ? 'selected' : '' }}>Agendado</option>
                <option value="em_andamento" {{ old('status', $evento->status ?? '') == 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                <option value="concluido" {{ old('status', $evento->status ?? '') == 'concluido' ? 'selected' : '' }}>Concluído</option>
                <option value="cancelado" {{ old('status', $evento->status ?? '') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
            </select>
            @error('status')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="endereco" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Endereço</label>
        <input type="text" id="endereco" name="endereco" value="{{ old('endereco', $evento->endereco ?? '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500 {{ $errors->has('endereco') ? 'border-red-500 dark:border-red-500' : '' }}">
        @error('endereco')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="vagas_totais" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Vagas Totais</label>
        <input type="number" id="vagas_totais" name="vagas_totais" value="{{ old('vagas_totais', $evento->vagas_totais ?? '') }}" min="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500 {{ $errors->has('vagas_totais') ? 'border-red-500 dark:border-red-500' : '' }}">
        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Deixe em branco para vagas ilimitadas</p>
        @error('vagas_totais')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="publico_alvo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Público-Alvo</label>
        <input type="text" id="publico_alvo" name="publico_alvo" value="{{ old('publico_alvo', $evento->publico_alvo ?? '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500 {{ $errors->has('publico_alvo') ? 'border-red-500 dark:border-red-500' : '' }}">
        @error('publico_alvo')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="conteudo_programatico" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Conteúdo Programático</label>
        <textarea id="conteudo_programatico" name="conteudo_programatico" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500 {{ $errors->has('conteudo_programatico') ? 'border-red-500 dark:border-red-500' : '' }}">{{ old('conteudo_programatico', $evento->conteudo_programatico ?? '') }}</textarea>
        @error('conteudo_programatico')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="instrutor_palestrante" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Instrutor/Palestrante</label>
        <input type="text" id="instrutor_palestrante" name="instrutor_palestrante" value="{{ old('instrutor_palestrante', $evento->instrutor_palestrante ?? '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500 {{ $errors->has('instrutor_palestrante') ? 'border-red-500 dark:border-red-500' : '' }}">
        @error('instrutor_palestrante')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="materiais_necessarios" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Materiais Necessários</label>
        <textarea id="materiais_necessarios" name="materiais_necessarios" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500 {{ $errors->has('materiais_necessarios') ? 'border-red-500 dark:border-red-500' : '' }}">{{ old('materiais_necessarios', $evento->materiais_necessarios ?? '') }}</textarea>
        @error('materiais_necessarios')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="data_limite_inscricao" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Data Limite para Inscrição</label>
        <input type="date" id="data_limite_inscricao" name="data_limite_inscricao" value="{{ old('data_limite_inscricao', isset($evento) && $evento->data_limite_inscricao ? $evento->data_limite_inscricao->format('Y-m-d') : '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500 {{ $errors->has('data_limite_inscricao') ? 'border-red-500 dark:border-red-500' : '' }}">
        @error('data_limite_inscricao')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="observacoes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Observações</label>
        <textarea id="observacoes" name="observacoes" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500 {{ $errors->has('observacoes') ? 'border-red-500 dark:border-red-500' : '' }}">{{ old('observacoes', $evento->observacoes ?? '') }}</textarea>
        @error('observacoes')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center gap-6">
        <div class="flex items-center">
            <input type="checkbox" id="publico" name="publico" value="1" {{ old('publico', $evento->publico ?? false) ? 'checked' : '' }} class="w-4 h-4 text-yellow-600 bg-gray-100 border-gray-300 rounded focus:ring-yellow-500 dark:focus:ring-yellow-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600">
            <label for="publico" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Tornar evento público (visível no portal)</label>
        </div>
        <div class="flex items-center">
            <input type="checkbox" id="inscricao_aberta" name="inscricao_aberta" value="1" {{ old('inscricao_aberta', $evento->inscricao_aberta ?? false) ? 'checked' : '' }} class="w-4 h-4 text-yellow-600 bg-gray-100 border-gray-300 rounded focus:ring-yellow-500 dark:focus:ring-yellow-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600">
            <label for="inscricao_aberta" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Inscrições abertas</label>
        </div>
    </div>

    <div class="mt-8 flex gap-4">
        <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-medium text-white bg-yellow-600 rounded-lg hover:bg-yellow-700 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
            </svg>
            {{ isset($evento) && $evento ? 'Salvar Alterações' : 'Criar Evento' }}
        </button>
        <a href="{{ isset($evento) && $evento ? route('admin.eventos.show', $evento->id) : route('admin.eventos.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
            Cancelar
        </a>
    </div>
</div>

