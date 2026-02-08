@php
    use App\Helpers\FormatHelper;
@endphp

@extends('Co-Admin.layouts.app')

@section('title', 'Meu Perfil')

@section('content')
<div class="space-y-6">
    <!-- Page Header com Gradiente -->
    <div class="relative overflow-hidden bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-800 rounded-2xl shadow-xl">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.4\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        <div class="relative px-6 py-8">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-lg ring-4 ring-white/30">
                    <svg class="w-9 h-9 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-white mb-1">Meu Perfil</h1>
                    <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-white/80">
                        <a href="{{ route('co-admin.dashboard') }}" class="hover:text-white transition-colors">Co-Admin</a>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                        <span class="text-white font-medium">Perfil</span>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">
        <!-- Sidebar com Foto e Informações -->
        <div class="xl:col-span-4">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
                <!-- Header do Card com Gradiente -->
                <div class="bg-gradient-to-br from-indigo-500 via-purple-500 to-indigo-600 p-6 text-center relative">
                    <div class="absolute inset-0 bg-black/10"></div>
                    <div class="relative">
                        <div class="inline-block mb-4 relative group">
                            @if($user->photo)
                                <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto de Perfil"
                                     class="w-32 h-32 rounded-full border-4 border-white shadow-2xl object-cover mx-auto ring-4 ring-white/30 group-hover:ring-white/50 transition-all"
                                     id="profilePhotoPreviewSidebar">
                            @else
                                <div class="w-32 h-32 rounded-full border-4 border-white shadow-2xl bg-white text-indigo-600 flex items-center justify-center mx-auto text-5xl font-bold ring-4 ring-white/30 group-hover:ring-white/50 transition-all"
                                     id="profilePhotoPreviewSidebar">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                            <div class="absolute bottom-2 right-2 w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-lg ring-2 ring-indigo-500">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-1">{{ $user->name }}</h3>
                        @if($user->active)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500 text-white shadow-lg">
                                <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                                Conta Ativa
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-500 text-white shadow-lg">
                                <span class="w-1.5 h-1.5 bg-white rounded-full"></span>
                                Conta Inativa
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Informações do Usuário -->
                <div class="p-6 space-y-4">
                    <!-- Email -->
                    <div class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-slate-900/50 rounded-xl">
                        <div class="flex-shrink-0 w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-0.5">Email</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $user->email }}</p>
                        </div>
                    </div>

                    <!-- Telefone -->
                    @if($user->phone)
                    <div class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-slate-900/50 rounded-xl">
                        <div class="flex-shrink-0 w-10 h-10 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-0.5">Telefone</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $user->phone }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- CPF -->
                    @if($user->cpf)
                    <div class="flex items-start gap-3 p-3 bg-gray-50 dark:bg-slate-900/50 rounded-xl">
                        <div class="flex-shrink-0 w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-0.5">CPF</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white font-mono">{{ $user->cpf }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Roles/Permissões -->
                    <div class="pt-4 border-t border-gray-200 dark:border-slate-700">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">Permissões</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($user->roles as $role)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-gradient-to-r from-indigo-500 to-purple-500 text-white shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                    </svg>
                                    {{ ucfirst($role->name) }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    <!-- Estatísticas -->
                    <div class="pt-4 border-t border-gray-200 dark:border-slate-700">
                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl p-3 text-center">
                                <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ floor(\Carbon\Carbon::parse($user->created_at)->diffInDays()) }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Dias de conta</p>
                            </div>
                            <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/20 dark:to-purple-800/20 rounded-xl p-3 text-center">
                                <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $user->roles->count() }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">Funções</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Formulário Principal -->
        <div class="xl:col-span-8 space-y-6">
            <!-- Card de Upload de Foto -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 px-6 py-4 border-b border-gray-200 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                            </svg>
                        </div>
                        Foto de Perfil
                    </h3>
                </div>
                <form action="{{ route('co-admin.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row items-center gap-6">
                            <div class="flex-shrink-0">
                                @if($user->photo)
                                    <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto de Perfil"
                                         class="w-24 h-24 rounded-xl border-4 border-indigo-200 dark:border-indigo-800 object-cover shadow-lg"
                                         id="profilePhotoPreview">
                                @else
                                    <div class="w-24 h-24 rounded-xl border-4 border-indigo-200 dark:border-indigo-800 bg-gradient-to-br from-indigo-500 to-purple-500 text-white flex items-center justify-center text-3xl font-bold shadow-lg"
                                         id="profilePhotoPreview">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 w-full">
                                <label for="photo" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">
                                    Alterar Foto
                                </label>
                                <label for="photo" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-xl cursor-pointer bg-gray-50 dark:bg-slate-900/50 border-gray-300 dark:border-slate-600 hover:bg-gray-100 dark:hover:bg-slate-900 hover:border-indigo-500 dark:hover:border-indigo-500 transition-all group">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-10 h-10 mb-3 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                        </svg>
                                        <p class="mb-1 text-sm text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                            <span class="font-semibold">Clique para fazer upload</span> ou arraste
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG ou GIF (MAX. 2MB)</p>
                                    </div>
                                    <input type="file" id="photo" name="photo" accept="image/*" class="hidden" onchange="previewPhoto(this)">
                                </label>
                                @error('photo')
                                    <div class="flex items-center gap-2 mt-2 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                                        <svg class="w-4 h-4 text-red-600 dark:text-red-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                        </svg>
                                        <p class="text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
            </div>

            <!-- Card de Informações Pessoais -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 px-6 py-4 border-b border-gray-200 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                        </div>
                        Informações Pessoais
                    </h3>
                </div>
                <div class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nome Completo -->
                        <div class="md:col-span-2">
                            <label for="name" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">
                                Nome Completo <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>
                                </div>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-11 p-3 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500 transition-all @error('name') border-red-500 dark:border-red-600 @enderror"
                                    placeholder="Digite seu nome completo">
                            </div>
                            @error('name')
                                <div class="flex items-center gap-2 mt-2 p-2 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                                    <svg class="w-4 h-4 text-red-600 dark:text-red-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                    </svg>
                                    <p class="text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                    </svg>
                                </div>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-11 p-3 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500 transition-all @error('email') border-red-500 dark:border-red-600 @enderror"
                                    placeholder="seu@email.com">
                            </div>
                            @error('email')
                                <div class="flex items-center gap-2 mt-2 p-2 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                                    <svg class="w-4 h-4 text-red-600 dark:text-red-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                    </svg>
                                    <p class="text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>

                        <!-- CPF (Somente Leitura) -->
                        <div>
                            <label for="cpf" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">
                                CPF <span class="text-xs font-normal text-gray-500 dark:text-gray-400">(não editável)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0zm1.294 6.336a6.721 6.721 0 01-3.17.789 6.721 6.721 0 01-3.168-.789 3.376 3.376 0 016.338 0z" />
                                    </svg>
                                </div>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                    </svg>
                                </div>
                                <input type="text" id="cpf_display" value="{{ FormatHelper::formatarCPF($user->cpf) }}" disabled
                                    class="bg-gray-100 border border-gray-300 text-gray-600 text-sm rounded-xl block w-full pl-11 pr-11 p-3 dark:bg-slate-800 dark:border-slate-700 dark:text-gray-400 cursor-not-allowed font-mono">
                                <input type="hidden" name="cpf" value="{{ $user->cpf }}">
                            </div>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                <svg class="w-3.5 h-3.5 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                                Apenas administradores podem alterar o CPF
                            </p>
                        </div>

                        <!-- Telefone -->
                        <div class="md:col-span-2">
                            <label for="phone" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">
                                Telefone
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                    </svg>
                                </div>
                                <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-11 p-3 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500 transition-all @error('phone') border-red-500 dark:border-red-600 @enderror"
                                    placeholder="(00) 00000-0000">
                            </div>
                            @error('phone')
                                <div class="flex items-center gap-2 mt-2 p-2 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                                    <svg class="w-4 h-4 text-red-600 dark:text-red-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                    </svg>
                                    <p class="text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card de Segurança (Senha) -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700 overflow-hidden">
                <div class="bg-gradient-to-r from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20 px-6 py-4 border-b border-gray-200 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-red-500 to-orange-500 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </div>
                        Segurança
                    </h3>
                </div>
                <div class="p-6">
                    <div class="mb-4 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl">
                        <div class="flex gap-3">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                            </svg>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-blue-900 dark:text-blue-200 mb-1">Alterar Senha</p>
                                <p class="text-xs text-blue-700 dark:text-blue-300">Deixe os campos em branco se não desejar alterar sua senha atual.</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Nova Senha -->
                        <div>
                            <label for="password" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">
                                Nova Senha
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                    </svg>
                                </div>
                                <input type="password" id="password" name="password" minlength="8"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-11 pr-11 p-3 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500 transition-all @error('password') border-red-500 dark:border-red-600 @enderror"
                                    placeholder="••••••••">
                                <button type="button" onclick="togglePassword('password')" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="password-eye">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <div class="flex items-center gap-2 mt-2 p-2 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                                    <svg class="w-4 h-4 text-red-600 dark:text-red-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                    </svg>
                                    <p class="text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                                </div>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Mínimo de 8 caracteres</p>
                        </div>

                        <!-- Confirmar Senha -->
                        <div>
                            <label for="password_confirmation" class="block mb-2 text-sm font-semibold text-gray-900 dark:text-white">
                                Confirmar Nova Senha
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                                    </svg>
                                </div>
                                <input type="password" id="password_confirmation" name="password_confirmation" minlength="8"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-11 pr-11 p-3 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-indigo-500 dark:focus:border-indigo-500 transition-all"
                                    placeholder="••••••••">
                                <button type="button" onclick="togglePassword('password_confirmation')" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" id="password_confirmation-eye">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botões de Ação -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 p-6 bg-white dark:bg-slate-800 rounded-2xl shadow-lg border border-gray-200 dark:border-slate-700">
                <div class="flex items-center gap-3 text-sm text-gray-600 dark:text-gray-400">
                    <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                    <span>Última atualização: {{ $user->updated_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('co-admin.dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-semibold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 focus:ring-4 focus:ring-gray-300 dark:bg-slate-700 dark:text-gray-300 dark:hover:bg-slate-600 dark:focus:ring-slate-600 transition-all">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancelar
                    </a>
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl hover:from-indigo-700 hover:to-purple-700 focus:ring-4 focus:ring-indigo-300 dark:focus:ring-indigo-800 shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Salvar Alterações
                    </button>
                </div>
            </div>
                </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Preview da foto de perfil
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];

        // Validar tamanho (2MB)
        if (file.size > 2048 * 1024) {
            alert('A imagem deve ter no máximo 2MB');
            input.value = '';
            return;
        }

        // Validar tipo
        if (!file.type.match('image.*')) {
            alert('Apenas imagens são permitidas');
            input.value = '';
            return;
        }

        const reader = new FileReader();

        reader.onload = function(e) {
            // Atualizar preview principal
            const preview = document.getElementById('profilePhotoPreview');
            if (preview.tagName === 'IMG') {
                preview.src = e.target.result;
            } else {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-24 h-24 rounded-xl border-4 border-indigo-200 dark:border-indigo-800 object-cover shadow-lg';
                img.id = 'profilePhotoPreview';
                preview.parentNode.replaceChild(img, preview);
            }

            // Atualizar preview da sidebar
            const sidebarPreview = document.getElementById('profilePhotoPreviewSidebar');
            if (sidebarPreview) {
                if (sidebarPreview.tagName === 'IMG') {
                    sidebarPreview.src = e.target.result;
                } else {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-32 h-32 rounded-full border-4 border-white shadow-2xl object-cover mx-auto ring-4 ring-white/30 group-hover:ring-white/50 transition-all';
                    img.id = 'profilePhotoPreviewSidebar';
                    sidebarPreview.parentNode.replaceChild(img, sidebarPreview);
                }
            }
        };

        reader.readAsDataURL(file);
    }
}

// Toggle visibilidade da senha
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-eye');

    if (field.type === 'password') {
        field.type = 'text';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
        `;
    } else {
        field.type = 'password';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        `;
    }
}

document.addEventListener('DOMContentLoaded', function() {
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

    // CPF não é mais editável para não-admins, então não precisa de máscara

    // Validação do formulário
    const form = document.getElementById('profileForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;

            if (password && password !== passwordConfirmation) {
                e.preventDefault();
                alert('As senhas não coincidem!');
                return false;
            }

            if (password && password.length < 8) {
                e.preventDefault();
                alert('A senha deve ter no mínimo 8 caracteres!');
                return false;
            }
        });
    }

    // Animação suave ao carregar
    const cards = document.querySelectorAll('.xl\\:col-span-4, .xl\\:col-span-8 > div');
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.5s ease, transform 0.5s ease';

            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 50);
        }, index * 100);
    });
});
</script>
@endpush
@endsection
