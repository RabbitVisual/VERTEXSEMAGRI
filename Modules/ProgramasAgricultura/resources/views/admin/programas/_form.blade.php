<div class="space-y-8 font-sans">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Coluna Principal -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-slate-700/50">
                <h3 class="text-[10px] font-black text-amber-600 uppercase tracking-widest mb-6 flex items-center gap-2">
                    <x-icon name="clipboard-list" class="w-4 h-4" style="duotone" />
                    Informações Centrais
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 italic">
                    <div class="md:col-span-2">
                        <label for="nome" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest italic">Título do Programa</label>
                        <input type="text" name="nome" id="nome" value="{{ old('nome', $programa->nome ?? '') }}" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 dark:bg-slate-900/50 dark:border-slate-700 dark:text-white transition-all font-bold tracking-tight uppercase" required>
                    </div>

                    <div class="md:col-span-2">
                        <label for="descricao" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest italic tracking-tighter">Descrição e Objetivos Estratégicos</label>
                        <textarea name="descricao" id="descricao" rows="4" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 dark:bg-slate-900/50 dark:border-slate-700 dark:text-white transition-all italic">{{ old('descricao', $programa->descricao ?? '') }}</textarea>
                    </div>

                    <div>
                        <label for="tipo" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest italic tracking-tighter">Segmentação / Tipo</label>
                        <select name="tipo" id="tipo" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 dark:bg-slate-900/50 dark:border-slate-700 dark:text-white transition-all font-black uppercase tracking-widest text-[10px]" required>
                            <option value="seguro_safra" {{ old('tipo', $programa->tipo ?? '') == 'seguro_safra' ? 'selected' : '' }}>Seguro Safra</option>
                            <option value="pronaf" {{ old('tipo', $programa->tipo ?? '') == 'pronaf' ? 'selected' : '' }}>PRONAF</option>
                            <option value="distribuicao_sementes" {{ old('tipo', $programa->tipo ?? '') == 'distribuicao_sementes' ? 'selected' : '' }}>Distribuição de Sementes</option>
                            <option value="assistencia_tecnica" {{ old('tipo', $programa->tipo ?? '') == 'assistencia_tecnica' ? 'selected' : '' }}>Assistência Técnica</option>
                            <option value="credito_rural" {{ old('tipo', $programa->tipo ?? '') == 'credito_rural' ? 'selected' : '' }}>Crédito Rural</option>
                            <option value="outro" {{ old('tipo', $programa->tipo ?? '') == 'outro' ? 'selected' : '' }}>Outro</option>
                        </select>
                    </div>

                    <div>
                        <label for="orgao_responsavel" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest italic tracking-tighter">Órgão Gestor Responsável</label>
                        <input type="text" name="orgao_responsavel" id="orgao_responsavel" value="{{ old('orgao_responsavel', $programa->orgao_responsavel ?? 'Secretaria de Agricultura') }}" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 dark:bg-slate-900/50 dark:border-slate-700 dark:text-white transition-all font-bold tracking-tight uppercase">
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-slate-700/50">
                <h3 class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-6 flex items-center gap-2">
                    <x-icon name="file-contract" class="w-4 h-4" style="duotone" />
                    Regras e Requisitos Técnicos
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 italic">
                    <div class="md:col-span-2">
                        <label for="requisitos" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest italic tracking-tighter font-sans uppercase">Requisitos de Elegibilidade</label>
                        <textarea name="requisitos" id="requisitos" rows="3" placeholder="O que o produtor precisa ter para participar?" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 dark:bg-slate-900/50 dark:border-slate-700 dark:text-white transition-all italic">{{ old('requisitos', $programa->requisitos ?? '') }}</textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label for="documentos_necessarios" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest italic tracking-tighter font-sans uppercase uppercase italic">Documentação Obrigatória</label>
                        <textarea name="documentos_necessarios" id="documentos_necessarios" rows="3" placeholder="Ex: CAF, RG, CPF, ITR..." class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 dark:bg-slate-900/50 dark:border-slate-700 dark:text-white transition-all italic">{{ old('documentos_necessarios', $programa->documentos_necessarios ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Coluna Lateral -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-slate-700/50">
                <h3 class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-6 flex items-center gap-2">
                    <x-icon name="calendar-range" class="w-4 h-4 font-sans" style="duotone" />
                    Vigência e Vagas
                </h3>
                <div class="space-y-5 italic font-sans italic tracking-tighter uppercase font-black text-[10px]">
                    <div>
                        <label for="status" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest italic tracking-tighter font-sans">Estado Operacional</label>
                        <select name="status" id="status" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 dark:bg-slate-900/50 dark:border-slate-700 dark:text-white transition-all font-black uppercase tracking-widest text-[10px]" required>
                            <option value="ativo" {{ old('status', $programa->status ?? '') == 'ativo' ? 'selected' : '' }}>Operação Ativa</option>
                            <option value="suspenso" {{ old('status', $programa->status ?? '') == 'suspenso' ? 'selected' : '' }}>Suspenso Temporário</option>
                            <option value="encerrado" {{ old('status', $programa->status ?? '') == 'encerrado' ? 'selected' : '' }}>Encerrado / Inativo</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="data_inicio" class="block mb-2 font-sans italic">Início</label>
                            <input type="date" name="data_inicio" id="data_inicio" value="{{ old('data_inicio', isset($programa->data_inicio) ? $programa->data_inicio->format('Y-m-d') : '') }}" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-xs rounded-xl focus:ring-amber-500 focus:border-amber-500 dark:bg-slate-900/50 dark:border-slate-700 dark:text-white font-black italic tracking-tighter">
                        </div>
                        <div>
                            <label for="data_fim" class="block mb-2 font-sans italic">Término</label>
                            <input type="date" name="data_fim" id="data_fim" value="{{ old('data_fim', isset($programa->data_fim) ? $programa->data_fim->format('Y-m-d') : '') }}" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-xs rounded-xl focus:ring-amber-500 focus:border-amber-500 dark:bg-slate-900/50 dark:border-slate-700 dark:text-white font-black italic tracking-tighter">
                        </div>
                    </div>

                    <div>
                        <label for="vagas_disponiveis" class="block mb-2 font-sans italic uppercase italic">Cota de Vagas</label>
                        <div class="relative font-sans italic tracking-tighter font-black text-[10px] uppercase">
                             <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none font-sans italic tracking-tighter font-black text-[10px] uppercase">
                                <x-icon name="users" class="w-4 h-4 text-gray-400 font-sans italic" />
                            </div>
                            <input type="number" name="vagas_disponiveis" id="vagas_disponiveis" value="{{ old('vagas_disponiveis', $programa->vagas_disponiveis ?? '') }}" placeholder="Ilimitado se vazio" class="block w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 dark:bg-slate-900/50 dark:border-slate-700 dark:text-white font-black italic tracking-tighter uppercase italic">
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-slate-700/50 italic tracking-tighter font-black text-[10px] uppercase font-sans">
                <h3 class="text-[10px] font-black text-purple-600 uppercase tracking-widest mb-6 flex items-center gap-2 italic tracking-tighter font-black text-[10px] uppercase font-sans">
                    <x-icon name="eye" class="w-4 h-4 italic tracking-tighter font-black text-[10px] uppercase font-sans" style="duotone" />
                    Portal da Transparência
                </h3>
                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-900/50 rounded-2xl italic tracking-tighter font-black text-[10px] uppercase font-sans">
                    <div class="italic tracking-tighter font-black text-[10px] uppercase font-sans">
                        <p class="text-xs font-black text-gray-900 dark:text-white italic tracking-tighter font-black text-[10px] uppercase">Visibilidade</p>
                        <p class="text-[10px] text-gray-500 italic tracking-tighter font-black text-[10px] uppercase">Aparece para o produtor?</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer font-sans italic tracking-tighter font-black text-[10px] uppercase">
                        <input type="checkbox" name="publico" value="1" class="sr-only peer" {{ old('publico', $programa->publico ?? true) ? 'checked' : '' }}>
                        <div class="w-12 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-amber-600 shadow-inner italic font-sans tracking-tighter font-black text-[10px] uppercase"></div>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
