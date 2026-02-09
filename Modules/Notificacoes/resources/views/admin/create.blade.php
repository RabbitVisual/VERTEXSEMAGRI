@extends('admin.layouts.admin')

@section('title', 'Criar Notificação')

@section('content')
<!-- Page Header -->
<div class="mb-8 pb-4 border-b border-gray-200 dark:border-slate-700">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <x-icon module="notificacoes" class="w-8 h-8 text-emerald-600 dark:text-emerald-500" />
                Criar Notificação
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400">Admin</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('admin.notificacoes.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400">Notificações</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white">Criar</span>
            </nav>
        </div>
        <a href="{{ route('admin.notificacoes.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border-2 border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
            <x-icon name="arrow-left" class="w-5 h-5" />
            Voltar
        </a>
    </div>
</div>

<x-admin.card title="Nova Notificação">
    <form action="{{ route('admin.notificacoes.store') }}" method="POST">
        @csrf

        <div class="space-y-6">
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Tipo <span class="text-red-500">*</span>
                </label>
                <select id="type" name="type" required class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors {{ $errors->has('type') ? 'border-red-500' : '' }}">
                    <option value="info" {{ old('type') == 'info' ? 'selected' : '' }}>Informação</option>
                    <option value="success" {{ old('type') == 'success' ? 'selected' : '' }}>Sucesso</option>
                    <option value="warning" {{ old('type') == 'warning' ? 'selected' : '' }}>Aviso</option>
                    <option value="error" {{ old('type') == 'error' ? 'selected' : '' }}>Erro</option>
                    <option value="alert" {{ old('type') == 'alert' ? 'selected' : '' }}>Alerta</option>
                    <option value="system" {{ old('type') == 'system' ? 'selected' : '' }}>Sistema</option>
                </select>
                @error('type')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Título <span class="text-red-500">*</span>
                </label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors {{ $errors->has('title') ? 'border-red-500' : '' }}">
                @error('title')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Mensagem <span class="text-red-500">*</span>
                </label>
                <textarea id="message" name="message" rows="4" required class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors {{ $errors->has('message') ? 'border-red-500' : '' }}">{{ old('message') }}</textarea>
                @error('message')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                    Destinatário <span class="text-red-500">*</span>
                </label>
                <div class="space-y-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="recipient_type" value="user" {{ old('recipient_type') == 'user' ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 border-gray-300 dark:border-slate-600 focus:ring-emerald-500 dark:bg-slate-800">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Usuário Específico</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="recipient_type" value="role" {{ old('recipient_type') == 'role' ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 border-gray-300 dark:border-slate-600 focus:ring-emerald-500 dark:bg-slate-800">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Role</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" name="recipient_type" value="all" {{ old('recipient_type', 'all') == 'all' ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 border-gray-300 dark:border-slate-600 focus:ring-emerald-500 dark:bg-slate-800">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Todos os Usuários</span>
                    </label>
                </div>
            </div>

            <div id="user_select" class="hidden">
                <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Usuário</label>
                <select id="user_id" name="user_id" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                    <option value="">Selecione um usuário</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div id="role_select" class="hidden">
                <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Role</label>
                <select id="role" name="role" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                    <option value="">Selecione uma role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="module_source" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Módulo (opcional)</label>
                <select id="module_source" name="module_source" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                    <option value="">Nenhum</option>
                    @foreach($modules as $key => $label)
                        <option value="{{ $key }}" {{ old('module_source') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="action_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    URL de Ação (opcional)
                    <span class="text-xs text-gray-500 dark:text-gray-400 font-normal">Link para redirecionar ao clicar na notificação</span>
                </label>
                <input type="url" id="action_url" name="action_url" value="{{ old('action_url') }}" placeholder="https://exemplo.com/rota" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors {{ $errors->has('action_url') ? 'border-red-500' : '' }}">
                @error('action_url')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                    <div class="flex-1">
                        <h4 class="text-sm font-semibold text-blue-900 dark:text-blue-200 mb-1">Dica</h4>
                        <p class="text-sm text-blue-800 dark:text-blue-300">
                            A notificação será enviada em tempo real para os destinatários selecionados. Se você configurou WebSockets, eles receberão instantaneamente. Caso contrário, será atualizada no próximo polling (30 segundos).
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-200 dark:border-slate-700">
                <a href="{{ route('admin.notificacoes.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border-2 border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                    Cancelar
                </a>
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors">
                    <x-icon name="save" class="w-5 h-5" />
                    Criar Notificação
                </button>
            </div>
        </div>
    </form>
</x-admin.card>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const recipientType = document.querySelectorAll('input[name="recipient_type"]');
        const userSelect = document.getElementById('user_select');
        const roleSelect = document.getElementById('role_select');

        recipientType.forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'user') {
                    userSelect.classList.remove('hidden');
                    roleSelect.classList.add('hidden');
                } else if (this.value === 'role') {
                    userSelect.classList.add('hidden');
                    roleSelect.classList.remove('hidden');
                } else {
                    userSelect.classList.add('hidden');
                    roleSelect.classList.add('hidden');
                }
            });
        });

        // Trigger on load
        const checked = document.querySelector('input[name="recipient_type"]:checked');
        if (checked) {
            checked.dispatchEvent(new Event('change'));
        }
    });
</script>
@endpush
@endsection

