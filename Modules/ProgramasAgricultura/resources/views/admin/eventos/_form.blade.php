<div class="space-y-8 font-sans">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Coluna Principal -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-slate-700/50">
                <h3 class="text-[10px] font-black text-amber-600 uppercase tracking-widest mb-6 flex items-center gap-2 font-sans">
                    <x-icon name="calendar-day" class="w-4 h-4 font-sans" style="duotone" />
                    Identificação do Evento
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 italic font-sans italic tracking-tighter uppercase font-black text-[10px]">
                    <div class="md:col-span-2 font-sans italic tracking-tighter font-black text-[10px] uppercase">
                        <label for="titulo" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest italic tracking-tighter font-sans">Título da Capacitação / Evento</label>
                        <input type="text" name="titulo" id="titulo" value="{{ old('titulo', $evento->titulo ?? '') }}" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 dark:bg-slate-900/50 dark:border-slate-700 dark:text-white transition-all font-bold tracking-tight uppercase font-sans italic tracking-tighter font-black text-[10px] uppercase" required>
                    </div>

                    <div class="md:col-span-2 font-sans italic tracking-tighter font-black text-[10px] uppercase">
                        <label for="descricao" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest italic tracking-tighter font-sans">Objetivo e Ementa Técnica</label>
                        <textarea name="descricao" id="descricao" rows="3" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 dark:bg-slate-900/50 dark:border-slate-700 dark:text-white transition-all italic font-sans italic tracking-tighter font-black text-[10px] uppercase">{{ old('descricao', $evento->descricao ?? '') }}</textarea>
                    </div>

                    <div class="font-sans italic tracking-tighter font-black text-[10px] uppercase">
                        <label for="tipo" class="block mb-2 font-sans italic tracking-tighter font-black text-[10px] uppercase tracking-widest italic">Modalidade / Tipo</label>
                        <select name="tipo" id="tipo" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 dark:bg-slate-900/50 dark:border-slate-700 dark:text-white transition-all font-black uppercase tracking-widest text-[10px] font-sans" required>
                            <option value="capacitacao" {{ old('tipo', $evento->tipo ?? '') == 'capacitacao' ? 'selected' : '' }}>Capacitação</option>
                            <option value="palestra" {{ old('tipo', $evento->tipo ?? '') == 'palestra' ? 'selected' : '' }}>Palestra / Seminário</option>
                            <option value="feira" {{ old('tipo', $evento->tipo ?? '') == 'feira' ? 'selected' : '' }}>Feira Agrícola</option>
                            <option value="dia_campo" {{ old('tipo', $evento->tipo ?? '') == 'dia_campo' ? 'selected' : '' }}>Dia de Campo</option>
                            <option value="visita_tecnica" {{ old('tipo', $evento->tipo ?? '') == 'visita_tecnica' ? 'selected' : '' }}>Visita Técnica</option>
                            <option value="reuniao" {{ old('tipo', $evento->tipo ?? '') == 'reuniao' ? 'selected' : '' }}>Reunião Setorial</option>
                            <option value="outro" {{ old('tipo', $evento->tipo ?? '') == 'outro' ? 'selected' : '' }}>Outro</option>
                        </select>
                    </div>

                    <div class="font-sans italic tracking-tighter font-black text-[10px] uppercase">
                        <label for="instrutor_palestrante" class="block mb-2 font-sans italic tracking-tighter font-black text-[10px] uppercase tracking-widest italic italic">Instrutor / Responsável</label>
                        <input type="text" name="instrutor_palestrante" id="instrutor_palestrante" value="{{ old('instrutor_palestrante', $evento->instrutor_palestrante ?? '') }}" placeholder="Ex: Engenheiro Agrônomo XPTO" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 dark:bg-slate-900/50 dark:border-slate-700 dark:text-white transition-all font-bold tracking-tight uppercase font-sans">
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-slate-700/50 font-sans italic tracking-tighter font-black text-[10px] uppercase">
                <h3 class="text-[10px] font-black text-blue-600 uppercase tracking-widest mb-6 flex items-center gap-2 font-sans italic tracking-tighter font-black text-[10px] uppercase">
                    <x-icon name="map-location-dot" class="w-4 h-4 font-sans italic tracking-tighter font-black text-[10px] uppercase" style="duotone" />
                    Localização e Território
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 italic font-sans italic tracking-tighter font-black text-[10px] uppercase">
                    <div class="font-sans italic tracking-tighter font-black text-[10px] uppercase">
                        <label for="localidade_id" class="block mb-2 font-sans italic tracking-widest italic tracking-tighter font-black text-[10px] uppercase">Território / Comunidade</label>
                        <select name="localidade_id" id="localidade_id" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 dark:bg-slate-900/50 dark:border-slate-700 dark:text-white transition-all font-black uppercase tracking-widest text-[10px] font-sans italic tracking-tighter font-black text-[10px] uppercase">
                            <option value="">Selecione o Local...</option>
                            @foreach($localidades as $loc)
                                <option value="{{ $loc->id }}" {{ old('localidade_id', $evento->localidade_id ?? '') == $loc->id ? 'selected' : '' }}>{{ $loc->nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="font-sans italic tracking-tighter font-black text-[10px] uppercase">
                        <label for="endereco" class="block mb-2 font-sans italic tracking-tighter font-black text-[10px] uppercase tracking-widest italic italic">Endereço / Referência</label>
                        <input type="text" name="endereco" id="endereco" value="{{ old('endereco', $evento->endereco ?? '') }}" placeholder="Ex: Pátio da Igreja, Sede da Associação..." class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 dark:bg-slate-900/50 dark:border-slate-700 dark:text-white transition-all font-bold tracking-tight uppercase font-sans">
                    </div>
                </div>
            </div>
        </div>

        <!-- Coluna Lateral -->
        <div class="space-y-6 font-sans italic tracking-tighter font-black text-[10px] uppercase">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-slate-700/50 italic tracking-tighter font-black text-[10px] uppercase">
                <h3 class="text-[10px] font-black text-emerald-600 uppercase tracking-widest mb-6 flex items-center gap-2 font-sans italic tracking-tighter font-black text-[10px] uppercase">
                    <x-icon name="calendar-days" class="w-4 h-4 font-sans italic tracking-tighter font-black text-[10px] uppercase" style="duotone" />
                    Cronograma e Vagas
                </h3>
                <div class="space-y-5 italic font-sans italic tracking-tighter uppercase font-black text-[10px]">
                    <div class="font-sans italic tracking-tighter font-black text-[10px] uppercase">
                        <label for="status" class="block mb-2 font-sans italic tracking-widest italic tracking-tighter font-black text-[10px] uppercase">Estado da Agenda</label>
                        <select name="status" id="status" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 dark:bg-slate-900/50 dark:border-slate-700 dark:text-white transition-all font-black uppercase tracking-widest text-[10px] font-sans italic tracking-tighter font-black text-[10px] uppercase" required>
                            <option value="agendado" {{ old('status', $evento->status ?? '') == 'agendado' ? 'selected' : '' }}>Agendado / Planejado</option>
                            <option value="em_andamento" {{ old('status', $evento->status ?? '') == 'em_andamento' ? 'selected' : '' }}>Em Execução</option>
                            <option value="concluido" {{ old('status', $evento->status ?? '') == 'concluido' ? 'selected' : '' }}>Finalizado</option>
                            <option value="cancelado" {{ old('status', $evento->status ?? '') == 'cancelado' ? 'selected' : '' }}>Cancelado / Adiado</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4 font-sans italic tracking-tighter font-black text-[10px] uppercase">
                        <div>
                            <label for="data_inicio" class="block mb-2 font-sans italic uppercase italic">Data</label>
                            <input type="date" name="data_inicio" id="data_inicio" value="{{ old('data_inicio', isset($evento->data_inicio) ? $evento->data_inicio->format('Y-m-d') : '') }}" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-xs rounded-xl focus:ring-amber-500 focus:border-amber-500 dark:bg-slate-900/50 dark:border-slate-700 dark:text-white font-black italic tracking-tighter font-sans" required>
                        </div>
                        <div>
                            <label for="hora_inicio" class="block mb-2 font-sans italic uppercase italic tracking-tighter">Horário</label>
                            <input type="time" name="hora_inicio" id="hora_inicio" value="{{ old('hora_inicio', isset($evento->hora_inicio) ? \Carbon\Carbon::parse($evento->hora_inicio)->format('H:i') : '') }}" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-xs rounded-xl focus:ring-amber-500 focus:border-amber-500 dark:bg-slate-900/50 dark:border-slate-700 dark:text-white font-black italic tracking-tighter font-sans" required>
                        </div>
                    </div>

                    <div class="font-sans italic tracking-tighter font-black text-[10px] uppercase">
                        <label for="vagas_totais" class="block mb-2 font-sans italic uppercase italic tracking-tighter">Cota de Participantes</label>
                        <div class="relative font-sans italic tracking-tighter font-black text-[10px] uppercase">
                             <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none font-sans italic tracking-tighter font-black text-[10px] uppercase">
                                <x-icon name="users" class="w-4 h-4 text-gray-400 font-sans italic" />
                            </div>
                            <input type="number" name="vagas_totais" id="vagas_totais" value="{{ old('vagas_totais', $evento->vagas_totais ?? '') }}" placeholder="Ilimitado se vazio" class="block w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 text-sm rounded-xl focus:ring-amber-500 focus:border-amber-500 dark:bg-slate-900/50 dark:border-slate-700 dark:text-white font-black italic tracking-tighter uppercase italic font-sans">
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-slate-700/50 font-sans italic tracking-tighter font-black text-[10px] uppercase">
                <h3 class="text-[10px] font-black text-purple-600 uppercase tracking-widest mb-6 flex items-center gap-2 font-sans italic tracking-tighter font-black text-[10px] uppercase">
                    <x-icon name="globe" class="w-4 h-4 font-sans italic tracking-tighter font-black text-[10px] uppercase" style="duotone" />
                    Fluxo de Inscrição
                </h3>
                <div class="space-y-4 font-sans italic tracking-tighter font-black text-[10px] uppercase">
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-slate-900/50 rounded-2xl italic tracking-tighter font-black text-[10px] uppercase font-sans">
                        <div class="font-sans italic tracking-tighter font-black text-[10px] uppercase">
                            <p class="text-xs font-black text-gray-900 dark:text-white italic tracking-tighter font-black text-[10px] uppercase">Inscrições</p>
                            <p class="text-[10px] text-gray-500 italic font-sans tracking-tighter font-black text-[10px] uppercase">Habilitar no Site?</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer font-sans italic tracking-tighter font-black text-[10px] uppercase">
                            <input type="checkbox" name="inscricao_aberta" value="1" class="sr-only peer" {{ old('inscricao_aberta', $evento->inscricao_aberta ?? true) ? 'checked' : '' }}>
                            <div class="w-12 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-amber-600 shadow-inner italic font-sans italic tracking-tighter font-black text-[10px] uppercase"></div>
                        </label>
                    </div>

                    <div class="font-sans italic tracking-tighter font-black text-[10px] uppercase">
                        <label for="data_limite_inscricao" class="block mb-2 font-sans italic tracking-widest italic tracking-tighter font-black text-[10px] uppercase">Prazo Limite para Inscrição</label>
                        <input type="date" name="data_limite_inscricao" id="data_limite_inscricao" value="{{ old('data_limite_inscricao', isset($evento->data_limite_inscricao) ? $evento->data_limite_inscricao->format('Y-m-d') : '') }}" class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 text-xs rounded-xl focus:ring-amber-500 focus:border-amber-500 dark:bg-slate-900/50 dark:border-slate-700 dark:text-white font-black italic tracking-tighter font-sans uppercase">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
