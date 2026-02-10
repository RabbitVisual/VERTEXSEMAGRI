@extends('admin.layouts.admin')

@section('title', 'Configurações do Chat')

@section('content')
<div class="space-y-8 animate__animated animate__fadeIn">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6">
        <div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/20 transform hover:rotate-6 transition-transform">
                    <x-icon module="chat" class="w-7 h-7 text-white" style="duotone" />
                </div>
                <div>
                    <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">Configurações</h1>
                    <p class="text-slate-500 dark:text-slate-400 font-medium">Personalize o comportamento e funcionamento do chat.</p>
                </div>
            </div>

            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-3 h-3" />
                <a href="{{ route('admin.chat.index') }}" class="hover:text-blue-600 transition-colors">Chat</a>
                <x-icon name="chevron-right" class="w-3 h-3" />
                <span class="text-slate-600 dark:text-slate-300">Ajustes</span>
            </nav>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.chat.index') }}" class="inline-flex items-center gap-2 px-5 py-3 text-sm font-bold text-slate-700 bg-white border border-slate-200 rounded-2xl hover:bg-slate-50 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700 dark:hover:bg-slate-700 transition-all shadow-sm active:scale-95">
                <x-icon name="arrow-left" style="duotone" class="w-4 h-4 text-slate-400" />
                Voltar
            </a>
        </div>
    </div>

    <form action="{{ route('admin.chat.config.update') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        @csrf
        @method('PUT')

        <div class="lg:col-span-8 space-y-8">
            <!-- Configurações Gerais -->
            <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="px-8 py-5 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/50">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                        <x-icon name="sliders" style="duotone" class="w-4 h-4 text-blue-500" />
                        Ajustes Gerais
                    </h3>
                </div>
                <div class="p-8 space-y-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="flex items-center justify-between p-6 bg-slate-50 dark:bg-slate-900/50 rounded-3xl border border-transparent hover:border-blue-100 dark:hover:border-blue-900/30 transition-all group">
                            <div>
                                <label class="block text-sm font-black text-slate-900 dark:text-white uppercase tracking-tight">Chat Habilitado</label>
                                <p class="text-xs text-slate-500 font-medium mt-1">Status global do serviço</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="chat_enabled" value="1" class="sr-only peer" {{ ($configs['chat_enabled']->value ?? 'true') === 'true' ? 'checked' : '' }}>
                                <div class="w-12 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-blue-600 shadow-inner"></div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between p-6 bg-slate-50 dark:bg-slate-900/50 rounded-3xl border border-transparent hover:border-blue-100 dark:hover:border-blue-900/30 transition-all group">
                            <div>
                                <label class="block text-sm font-black text-slate-900 dark:text-white uppercase tracking-tight">Widget Público</label>
                                <p class="text-xs text-slate-500 font-medium mt-1">Exibir chat na homepage</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="public_chat_enabled" value="1" class="sr-only peer" {{ ($configs['public_chat_enabled']->value ?? 'true') === 'true' ? 'checked' : '' }}>
                                <div class="w-12 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-blue-600 shadow-inner"></div>
                            </label>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Mensagem de Boas-vindas</label>
                            <textarea name="welcome_message" rows="3" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-900/50 border-slate-100 dark:border-slate-700 rounded-3xl text-sm font-medium focus:ring-2 focus:ring-blue-600 transition-all dark:text-white">{{ $configs['welcome_message']->value ?? '' }}</textarea>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Mensagem Offline</label>
                            <textarea name="offline_message" rows="3" class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-900/50 border-slate-100 dark:border-slate-700 rounded-3xl text-sm font-medium focus:ring-2 focus:ring-blue-600 transition-all dark:text-white">{{ $configs['offline_message']->value ?? '' }}</textarea>
                            <p class="mt-2 text-[10px] font-bold text-slate-400 uppercase px-1">Exibida fora do horário de atendimento.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Horários de Funcionamento -->
            <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="px-8 py-5 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/50">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                        <x-icon name="calendar-clock" style="duotone" class="w-4 h-4 text-blue-500" />
                        Horários de Funcionamento
                    </h3>
                </div>
                <div class="p-8">
                    <div class="grid grid-cols-1 gap-4">
                        @php
                        $days = [
                            'monday' => 'Segunda-feira',
                            'tuesday' => 'Terça-feira',
                            'wednesday' => 'Quarta-feira',
                            'thursday' => 'Quinta-feira',
                            'friday' => 'Sexta-feira',
                            'saturday' => 'Sábado',
                            'sunday' => 'Domingo',
                        ];
                        @endphp
                        @foreach($days as $key => $label)
                        <div class="flex flex-col sm:flex-row sm:items-center gap-4 p-5 bg-slate-50 dark:bg-slate-900/50 rounded-3xl border border-transparent hover:border-blue-100 dark:hover:border-blue-900/30 transition-all group">
                            <div class="flex items-center gap-3 sm:w-48">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="opening_hours[{{ $key }}][enabled]" value="1" class="sr-only peer" {{ ($openingHours[$key]['enabled'] ?? false) ? 'checked' : '' }}>
                                    <div class="w-10 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-slate-600 peer-checked:bg-blue-600 shadow-inner"></div>
                                </label>
                                <span class="text-sm font-black text-slate-700 dark:text-slate-300 uppercase tracking-tight">{{ $label }}</span>
                            </div>
                            <div class="flex-1 grid grid-cols-2 gap-4">
                                <div class="relative">
                                    <input type="time" name="opening_hours[{{ $key }}][start]" value="{{ $openingHours[$key]['start'] ?? '08:00' }}" class="w-full px-4 py-3 bg-white dark:bg-slate-800 border-slate-100 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-2 focus:ring-blue-600 transition-all dark:text-white">
                                    <span class="absolute -top-2 left-3 px-1 bg-slate-50 dark:bg-slate-900 text-[10px] font-black text-slate-400 uppercase">Início</span>
                                </div>
                                <div class="relative">
                                    <input type="time" name="opening_hours[{{ $key }}][end]" value="{{ $openingHours[$key]['end'] ?? '17:00' }}" class="w-full px-4 py-3 bg-white dark:bg-slate-800 border-slate-100 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-2 focus:ring-blue-600 transition-all dark:text-white">
                                    <span class="absolute -top-2 left-3 px-1 bg-slate-50 dark:bg-slate-900 text-[10px] font-black text-slate-400 uppercase">Fim</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-4 space-y-8">
            <!-- Configurações Avançadas -->
            <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="px-8 py-5 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/50">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                        <x-icon name="rocket" style="duotone" class="w-4 h-4 text-blue-500" />
                        Avançado
                    </h3>
                </div>
                <div class="p-8 space-y-8">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Inatividade (minutos)</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <x-icon name="clock-rotate-left" class="w-4 h-4 text-slate-300 group-focus-within:text-blue-500 transition-colors" />
                            </div>
                            <input type="number" name="auto_close_timeout" value="{{ $configs['auto_close_timeout']->value ?? '30' }}" min="1"
                                class="w-full pl-10 pr-4 py-4 bg-slate-50 dark:bg-slate-900/50 border-slate-100 dark:border-slate-700 rounded-3xl text-sm font-bold focus:ring-2 focus:ring-blue-600 transition-all dark:text-white">
                        </div>
                        <p class="mt-2 text-[9px] font-bold text-slate-400 uppercase px-1 leading-relaxed">Tempo para encerrar sessões sem interação automaticamente.</p>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-1">Limite por Atendente</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <x-icon name="users-gear" class="w-4 h-4 text-slate-300 group-focus-within:text-blue-500 transition-colors" />
                            </div>
                            <input type="number" name="max_concurrent_sessions" value="{{ $configs['max_concurrent_sessions']->value ?? '10' }}" min="1"
                                class="w-full pl-10 pr-4 py-4 bg-slate-50 dark:bg-slate-900/50 border-slate-100 dark:border-slate-700 rounded-3xl text-sm font-bold focus:ring-2 focus:ring-blue-600 transition-all dark:text-white">
                        </div>
                        <p class="mt-2 text-[9px] font-bold text-slate-400 uppercase px-1 leading-relaxed">Máximo de atendimentos em aberto simultaneamente.</p>
                    </div>

                    <div class="flex items-center justify-between p-6 bg-slate-50 dark:bg-slate-900/50 rounded-3xl border border-transparent hover:border-blue-100 dark:hover:border-blue-900/30 transition-all">
                        <div>
                            <label class="block text-sm font-black text-slate-900 dark:text-white uppercase tracking-tight">Efeitos Sonoros</label>
                            <p class="text-[9px] text-slate-400 font-bold mt-1 uppercase">Avisos sonoros ativos</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="notification_sound" value="1" class="sr-only peer" {{ ($configs['notification_sound']->value ?? 'true') === 'true' ? 'checked' : '' }}>
                            <div class="w-12 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-blue-600 shadow-inner"></div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-slate-900 to-slate-800 dark:from-blue-600 dark:to-indigo-700 p-8 rounded-[2.5rem] shadow-xl text-center">
                <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <x-icon name="floppy-disk" style="duotone" class="w-8 h-8 text-white" />
                </div>
                <h4 class="text-white font-black text-lg mb-2 uppercase tracking-tight">Pronto para salvar?</h4>
                <p class="text-blue-100/60 font-medium text-xs mb-8 leading-relaxed px-4">Todas as alterações serão aplicadas instantaneamente em todos os atendimentos.</p>
                <button type="submit" class="w-full py-4 bg-white text-slate-900 dark:text-blue-600 font-black rounded-2xl hover:scale-105 active:scale-95 transition-all shadow-lg">
                    Salvar Alterações
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
