@extends('admin.layouts.admin')

@section('title', 'Configurações do Chat')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-module-icon module="Chat" class="w-6 h-6 md:w-7 md:h-7 text-white" />
                </div>
                <span>Configurações do Chat</span>
            </h1>
        </div>
        <a href="{{ route('admin.chat.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-slate-800 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-700 transition-colors">
            Voltar
        </a>
    </div>

    <form action="{{ route('admin.chat.config.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Configurações Gerais -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Configurações Gerais</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <label class="text-sm font-medium text-gray-900 dark:text-white">Chat Habilitado</label>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Ativar/desativar o chat no sistema</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="chat_enabled" value="1" class="sr-only peer" {{ ($configs['chat_enabled']->value ?? 'true') === 'true' ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <label class="text-sm font-medium text-gray-900 dark:text-white">Chat Público Habilitado</label>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Exibir widget de chat na homepage</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="public_chat_enabled" value="1" class="sr-only peer" {{ ($configs['public_chat_enabled']->value ?? 'true') === 'true' ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    </label>
                </div>

                <div>
                    <label for="welcome_message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mensagem de Boas-vindas</label>
                    <textarea id="welcome_message" name="welcome_message" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:border-slate-600 dark:text-white">{{ $configs['welcome_message']->value ?? '' }}</textarea>
                </div>

                <div>
                    <label for="offline_message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Mensagem quando Offline</label>
                    <textarea id="offline_message" name="offline_message" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:border-slate-600 dark:text-white">{{ $configs['offline_message']->value ?? '' }}</textarea>
                </div>
            </div>
        </div>

        <!-- Horários de Funcionamento -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Horários de Funcionamento</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
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
                    <div class="flex items-center gap-4 p-4 border border-gray-200 dark:border-slate-700 rounded-lg">
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="opening_hours[{{ $key }}][enabled]" value="1" class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800" {{ ($openingHours[$key]['enabled'] ?? false) ? 'checked' : '' }}>
                            <label class="text-sm font-medium text-gray-900 dark:text-white w-32">{{ $label }}</label>
                        </div>
                        <div class="flex-1 grid grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-1 text-xs text-gray-600 dark:text-gray-400">Início</label>
                                <input type="time" name="opening_hours[{{ $key }}][start]" value="{{ $openingHours[$key]['start'] ?? '08:00' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                            </div>
                            <div>
                                <label class="block mb-1 text-xs text-gray-600 dark:text-gray-400">Fim</label>
                                <input type="time" name="opening_hours[{{ $key }}][end]" value="{{ $openingHours[$key]['end'] ?? '17:00' }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Configurações Avançadas -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Configurações Avançadas</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label for="auto_close_timeout" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tempo para Fechar Sessão Inativa (minutos)</label>
                    <input type="number" id="auto_close_timeout" name="auto_close_timeout" value="{{ $configs['auto_close_timeout']->value ?? '30' }}" min="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                </div>

                <div>
                    <label for="max_concurrent_sessions" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Máximo de Sessões Simultâneas por Atendente</label>
                    <input type="number" id="max_concurrent_sessions" name="max_concurrent_sessions" value="{{ $configs['max_concurrent_sessions']->value ?? '10' }}" min="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:border-slate-600 dark:text-white">
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <label class="text-sm font-medium text-gray-900 dark:text-white">Som de Notificação</label>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Tocar som quando receber nova mensagem</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="notification_sound" value="1" class="sr-only peer" {{ ($configs['notification_sound']->value ?? 'true') === 'true' ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.chat.index') }}" class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-slate-800 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-700 transition-colors">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 transition-colors">
                Salvar Configurações
            </button>
        </div>
    </form>
</div>
@endsection

