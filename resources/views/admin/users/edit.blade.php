@extends('admin.layouts.admin')

@section('title', 'Editar Usuário')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-gray-900 dark:text-white flex items-center gap-3 mb-2 tracking-tight">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 via-indigo-600 to-violet-700 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/20 ring-1 ring-white/20">
                    <x-icon name="eye" class="w-5 h-5" />
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirmar Nova Senha</label>
                        <div class="relative">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 block w-full px-4 py-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500"
                                placeholder="Digite a senha novamente">
                            <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                                <x-icon name="eye" class="w-5 h-5" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Roles e Permissões -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 flex items-center gap-3">
                <div class="p-2 bg-violet-100 dark:bg-violet-900/30 text-violet-600 dark:text-violet-400 rounded-lg">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-black text-gray-900 dark:text-white tracking-tight leading-tight">Roles e Permissões</h2>
                    <p class="text-[11px] text-gray-500 dark:text-gray-400 font-medium">Defina o nível de acesso e responsabilidades</p>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    @foreach($roles as $role)
                    <div class="flex items-center p-4 border border-gray-100 dark:border-slate-700 rounded-xl hover:bg-violet-50/50 dark:hover:bg-violet-900/10 transition-all duration-200 group">
                        <input type="checkbox" id="role_{{ $role->id }}" name="roles[]" value="{{ $role->name }}"
                            {{ $user->hasRole($role->name) ? 'checked' : '' }}
                            class="w-5 h-5 text-violet-600 bg-gray-50 border-gray-200 rounded-lg focus:ring-violet-500 dark:focus:ring-violet-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600 transition-all cursor-pointer">
                        <label for="role_{{ $role->id }}" class="ml-4 text-sm font-black text-gray-900 dark:text-white cursor-pointer flex-1">
                            <span class="block tracking-tight">{{ $role->name }}</span>
                            @if($role->description)
                            <span class="text-gray-500 dark:text-gray-400 block text-[11px] font-medium mt-0.5 leading-relaxed">{{ $role->description }}</span>
                            @endif
                        </label>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-[10px] font-black uppercase tracking-wider bg-violet-100 text-violet-700 dark:bg-violet-900/40 dark:text-violet-300 ring-1 ring-violet-200 dark:ring-violet-800/50">
                            {{ $role->permissions->count() }} permissões
                        </span>
                    </div>
                    @endforeach
                    @if($roles->isEmpty())
                    <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">Nenhuma role disponível</p>
                    @endif
                </div>
                @error('roles')
                    <p class="mt-4 text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Status -->
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 flex items-center gap-3">
                <div class="p-2 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 rounded-lg">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h2 class="text-lg font-black text-gray-900 dark:text-white tracking-tight">Status do Usuário</h2>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-4 p-5 border border-gray-100 dark:border-slate-700 rounded-2xl bg-emerald-50/30 dark:bg-emerald-900/5 ring-1 ring-emerald-100 dark:ring-emerald-900/20">
                    <input type="checkbox" id="active" name="active" value="1" {{ old('active', $user->active) ? 'checked' : '' }}
                        class="w-6 h-6 text-emerald-600 bg-gray-50 border-gray-200 rounded-lg focus:ring-emerald-500 dark:focus:ring-emerald-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-slate-700 dark:border-slate-600 transition-all cursor-pointer">
                    <label for="active" class="text-sm font-black text-gray-900 dark:text-white cursor-pointer flex flex-col">
                        <span class="tracking-tight uppercase text-xs text-emerald-700 dark:text-emerald-400">Ativação de Conta</span>
                        <span class="mt-0.5">Usuário ativo (pode fazer login no sistema)</span>
                    </label>
                </div>
                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Usuários inativos não conseguem fazer login no sistema</p>
            </div>
        </div>

        <!-- Ações -->
        <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-6 border-t border-gray-200 dark:border-slate-700">
            <a href="{{ route('admin.users.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3 text-sm font-black text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-all uppercase tracking-wide">
                Cancelar
            </a>
            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-10 py-3 text-sm font-black text-white bg-gradient-to-r from-indigo-600 to-violet-700 rounded-xl hover:from-indigo-700 hover:to-violet-800 focus:ring-4 focus:ring-indigo-300 dark:focus:ring-indigo-900 transition-all shadow-lg shadow-indigo-200 dark:shadow-none transform hover:scale-[1.03] active:scale-95 uppercase tracking-wide">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0h-1.5A2.25 2.25 0 0012 1.5h-1.5m9 0h-1.5A2.25 2.25 0 0012 1.5H6A2.25 2.25 0 003.75 3.75v1.5" />
                </svg>
                Atualizar Usuário
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-icon');

    if (field.type === 'password') {
        field.type = 'text';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228L3 3m0 0l-2.25 2.25M3 3l2.25 2.25M6.228 6.228L12 12m-3.772-3.772L12 12m0 0l2.25 2.25M12 12l-2.25 2.25M15.772 15.772L21 21m-3.772-3.772L21 21m0 0l-2.25-2.25M21 21l-2.25-2.25" />
        `;
    } else {
        field.type = 'password';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        `;
    }
}
</script>
@endpush
@endsection
