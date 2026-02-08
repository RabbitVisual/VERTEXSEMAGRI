@extends('consulta.layouts.consulta')

@section('title', 'Meu Perfil')

@section('content')
<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 mb-6 md:mb-8 border-b border-gray-200 dark:border-gray-700">
    <div>
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
            <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <span>Meu Perfil</span>
        </h1>
        <p class="text-sm md:text-base text-gray-600 dark:text-gray-400">Gerencie suas informações pessoais e configurações da conta</p>
    </div>
</div>

@if(session('success'))
    <div class="mb-6 rounded-xl bg-emerald-50 dark:bg-emerald-900/20 border-2 border-emerald-200 dark:border-emerald-800 p-4 md:p-5 shadow-sm">
        <div class="flex items-start gap-3">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 md:h-6 md:w-6 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm md:text-base font-semibold text-emerald-800 dark:text-emerald-200">{{ session('success') }}</p>
            </div>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="mb-6 rounded-xl bg-red-50 dark:bg-red-900/20 border-2 border-red-200 dark:border-red-800 p-4 md:p-5 shadow-sm">
        <div class="flex items-start gap-3">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 md:h-6 md:w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm md:text-base font-semibold text-red-800 dark:text-red-200">{{ session('error') }}</p>
            </div>
        </div>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6">
    <!-- Profile Card -->
    <div class="lg:col-span-1">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-6 md:p-8 text-center">
                <div class="mb-6">
                    @if($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto de Perfil"
                             class="mx-auto h-32 w-32 md:h-40 md:w-40 rounded-full border-4 border-blue-500 dark:border-blue-600 object-cover shadow-xl ring-4 ring-blue-100 dark:ring-blue-900/30"
                             id="profilePhotoPreview">
                    @else
                        <div class="mx-auto h-32 w-32 md:h-40 md:w-40 rounded-full border-4 border-blue-500 dark:border-blue-600 bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center text-white text-4xl md:text-5xl font-bold shadow-xl ring-4 ring-blue-100 dark:ring-blue-900/30"
                             id="profilePhotoPreview">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <h3 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $user->name }}</h3>
                <p class="text-sm md:text-base text-gray-600 dark:text-gray-400 mb-3">{{ $user->email }}</p>
                @if($user->phone)
                    <p class="text-sm md:text-base text-gray-600 dark:text-gray-400 mb-4 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                        </svg>
                        <span>{{ $user->phone }}</span>
                    </p>
                @endif
                <div class="mb-6">
                    @if($user->active)
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm md:text-base font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300 border-2 border-emerald-200 dark:border-emerald-800">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Ativo
                        </span>
                    @else
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm md:text-base font-semibold bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300 border-2 border-red-200 dark:border-red-800">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                            </svg>
                            Inativo
                        </span>
                    @endif
                </div>
                <div class="flex flex-wrap justify-center gap-2">
                    @foreach($user->roles as $role)
                        <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs md:text-sm font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                            {{ $role->name }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="lg:col-span-2">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-4 md:px-6 py-4 md:py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-blue-600 to-indigo-700">
                <h3 class="text-base md:text-lg font-bold text-white flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                        </svg>
                    </div>
                    <span>Editar Perfil</span>
                </h3>
            </div>
            <div class="p-4 md:p-6 lg:p-8">
                <form action="{{ route('consulta.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-6 md:mb-8">
                        <label for="photo" class="block text-sm md:text-base font-semibold text-gray-900 dark:text-white mb-3">
                            Foto de Perfil
                        </label>
                        <div class="relative">
                            <input type="file"
                                   class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700 file:transition-colors border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('photo') border-red-500 dark:border-red-600 @enderror"
                                   id="photo"
                                   name="photo"
                                   accept="image/*"
                                   onchange="previewPhoto(this)">
                        </div>
                        @error('photo')
                            <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-2 text-xs md:text-sm text-gray-500 dark:text-gray-400">Formatos aceitos: JPG, PNG, GIF. Tamanho máximo: 2MB</p>
                    </div>

                    <div class="mb-6 md:mb-8">
                        <label for="name" class="block text-sm md:text-base font-semibold text-gray-900 dark:text-white mb-3">
                            Nome <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('name') border-red-500 dark:border-red-600 @enderror"
                               id="name"
                               name="name"
                               value="{{ old('name', $user->name) }}"
                               required>
                        @error('name')
                            <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="mb-6 md:mb-8">
                        <label for="email" class="block text-sm md:text-base font-semibold text-gray-900 dark:text-white mb-3">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email"
                               class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('email') border-red-500 dark:border-red-600 @enderror"
                               id="email"
                               name="email"
                               value="{{ old('email', $user->email) }}"
                               required>
                        @error('email')
                            <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="mb-6 md:mb-8">
                        <label for="cpf" class="block text-sm md:text-base font-semibold text-gray-900 dark:text-white mb-3">
                            CPF <span class="text-xs font-normal text-gray-500 dark:text-gray-400">(não editável)</span>
                        </label>
                        <div class="relative">
                            <input type="text"
                                   class="w-full px-4 py-3 pr-10 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 cursor-not-allowed font-mono"
                                   id="cpf_display"
                                   value="{{ $user->cpf ? preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $user->cpf) : 'Não informado' }}"
                                   disabled>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            </div>
                            <input type="hidden" name="cpf" value="{{ $user->cpf }}">
                        </div>
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            <svg class="w-3.5 h-3.5 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                            Apenas administradores podem alterar o CPF
                        </p>
                    </div>

                    <div class="mb-6 md:mb-8">
                        <label for="phone" class="block text-sm md:text-base font-semibold text-gray-900 dark:text-white mb-3">
                            Telefone
                        </label>
                        <input type="text"
                               class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('phone') border-red-500 dark:border-red-600 @enderror"
                               id="phone"
                               name="phone"
                               value="{{ old('phone', $user->phone) }}"
                               placeholder="(00) 00000-0000">
                        @error('phone')
                            <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="border-t-2 border-gray-200 dark:border-gray-700 pt-6 md:pt-8 mt-6 md:mt-8">
                        <h4 class="text-base md:text-lg font-bold text-gray-900 dark:text-white mb-2 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                            Alterar Senha
                        </h4>
                        <p class="text-sm md:text-base text-gray-600 dark:text-gray-400 mb-6">Deixe em branco se não desejar alterar a senha</p>

                        <div class="mb-6 md:mb-8">
                            <label for="password" class="block text-sm md:text-base font-semibold text-gray-900 dark:text-white mb-3">
                                Nova Senha
                            </label>
                            <input type="password"
                                   class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('password') border-red-500 dark:border-red-600 @enderror"
                                   id="password"
                                   name="password"
                                   minlength="8">
                            @error('password')
                                <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="mb-6 md:mb-8">
                            <label for="password_confirmation" class="block text-sm md:text-base font-semibold text-gray-900 dark:text-white mb-3">
                                Confirmar Nova Senha
                            </label>
                            <input type="password"
                                   class="w-full px-4 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   minlength="8">
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t-2 border-gray-200 dark:border-gray-700">
                        <a href="{{ route('consulta.dashboard') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 border-2 border-gray-300 dark:border-gray-600 rounded-xl text-base font-semibold text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancelar
                        </a>
                        <button type="submit" class="inline-flex items-center justify-center gap-2 px-6 py-3 border border-transparent text-base font-semibold rounded-xl text-white bg-gradient-to-r from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-105">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                            Salvar Alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            const preview = document.getElementById('profilePhotoPreview');
            if (preview.tagName === 'IMG') {
                preview.src = e.target.result;
            } else {
                // Se for div, substituir por img
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'mx-auto h-32 w-32 md:h-40 md:w-40 rounded-full border-4 border-blue-500 dark:border-blue-600 object-cover shadow-xl ring-4 ring-blue-100 dark:ring-blue-900/30';
                img.id = 'profilePhotoPreview';
                preview.parentNode.replaceChild(img, preview);
            }
        };

        reader.readAsDataURL(input.files[0]);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // CPF não é mais editável para não-admins, então não precisa de máscara

    // Máscara para telefone
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 10) {
                value = value.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
            } else {
                value = value.replace(/(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
            }
            e.target.value = value;
        });
    }
});
</script>
@endpush
@endsection

