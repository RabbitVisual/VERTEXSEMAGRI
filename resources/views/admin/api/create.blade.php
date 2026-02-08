@extends('admin.layouts.admin')

@section('title', 'Criar Token de API')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>
                <span>Criar Novo Token de API</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Admin</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <a href="{{ route('admin.api.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">API</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <span class="text-gray-900 dark:text-white font-medium">Criar</span>
            </nav>
        </div>
        <a href="{{ route('admin.api.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:text-gray-300 dark:bg-slate-700 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Voltar
        </a>
    </div>

    <!-- Form Card - Flowbite Card -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Informações do Token</h2>
        </div>
        <form action="{{ route('admin.api.store') }}" method="POST" class="p-6">
            @csrf

            <div class="space-y-6">
                <!-- Usuário -->
                <div>
                    <label for="user_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Usuário <span class="text-red-500">*</span>
                    </label>
                    <select name="user_id" id="user_id" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500 @error('user_id') border-red-500 dark:border-red-600 @enderror">
                        <option value="">Selecione um usuário</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                        @endforeach
                    </select>
                    @error('user_id')
                    <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nome do Token -->
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Nome do Token <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500 @error('name') border-red-500 dark:border-red-600 @enderror" placeholder="Ex: API Mobile App">
                    @error('name')
                    <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descrição -->
                <div>
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Descrição
                    </label>
                    <textarea name="description" id="description" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500 @error('description') border-red-500 dark:border-red-600 @enderror" placeholder="Descreva o propósito deste token...">{{ old('description') }}</textarea>
                    @error('description')
                    <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Permissões (Abilities) -->
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Permissões
                    </label>
                    <div class="space-y-2 p-4 bg-gray-50 dark:bg-slate-700/50 rounded-lg border border-gray-200 dark:border-slate-600">
                        <label class="flex items-center gap-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-slate-700 p-2 rounded transition-colors">
                            <input type="checkbox" name="abilities[]" value="*" checked class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Todas as permissões (*)</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-slate-700 p-2 rounded transition-colors">
                            <input type="checkbox" name="abilities[]" value="demandas:read" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Ler Demandas</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-slate-700 p-2 rounded transition-colors">
                            <input type="checkbox" name="abilities[]" value="demandas:write" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Criar/Editar Demandas</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-slate-700 p-2 rounded transition-colors">
                            <input type="checkbox" name="abilities[]" value="ordens:read" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Ler Ordens</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-slate-700 p-2 rounded transition-colors">
                            <input type="checkbox" name="abilities[]" value="ordens:write" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600">
                            <span class="text-sm text-gray-700 dark:text-gray-300">Criar/Editar Ordens</span>
                        </label>
                    </div>
                </div>

                <!-- Data de Expiração -->
                <div>
                    <label for="expires_at" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Data de Expiração (opcional)
                    </label>
                    <input type="date" name="expires_at" id="expires_at" value="{{ old('expires_at') }}" min="{{ date('Y-m-d') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500 @error('expires_at') border-red-500 dark:border-red-600 @enderror">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Deixe em branco para token sem expiração</p>
                    @error('expires_at')
                    <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- IP Whitelist -->
                <div>
                    <label for="ip_whitelist" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        IP Whitelist (opcional)
                    </label>
                    <input type="text" name="ip_whitelist" id="ip_whitelist" value="{{ old('ip_whitelist') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500 @error('ip_whitelist') border-red-500 dark:border-red-600 @enderror" placeholder="192.168.1.1, 10.0.0.1">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Separe múltiplos IPs por vírgula. Deixe em branco para permitir todos os IPs.</p>
                    @error('ip_whitelist')
                    <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rate Limit -->
                <div>
                    <label for="rate_limit" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Limite de Requisições por Minuto
                    </label>
                    <input type="number" name="rate_limit" id="rate_limit" value="{{ old('rate_limit', 60) }}" min="1" max="1000" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500 @error('rate_limit') border-red-500 dark:border-red-600 @enderror">
                    @error('rate_limit')
                    <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botões -->
                <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-200 dark:border-slate-700">
                    <a href="{{ route('admin.api.index') }}" class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-center text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Criar Token
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
