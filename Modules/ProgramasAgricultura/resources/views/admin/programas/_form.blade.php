<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="nome" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nome do Programa <span class="text-red-500">*</span></label>
            <input type="text" id="nome" name="nome" value="{{ old('nome', $programa->nome ?? '') }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500 {{ $errors->has('nome') ? 'border-red-500 dark:border-red-500' : '' }}">
            @error('nome')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="tipo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo <span class="text-red-500">*</span></label>
            <select id="tipo" name="tipo" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500 {{ $errors->has('tipo') ? 'border-red-500 dark:border-red-500' : '' }}">
                <option value="">Selecione...</option>
                <option value="governo_federal" {{ old('tipo', $programa->tipo ?? '') == 'governo_federal' ? 'selected' : '' }}>Governo Federal</option>
                <option value="governo_estadual" {{ old('tipo', $programa->tipo ?? '') == 'governo_estadual' ? 'selected' : '' }}>Governo Estadual</option>
                <option value="governo_municipal" {{ old('tipo', $programa->tipo ?? '') == 'governo_municipal' ? 'selected' : '' }}>Governo Municipal</option>
                <option value="parceria" {{ old('tipo', $programa->tipo ?? '') == 'parceria' ? 'selected' : '' }}>Parceria</option>
                <option value="outro" {{ old('tipo', $programa->tipo ?? '') == 'outro' ? 'selected' : '' }}>Outro</option>
            </select>
            @error('tipo')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="descricao" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descrição</label>
        <textarea id="descricao" name="descricao" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500 {{ $errors->has('descricao') ? 'border-red-500 dark:border-red-500' : '' }}">{{ old('descricao', $programa->descricao ?? '') }}</textarea>
        @error('descricao')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status <span class="text-red-500">*</span></label>
            <select id="status" name="status" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500 {{ $errors->has('status') ? 'border-red-500 dark:border-red-500' : '' }}">
                <option value="ativo" {{ old('status', $programa->status ?? 'ativo') == 'ativo' ? 'selected' : '' }}>Ativo</option>
                <option value="suspenso" {{ old('status', $programa->status ?? '') == 'suspenso' ? 'selected' : '' }}>Suspenso</option>
                <option value="encerrado" {{ old('status', $programa->status ?? '') == 'encerrado' ? 'selected' : '' }}>Encerrado</option>
            </select>
            @error('status')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="orgao_responsavel" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Órgão Responsável</label>
            <input type="text" id="orgao_responsavel" name="orgao_responsavel" value="{{ old('orgao_responsavel', $programa->orgao_responsavel ?? '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500 {{ $errors->has('orgao_responsavel') ? 'border-red-500 dark:border-red-500' : '' }}">
            @error('orgao_responsavel')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label for="data_inicio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Data de Início</label>
            <input type="date" id="data_inicio" name="data_inicio" value="{{ old('data_inicio', isset($programa) && $programa->data_inicio ? $programa->data_inicio->format('Y-m-d') : '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500 {{ $errors->has('data_inicio') ? 'border-red-500 dark:border-red-500' : '' }}">
            @error('data_inicio')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="data_fim" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Data de Término</label>
            <input type="date" id="data_fim" name="data_fim" value="{{ old('data_fim', isset($programa) && $programa->data_fim ? $programa->data_fim->format('Y-m-d') : '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500 {{ $errors->has('data_fim') ? 'border-red-500 dark:border-red-500' : '' }}">
            @error('data_fim')
                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="vagas_disponiveis" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Vagas Disponíveis</label>
        <input type="number" id="vagas_disponiveis" name="vagas_disponiveis" value="{{ old('vagas_disponiveis', $programa->vagas_disponiveis ?? '') }}" min="0" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500 {{ $errors->has('vagas_disponiveis') ? 'border-red-500 dark:border-red-500' : '' }}">
        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Deixe em branco para vagas ilimitadas</p>
        @error('vagas_disponiveis')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="requisitos" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Requisitos</label>
        <textarea id="requisitos" name="requisitos" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500 {{ $errors->has('requisitos') ? 'border-red-500 dark:border-red-500' : '' }}">{{ old('requisitos', $programa->requisitos ?? '') }}</textarea>
        @error('requisitos')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="documentos_necessarios" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Documentos Necessários</label>
        <textarea id="documentos_necessarios" name="documentos_necessarios" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500 {{ $errors->has('documentos_necessarios') ? 'border-red-500 dark:border-red-500' : '' }}">{{ old('documentos_necessarios', $programa->documentos_necessarios ?? '') }}</textarea>
        @error('documentos_necessarios')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="beneficios" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Benefícios</label>
        <textarea id="beneficios" name="beneficios" rows="4" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500 {{ $errors->has('beneficios') ? 'border-red-500 dark:border-red-500' : '' }}">{{ old('beneficios', $programa->beneficios ?? '') }}</textarea>
        @error('beneficios')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="observacoes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Observações</label>
        <textarea id="observacoes" name="observacoes" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500 {{ $errors->has('observacoes') ? 'border-red-500 dark:border-red-500' : '' }}">{{ old('observacoes', $programa->observacoes ?? '') }}</textarea>
        @error('observacoes')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center">
        <input type="checkbox" id="publico" name="publico" value="1" {{ old('publico', $programa->publico ?? false) ? 'checked' : '' }} class="w-4 h-4 text-amber-600 bg-gray-100 border-gray-300 rounded focus:ring-amber-500 dark:focus:ring-amber-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600">
        <label for="publico" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Tornar programa público (visível no portal)</label>
    </div>

    <div class="mt-8 flex gap-4">
        <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-medium text-white bg-amber-600 rounded-lg hover:bg-amber-700 focus:ring-4 focus:ring-amber-300 dark:bg-amber-600 dark:hover:bg-amber-700 dark:focus:ring-amber-800 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
            </svg>
            {{ isset($programa) && $programa ? 'Salvar Alterações' : 'Criar Programa' }}
        </button>
        <a href="{{ isset($programa) && $programa ? route('admin.programas.show', $programa->id) : route('admin.programas.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
            Cancelar
        </a>
    </div>
</div>

