@extends('admin.layouts.admin')

@section('title', 'Atendimento - ' . ($session->visitor_name ?? 'Sem nome'))

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
                    <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">{{ $session->visitor_name ?? 'Sessão de Chat' }}</h1>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest border
                            {{ $session->status === 'waiting' ? 'bg-amber-50 text-amber-600 border-amber-100 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-800/30' : '' }}
                            {{ $session->status === 'active' ? 'bg-green-50 text-green-600 border-green-100 dark:bg-green-900/20 dark:text-green-400 dark:border-green-800/30' : '' }}
                            {{ $session->status === 'closed' ? 'bg-slate-50 text-slate-600 border-slate-100 dark:bg-slate-900/20 dark:text-slate-400 dark:border-slate-800/30' : '' }}
                        ">
                            <span class="w-1.5 h-1.5 rounded-full {{ $session->status === 'waiting' ? 'bg-amber-500 animate-pulse' : ($session->status === 'active' ? 'bg-green-500' : 'bg-slate-400') }}"></span>
                            {{ $session->status_texto }}
                        </span>
                        <span class="text-slate-300 dark:text-slate-600">•</span>
                        <span class="text-xs font-bold text-slate-400 dark:text-slate-500 tracking-wider">ID: {{ $session->session_id }}</span>
                    </div>
                </div>
            </div>

            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-400 dark:text-slate-500">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-3 h-3" />
                <a href="{{ route('admin.chat.index') }}" class="hover:text-blue-600 transition-colors">Chat</a>
                <x-icon name="chevron-right" class="w-3 h-3" />
                <span class="text-slate-600 dark:text-slate-300">Detalhes</span>
            </nav>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.chat.index') }}" class="inline-flex items-center gap-2 px-5 py-3 text-sm font-bold text-slate-700 bg-white border border-slate-200 rounded-2xl hover:bg-slate-50 dark:bg-slate-800 dark:text-slate-300 dark:border-slate-700 dark:hover:bg-slate-700 transition-all shadow-sm active:scale-95">
                <x-icon name="arrow-left" style="duotone" class="w-4 h-4 text-slate-400" />
                Voltar
            </a>
            @if($session->status !== 'closed')
            <form action="{{ route('admin.chat.close', $session->id) }}" method="POST" class="inline" onsubmit="return confirm('Deseja encerrar esta sessão?')">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-3 text-sm font-bold text-white bg-red-600 rounded-2xl hover:bg-red-700 transition-all shadow-xl shadow-red-500/10 active:scale-95 border-b-4 border-red-800">
                    <x-icon name="power-off" style="duotone" class="w-4 h-4" />
                    Encerrar
                </button>
            </form>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Chat Area -->
        <div class="lg:col-span-8">
            <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden flex flex-col h-[750px]">
                <!-- Chat Header -->
                <div class="px-8 py-5 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/50 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white font-black">
                            {{ strtoupper(substr($session->visitor_name ?? 'V', 0, 1)) }}
                        </div>
                        <div>
                            <div class="text-sm font-black text-slate-900 dark:text-white">{{ $session->visitor_name ?? 'Visitante' }}</div>
                            <div id="typing-indicator" class="text-[10px] text-blue-500 font-black uppercase tracking-widest hidden">Digitando...</div>
                        </div>
                    </div>
                </div>

                <!-- Messages -->
                <div id="chat-messages-container" class="flex-1 p-8 overflow-y-auto space-y-6 bg-slate-50/30 dark:bg-slate-900/20" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%239C92AC\' fill-opacity=\'0.03\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                    @foreach($session->messages as $message)
                    <div class="flex {{ $message->sender_type === 'user' || $message->sender_type === 'system' ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[75%] space-y-1">
                            <div class="flex items-center gap-2 px-1 {{ $message->sender_type === 'user' || $message->sender_type === 'system' ? 'justify-end' : '' }}">
                                <span class="text-[10px] font-black uppercase tracking-widest {{ $message->sender_type === 'user' || $message->sender_type === 'system' ? 'text-blue-600 dark:text-blue-400' : 'text-slate-400' }}">
                                    {{ $message->sender_name }}
                                </span>
                                <span class="text-[9px] font-bold text-slate-300 dark:text-slate-600">{{ $message->created_at->format('H:i') }}</span>
                            </div>
                            <div class="px-5 py-3 rounded-2xl shadow-sm text-sm font-medium leading-relaxed
                                {{ $message->sender_type === 'user' || $message->sender_type === 'system' ? 'bg-gradient-to-br from-blue-600 to-indigo-700 text-white rounded-tr-md' : 'bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-100 border border-slate-100 dark:border-slate-600 rounded-tl-md' }}
                            ">
                                {!! $message->formatted_message !!}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Input -->
                @if($session->status !== 'closed')
                <div class="p-6 bg-white dark:bg-slate-800 border-t border-slate-100 dark:border-slate-700">
                    <form id="message-form" class="flex gap-4">
                        @csrf
                        <div class="flex-1 relative">
                            <input type="text" id="message-input" placeholder="Escreva uma mensagem..."
                                class="w-full px-6 py-4 bg-slate-50 dark:bg-slate-900/50 border-transparent focus:bg-white dark:focus:bg-slate-900 border-slate-100 dark:border-slate-700 rounded-2xl text-sm font-medium focus:ring-2 focus:ring-blue-600 transition-all dark:text-white">
                        </div>
                        <button type="submit" class="w-14 h-14 bg-gradient-to-br from-blue-600 to-indigo-700 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/20 hover:scale-105 active:scale-95 transition-all">
                            <x-icon name="paper-plane" style="duotone" class="w-6 h-6" />
                        </button>
                    </form>
                </div>
                @else
                <div class="p-6 bg-slate-50/50 dark:bg-slate-900/50 border-t border-slate-100 dark:border-slate-700 text-center">
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest flex items-center justify-center gap-2">
                        <x-icon name="lock" style="duotone" class="w-4 h-4" />
                        Esta conversa foi encerrada e não permite novas mensagens.
                    </p>
                </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-4 space-y-6">
            <!-- Visitant Info -->
            <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="px-8 py-5 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/50">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                        <x-icon name="user" style="duotone" class="w-4 h-4 text-blue-500" />
                        Informações do Visitante
                    </h3>
                </div>
                <div class="p-8">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-16 h-16 rounded-[2rem] bg-gradient-to-br from-blue-500 to-blue-700 flex items-center justify-center text-white text-2xl font-black shadow-lg shadow-blue-500/20">
                            {{ strtoupper(substr($session->visitor_name ?? 'V', 0, 1)) }}
                        </div>
                        <div>
                            <div class="text-xl font-black text-slate-900 dark:text-white leading-tight uppercase">{{ $session->visitor_name ?? 'Visitante' }}</div>
                            <div class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-wider">{{ $session->type === 'public' ? 'Canal Público' : 'Canal Interno' }}</div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        @if($session->visitor_email)
                        <div class="group">
                            <label class="block text-[10px] font-black text-slate-300 dark:text-slate-600 uppercase tracking-widest mb-1.5 ml-0.5">E-mail</label>
                            <div class="flex items-center gap-3 px-4 py-3 bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-transparent group-hover:border-blue-100 dark:group-hover:border-blue-900/30 transition-all">
                                <x-icon name="envelope" style="duotone" class="w-4 h-4 text-blue-500" />
                                <span class="text-sm font-bold text-slate-700 dark:text-slate-300 truncate">{{ $session->visitor_email }}</span>
                            </div>
                        </div>
                        @endif

                        @if($session->visitor_phone)
                        <div class="group">
                            <label class="block text-[10px] font-black text-slate-300 dark:text-slate-600 uppercase tracking-widest mb-1.5 ml-0.5">Telefone</label>
                            <div class="flex items-center gap-3 px-4 py-3 bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-transparent group-hover:border-blue-100 dark:group-hover:border-blue-900/30 transition-all">
                                <x-icon name="phone" style="duotone" class="w-4 h-4 text-green-500" />
                                <span class="text-sm font-bold text-slate-700 dark:text-slate-300">{{ $session->visitor_phone }}</span>
                            </div>
                        </div>
                        @endif

                        @if($session->visitor_cpf)
                        <div class="group">
                            <label class="block text-[10px] font-black text-slate-300 dark:text-slate-600 uppercase tracking-widest mb-1.5 ml-0.5">CPF</label>
                            <div class="flex items-center gap-3 px-4 py-3 bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-transparent group-hover:border-blue-100 dark:group-hover:border-blue-900/30 transition-all">
                                <x-icon name="id-card" style="duotone" class="w-4 h-4 text-amber-500" />
                                <span class="text-sm font-bold text-slate-700 dark:text-slate-300">{{ \Modules\Chat\App\Helpers\CpfHelper::format($session->visitor_cpf) }}</span>
                            </div>
                        </div>
                        @endif

                        <div class="pt-4 grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-black text-slate-300 dark:text-slate-600 uppercase tracking-widest mb-1.5 ml-0.5">Iniciada</label>
                                <div class="text-sm font-black text-slate-700 dark:text-slate-300">{{ $session->created_at->format('d/m/Y') }}</div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $session->created_at->format('H:i') }}</div>
                            </div>
                            @if($session->closed_at)
                            <div>
                                <label class="block text-[10px] font-black text-slate-300 dark:text-slate-600 uppercase tracking-widest mb-1.5 ml-0.5">Encerrada</label>
                                <div class="text-sm font-black text-slate-700 dark:text-slate-300">{{ $session->closed_at->format('d/m/Y') }}</div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $session->closed_at->format('H:i') }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Agent Assignment -->
            @if($session->status !== 'closed')
            <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="px-8 py-5 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/50">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest flex items-center gap-2">
                        <x-icon name="headset" style="duotone" class="w-4 h-4 text-blue-500" />
                        {{ $session->assigned_to ? 'Transferir Atendimento' : 'Atribuir Atendente' }}
                    </h3>
                </div>
                <div class="p-8">
                    @if($session->assignedTo)
                    <div class="flex items-center gap-3 mb-6 p-4 bg-blue-50/50 dark:bg-blue-900/20 rounded-2xl border border-blue-100/50 dark:border-blue-900/30">
                        <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white font-black text-sm">
                            {{ strtoupper(substr($session->assignedTo->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="text-xs font-black text-slate-400 uppercase tracking-widest mb-0.5">Atendente Atual</div>
                            <div class="text-sm font-black text-slate-900 dark:text-white">{{ $session->assignedTo->name }}</div>
                        </div>
                    </div>
                    @endif

                    <form action="{{ route('admin.chat.assign', $session->id) }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <select name="assigned_to" class="w-full px-5 py-3.5 bg-slate-50 dark:bg-slate-900/50 border-slate-100 dark:border-slate-700 rounded-2xl text-sm font-bold text-slate-700 dark:text-slate-300 focus:ring-2 focus:ring-blue-600 transition-all">
                                <option value="">Selecione um atendente</option>
                                @foreach(\App\Models\User::whereHas('roles', function($q) { $q->whereIn('name', ['admin', 'co-admin']); })->get() as $user)
                                <option value="{{ $user->id }}" {{ $session->assigned_to == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-6 py-4 text-sm font-black text-white bg-slate-900 dark:bg-blue-600 rounded-2xl hover:bg-black dark:hover:bg-blue-700 transition-all shadow-lg active:scale-95">
                                <x-icon name="user-plus" style="duotone" class="w-4 h-4" />
                                {{ $session->assigned_to ? 'Confirmar Transferência' : 'Confirmar Atribuição' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
@vite(['resources/js/chat.js'])
<script>
window.BROADCAST_DRIVER = '{{ config("broadcasting.default") }}';
window.currentUserId = {{ auth()->id() ?? 'null' }};

window.CHAT_ROUTES = {
    getMessages: '{{ route("admin.chat.api.session.messages", $session->id) }}',
    sendMessage: '{{ route("admin.chat.api.session.message", $session->id) }}',
    markAsRead: '{{ route("admin.chat.api.session.read", $session->id) }}',
    typing: '{{ route("admin.chat.api.session.typing", $session->id) }}',
};

document.addEventListener('DOMContentLoaded', function() {
    if (typeof ChatSystem !== 'undefined') {
        ChatSystem.init(
            '{{ $session->session_id }}',
            {{ $session->id }},
            {{ auth()->id() ?? 'null' }}
        );
    }
});
</script>
@endpush
@endsection
