@extends('admin.layouts.admin')

@section('title', 'Meu Perfil')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12 font-sans">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 to-violet-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="user-gear" class="w-6 h-6 md:w-7 md:h-7 text-white" style="duotone" />
                </div>
                <span>Meu <span class="text-indigo-600 dark:text-indigo-400">Perfil</span></span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                <span class="text-gray-900 dark:text-white font-medium">Configurações da Conta</span>
            </nav>
        </div>
    </div>

    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Coluna da Esquerda: Avatar e Status -->
            <div class="lg:col-span-1 space-y-8">
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden relative group">
                    <div class="h-32 bg-gradient-to-br from-indigo-600 to-violet-700 relative">
                        <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                    <div class="px-8 pb-8 text-center relative">
                        <div class="relative -mt-16 mb-4 inline-block">
                            <div class="w-32 h-32 rounded-[2.5rem] border-8 border-white dark:border-slate-800 bg-slate-100 dark:bg-slate-700 relative overflow-hidden shadow-2xl group-hover:scale-105 transition-transform duration-300">
                                @if($user->photo)
                                    <img src="{{ asset('storage/' . $user->photo) }}" alt="{{ $user->name }}" class="w-full h-full object-cover" id="avatar-preview">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-4xl font-bold text-indigo-500 bg-indigo-50 dark:bg-indigo-900/20" id="avatar-placeholder">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <img src="" alt="Preview" class="w-full h-full object-cover hidden" id="avatar-preview">
                                @endif

                                <label for="photo" class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 cursor-pointer transition-opacity duration-200">
                                    <x-icon name="camera" class="w-8 h-8 text-white drop-shadow-md" />
                                </label>
                                <input type="file" name="photo" id="photo" class="hidden" accept="image/*" onchange="previewImage(this)">
                            </div>
                            <div class="absolute bottom-2 right-2 w-8 h-8 rounded-2xl border-4 border-white dark:border-slate-800 bg-emerald-500 flex items-center justify-center shadow-sm" title="Usuário Ativo">
                                <x-icon name="check" class="w-3.5 h-3.5 text-white" />
                            </div>
                        </div>

                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-1">{{ $user->name }}</h2>
                        <p class="text-xs text-slate-500 font-semibold uppercase tracking-wider mb-4">{{ $user->roles->first()->name ?? 'Usuário' }}</p>

                        <div class="flex flex-col gap-2">
                             <div class="text-xs font-medium text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-slate-900/50 py-2 px-4 rounded-xl">
                                Última atualização: {{ $user->updated_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Roles do Usuário -->
                @if($user->roles->count() > 0)
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <x-icon name="shield-halved" style="duotone" class="w-4 h-4 text-indigo-500" />
                        Permissões Atribuídas
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($user->roles as $role)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300 border border-indigo-100 dark:border-indigo-900/20">
                                <x-icon name="user-tag" class="w-3 h-3" />
                                {{ $role->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Coluna da Direita: Formulário -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Informações Pessoais -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between bg-gray-50/50 dark:bg-slate-900/50">
                        <h2 class="text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider flex items-center gap-2">
                            <x-icon name="address-card" style="duotone" class="w-5 h-5 text-blue-500" />
                            Informações Pessoais
                        </h2>
                    </div>
                    <div class="p-6 md:p-8 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                    Nome Completo <span class="text-red-500">*</span>
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <x-icon name="user" class="w-5 h-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors" />
                                    </div>
                                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                                        class="w-full pl-12 pr-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all dark:text-white placeholder:text-slate-400">
                                </div>
                            </div>

                            <div>
                                <label for="email" class="block mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                    E-mail de Login <span class="text-red-500">*</span>
                                </label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <x-icon name="envelope" class="w-5 h-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors" />
                                    </div>
                                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                                        class="w-full pl-12 pr-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all dark:text-white placeholder:text-slate-400">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="phone" class="block mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Telefone de Contato
                            </label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <x-icon name="phone" class="w-5 h-5 text-slate-400 group-focus-within:text-indigo-500 transition-colors" />
                                </div>
                                <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                                    class="phone-mask w-full pl-12 pr-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all dark:text-white placeholder:text-slate-400"
                                    placeholder="(00) 00000-0000">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Segurança -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between bg-gray-50/50 dark:bg-slate-900/50">
                        <h2 class="text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider flex items-center gap-2">
                            <x-icon name="lock" style="duotone" class="w-5 h-5 text-rose-500" />
                            Segurança da Conta
                        </h2>
                    </div>
                    <div class="p-6 md:p-8 space-y-6">
                        <div class="p-4 bg-amber-50 dark:bg-amber-900/10 border border-amber-100 dark:border-amber-900/20 rounded-xl mb-4">
                            <div class="flex gap-3">
                                <x-icon name="triangle-exclamation" class="w-5 h-5 text-amber-500 flex-shrink-0" />
                                <p class="text-sm text-amber-700 dark:text-amber-400/90">
                                    Preencha os campos abaixo apenas se desejar alterar sua senha atual. Caso contrário, deixe em branco.
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="password" class="block mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nova Senha</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <x-icon name="key" class="w-5 h-5 text-slate-400 group-focus-within:text-rose-500 transition-colors" />
                                    </div>
                                    <input type="password" id="password" name="password" autocomplete="new-password"
                                        class="w-full pl-12 pr-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all dark:text-white placeholder:text-slate-400">
                                </div>
                            </div>

                            <div>
                                <label for="password_confirmation" class="block mb-2 text-xs font-semibold text-slate-500 uppercase tracking-wider">Confirmar Nova Senha</label>
                                <div class="relative group">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <x-icon name="key" class="w-5 h-5 text-slate-400 group-focus-within:text-rose-500 transition-colors" />
                                    </div>
                                    <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password"
                                        class="w-full pl-12 pr-4 py-3 bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-all dark:text-white placeholder:text-slate-400">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ações -->
                <div class="flex items-center justify-end gap-3 pt-4">
                     <a href="{{ route('admin.dashboard') }}" class="px-6 py-3.5 text-sm font-bold uppercase tracking-wider text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-white transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" class="inline-flex items-center justify-center gap-2 px-8 py-3.5 text-sm font-bold uppercase tracking-wider text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/30 active:scale-95 group">
                        <x-icon name="floppy-disk" style="duotone" class="w-5 h-5 group-hover:rotate-12 transition-transform" />
                        Salvar Alterações
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                var preview = document.getElementById('avatar-preview');
                var placeholder = document.getElementById('avatar-placeholder');

                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if (placeholder) {
                    placeholder.classList.add('hidden');
                }
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    // Phone Mask
    document.addEventListener('DOMContentLoaded', function() {
        const phoneInput = document.querySelector('.phone-mask');
        if (phoneInput) {
            phoneInput.addEventListener('input', function (e) {
                var x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,5})(\d{0,4})/);
                e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
            });
        }
    });
</script>
@endpush
@endsection
