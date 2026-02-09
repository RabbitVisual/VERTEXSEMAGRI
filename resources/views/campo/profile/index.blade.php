@php
    use App\Helpers\FormatHelper;
@endphp

@extends('campo.layouts.app')

@section('title', 'Perfil de Operador')

@section('breadcrumbs')
    <x-icon name="chevron-right" class="w-2 h-2" />
    <span class="text-emerald-600">Configurações de Identidade</span>
@endsection

@section('content')
<div class="space-y-6 md:space-y-10 animate-fade-in pb-12">
    <!-- Header de Identidade -->
    <div class="relative overflow-hidden bg-gradient-to-br from-slate-900 to-slate-800 rounded-[3rem] shadow-2xl border border-white/5">
        <!-- Background Patterns -->
        <div class="absolute inset-0 opacity-10 pointer-events-none">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>

        <div class="relative px-10 py-12 flex flex-col md:flex-row items-center gap-10">
            <div class="relative group">
                <div class="w-32 h-32 rounded-[2.5rem] overflow-hidden border-4 border-emerald-500/30 shadow-2xl relative">
                    @if($user->profile_photo_path)
                        <img id="profilePhotoPreview" src="{{ asset('storage/' . $user->profile_photo_path) }}" class="w-full h-full object-cover">
                    @else
                        <div id="profilePhotoPreview" class="w-full h-full bg-slate-800 flex items-center justify-center text-slate-600">
                            <x-icon name="user" class="w-16 h-16" />
                        </div>
                    @endif

                    <button type="button" onclick="document.getElementById('profile_photo').click()" class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white cursor-pointer">
                        <x-icon name="camera" class="w-8 h-8" />
                    </button>
                </div>
            </div>

            <div class="text-center md:text-left">
                <div class="inline-flex items-center gap-3 px-3 py-1 bg-emerald-500/10 border border-emerald-500/20 rounded-full text-[8px] font-black text-emerald-500 uppercase tracking-[0.2em] mb-4 italic">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Operador de Campo Ativo
                </div>
                <h1 class="text-3xl font-black text-white uppercase tracking-tight">{{ $user->name }}</h1>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mt-2 italic">ID Funcional: #{{ $user->id }} • {{ $user->email }}</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('campo.profile.update') }}" enctype="multipart/form-data" id="profileForm">
        @csrf
        @method('PUT')
        <input type="file" id="profile_photo" name="profile_photo" class="hidden" onchange="previewPhoto(this)">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <!-- Informações Básicas -->
            <div class="lg:col-span-8 space-y-10">
                <div class="premium-card p-10">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-10 flex items-center gap-3 italic">
                        <x-icon name="address-card" style="duotone" class="w-5 h-5 text-indigo-500" />
                        Credenciais de Acesso
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="block text-[9px] font-black uppercase text-slate-400 tracking-widest mb-1 italic ml-2">Nome Completo</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full p-5 bg-gray-50 dark:bg-slate-950 border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 dark:text-white transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[9px] font-black uppercase text-slate-400 tracking-widest mb-1 italic ml-2">Endereço de E-mail</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full p-5 bg-gray-50 dark:bg-slate-950 border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 dark:text-white transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[9px] font-black uppercase text-slate-400 tracking-widest mb-1 italic ml-2">Telefone de Contato</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full p-5 bg-gray-50 dark:bg-slate-950 border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 dark:text-white transition-all">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[9px] font-black uppercase text-slate-400 tracking-widest mb-1 italic ml-2">Registro CPF</label>
                            <input type="text" value="{{ $user->cpf }}" readonly class="w-full p-5 bg-slate-100 dark:bg-slate-900 border-transparent rounded-2xl text-[11px] font-black uppercase tracking-widest text-slate-400 cursor-not-allowed">
                        </div>
                    </div>
                </div>

                <div class="premium-card p-10">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-10 flex items-center gap-3 italic">
                        <x-icon name="shield-halved" style="duotone" class="w-5 h-5 text-rose-500" />
                        Segurança e Autenticação
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="block text-[9px] font-black uppercase text-slate-400 tracking-widest mb-1 italic ml-2">Nova Senha Tática</label>
                            <div class="relative">
                                <input type="password" id="password" name="password" class="w-full p-5 bg-gray-50 dark:bg-slate-950 border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 dark:text-white transition-all">
                                <button type="button" onclick="togglePassword('password')" class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-rose-500">
                                    <x-icon name="eye" class="w-4 h-4" />
                                </button>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-[9px] font-black uppercase text-slate-400 tracking-widest mb-1 italic ml-2">Confirmar Senha</label>
                            <div class="relative">
                                <input type="password" id="password_confirmation" name="password_confirmation" class="w-full p-5 bg-gray-50 dark:bg-slate-950 border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 dark:text-white transition-all">
                                <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-rose-500">
                                    <x-icon name="eye" class="w-4 h-4" />
                                </button>
                            </div>
                        </div>
                    </div>
                    <p class="mt-8 text-[9px] font-black text-slate-400 uppercase tracking-widest italic">Deixe em branco para manter a senha atual.</p>
                </div>
            </div>

            <!-- Painel de Status -->
            <div class="lg:col-span-4 space-y-8">
                <div class="premium-card p-10 bg-indigo-600 text-white border-none shadow-xl shadow-indigo-600/20 relative overflow-hidden group">
                    <div class="absolute -right-10 -bottom-10 opacity-10 pointer-events-none group-hover:scale-110 transition-transform duration-700">
                        <x-icon name="signature" class="w-48 h-48" />
                    </div>

                    <h4 class="text-[10px] font-black uppercase tracking-[0.3em] opacity-80 mb-8 italic">Resumo de Atividade</h4>
                    <div class="space-y-6">
                        <div>
                            <p class="text-[8px] font-black uppercase tracking-widest opacity-60 mb-1">Membro desde</p>
                            <p class="text-xl font-black uppercase tracking-tight">{{ $user->created_at->format('M Y') }}</p>
                        </div>
                        <div class="pt-6 border-t border-white/10">
                            <p class="text-[8px] font-black uppercase tracking-widest opacity-60 mb-1">Última Sincronização</p>
                            <p class="text-xs font-bold uppercase tracking-widest">{{ $user->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>

                <div class="premium-card p-8 bg-slate-50 dark:bg-slate-900 border-dashed border-2 border-slate-200 dark:border-slate-800">
                    <div class="flex flex-col gap-4">
                        <button type="submit" class="h-14 bg-emerald-600 text-white rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-emerald-700 transition-all shadow-xl shadow-emerald-500/20 active:scale-95 flex items-center justify-center gap-3">
                            <x-icon name="check-to-slot" style="duotone" class="w-5 h-5" />
                            Aplicar Protocolo
                        </button>
                        <a href="{{ route('campo.dashboard') }}" class="h-14 bg-white dark:bg-slate-800 text-slate-400 rounded-2xl text-[11px] font-black uppercase tracking-widest hover:text-rose-500 transition-all border border-gray-100 dark:border-slate-700 active:scale-95 flex items-center justify-center gap-3">
                            <x-icon name="xmark" class="w-4 h-4" />
                            Cancelar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function previewPhoto(input) {
        if (input.files && input.files[0]) {
            const rd = new FileReader();
            rd.onload = e => {
                const img = document.getElementById('profilePhotoPreview');
                if(img.tagName === 'IMG') img.src = e.target.result;
                else {
                    const newImg = document.createElement('img');
                    newImg.src = e.target.result;
                    newImg.id = 'profilePhotoPreview';
                    newImg.className = 'w-full h-full object-cover';
                    img.parentNode.replaceChild(newImg, img);
                }
            }
            rd.readAsDataURL(input.files[0]);
        }
    }

    function togglePassword(id) {
        const inp = document.getElementById(id);
        inp.type = inp.type === 'password' ? 'text' : 'password';
    }

    document.getElementById('phone').oninput = function(e) {
        let v = e.target.value.replace(/\D/g, '');
        if (v.length > 11) v = v.substring(0, 11);
        if (v.length <= 10) v = v.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
        else v = v.replace(/(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
        e.target.value = v;
    };
</script>
@endpush
@endsection
