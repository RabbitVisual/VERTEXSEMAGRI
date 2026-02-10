@extends('Co-Admin.layouts.app')

@section('title', 'Sessão de Chat - ' . ($session->visitor_name ?? 'Visitante'))

@section('content')
<div class="space-y-8 animate__animated animate__fadeIn pb-12">
    <!-- Page Header -->
    <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-[2.5rem] p-8 md:p-10 shadow-sm border border-slate-100 dark:border-slate-700 transition-all duration-300">
        <div class="absolute top-0 right-0 w-80 h-80 bg-green-50/50 dark:bg-green-900/10 rounded-full -mr-40 -mt-40 blur-3xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-8">
            <div class="flex items-center gap-5">
                <a href="{{ route('co-admin.chat.index') }}"
                   class="w-12 h-12 bg-slate-100 dark:bg-slate-700 rounded-2xl flex items-center justify-center text-slate-600 dark:text-slate-300 hover:bg-green-600 hover:text-white transition-all active:scale-95 group">
                    <x-icon name="arrow-left" class="w-5 h-5 group-hover:-translate-x-1 transition-transform" />
                </a>
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <h1 class="text-3xl md:text-4xl font-black text-slate-900 dark:text-white tracking-tight leading-none">
                            {{ $session->visitor_name ?? 'Visitante' }}
                        </h1>
                        @php
                            $statusConfig = [
                                'waiting' => ['bg' => 'bg-amber-100/50 text-amber-600', 'label' => 'Aguardando'],
                                'active' => ['bg' => 'bg-green-100/50 text-green-600', 'label' => 'Em Atendimento'],
                                'closed' => ['bg' => 'bg-slate-100 text-slate-500', 'label' => 'Encerrado'],
                            ];
                            $s = $statusConfig[$session->status] ?? ['bg' => 'bg-slate-100', 'label' => $session->status];
                        @endphp
                        <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full {{ $s['bg'] }}">
                            {{ $s['label'] }}
                        </span>
                    </div>
                    <nav aria-label="breadcrumb" class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400">
                        <x-icon name="id-card" class="w-3 h-3" />
                        <span>Sessão: #{{ $session->id }}</span>
                        <span class="mx-1">•</span>
                        <span>{{ $session->created_at->format('d/m/Y H:i') }}</span>
                    </nav>
                </div>
            </div>

            <div class="flex items-center gap-3">
                @if($session->status !== 'closed')
                <form action="{{ route('co-admin.chat.close', $session->id) }}" method="POST" onsubmit="return confirm('Encerrar esta sessão?')">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-3 px-8 py-4 text-sm font-black text-white bg-red-600 rounded-2xl hover:bg-red-700 shadow-xl shadow-red-500/20 transition-all active:scale-95 border-b-4 border-red-800 uppercase tracking-widest group">
                        <x-icon name="xmark" class="w-5 h-5 group-hover:rotate-90 transition-transform" />
                        Encerrar Chat
                    </button>
                </form>
                @else
                <form action="{{ route('co-admin.chat.reopen', $session->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-3 px-8 py-4 text-sm font-black text-white bg-green-600 rounded-2xl hover:bg-green-700 shadow-xl shadow-green-500/20 transition-all active:scale-95 border-b-4 border-green-800 uppercase tracking-widest group">
                        <x-icon name="rotate-right" class="w-5 h-5 group-hover:rotate-180 transition-transform" />
                        Reabrir
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Main Chat Area -->
        <div class="lg:col-span-8 space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden flex flex-col h-[700px]">
                <!-- Chat Header -->
                <div class="px-8 py-6 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/50 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-green-500 flex items-center justify-center text-white shadow-lg shadow-green-500/20">
                            <x-icon name="comments" style="duotone" class="w-5 h-5" />
                        </div>
                        <h3 class="text-lg font-black text-slate-900 dark:text-white uppercase tracking-tight">Histórico</h3>
                    </div>
                    <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                        {{ $session->messages->count() }} Mensagens
                    </div>
                </div>

                <!-- Messages Container -->
                <div id="chat-messages-container" class="flex-1 p-8 overflow-y-auto space-y-6 bg-slate-50/30 dark:bg-slate-900/10 custom-scrollbar" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%239C92AC\' fill-opacity=\'0.05\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                    @forelse($session->messages as $message)
                        @if($message->sender_type === 'system')
                            <div class="flex justify-center">
                                <div class="px-6 py-2 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-[10px] font-black uppercase tracking-widest border border-slate-200/50 dark:border-slate-700 shadow-sm">
                                    {{ $message->message }}
                                    <span class="ml-2 opacity-50">{{ $message->created_at->format('H:i') }}</span>
                                </div>
                            </div>
                        @else
                            <div class="flex {{ $message->sender_type === 'user' ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-[80%] group">
                                    <div class="flex items-center gap-2 mb-2 {{ $message->sender_type === 'user' ? 'justify-end' : '' }}">
                                        @if($message->sender_type !== 'user')
                                            <div class="w-6 h-6 rounded-lg bg-green-500 flex items-center justify-center text-[10px] font-black text-white shadow-sm">
                                                {{ strtoupper(substr($message->sender_name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $message->sender_name }}</span>
                                        <span class="text-[9px] font-black text-slate-300 uppercase">{{ $message->created_at->format('H:i') }}</span>
                                        @if($message->sender_type === 'user')
                                            <div class="w-6 h-6 rounded-lg bg-slate-900 dark:bg-green-600 flex items-center justify-center text-[10px] font-black text-white shadow-sm">
                                                {{ strtoupper(substr($message->sender_name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="relative px-6 py-4 rounded-3xl shadow-sm border {{ $message->sender_type === 'user' ? 'bg-slate-900 dark:bg-green-600 text-white border-slate-800 dark:border-green-500 rounded-tr-none' : 'bg-white dark:bg-slate-800 text-slate-900 dark:text-white border-slate-100 dark:border-slate-700 rounded-tl-none' }}">
                                        <p class="text-sm font-medium leading-relaxed whitespace-pre-wrap break-words">{{ $message->message }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="h-full flex flex-col items-center justify-center text-center p-12">
                            <div class="w-20 h-20 bg-slate-100 dark:bg-slate-800/50 rounded-3xl flex items-center justify-center mb-6 border-2 border-dashed border-slate-200 dark:border-slate-700">
                                <x-icon name="message-slash" class="w-10 h-10 text-slate-300" />
                            </div>
                            <h4 class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-tight mb-2">Sem Mensagens</h4>
                            <p class="text-slate-400 text-sm max-w-[250px]">Nenhuma interação foi registrada nesta sessão até o momento.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Message Input -->
                @if($session->status !== 'closed')
                <div class="p-8 border-t border-slate-100 dark:border-slate-700 bg-white dark:bg-slate-800">
                    <form id="message-form" class="relative group">
                        @csrf
                        <input type="text" id="message-input" autocomplete="off" placeholder="Escreva sua resposta aqui..."
                               class="w-full bg-slate-50 dark:bg-slate-900/50 border-slate-100 dark:border-slate-700 rounded-2xl focus:ring-4 focus:ring-green-500/10 focus:bg-white dark:focus:bg-slate-900 text-slate-900 dark:text-white text-sm font-bold pl-6 pr-32 py-5 transition-all shadow-inner">
                        <button type="submit" class="absolute right-2 top-2 bottom-2 px-6 bg-slate-900 dark:bg-green-600 text-white rounded-xl font-black text-xs uppercase tracking-widest hover:bg-black dark:hover:bg-green-700 transition-all active:scale-95 shadow-lg group">
                            <span>Enviar</span>
                            <x-icon name="paper-plane" class="w-4 h-4 ml-2 inline group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform" />
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="lg:col-span-4 space-y-8">
            <!-- Visitor Info Card -->
            <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="p-8 space-y-8">
                    <div class="flex flex-col items-center text-center">
                        <div class="w-24 h-24 rounded-[2rem] bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-4xl font-black shadow-xl shadow-blue-500/20 mb-6">
                            {{ strtoupper(substr($session->visitor_name ?? 'V', 0, 1)) }}
                        </div>
                        <h3 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight uppercase leading-none mb-2">
                            {{ $session->visitor_name ?? 'Visitante' }}
                        </h3>
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-slate-50 dark:bg-slate-900 text-[10px] font-black uppercase tracking-widest text-slate-400 border border-slate-100 dark:border-slate-800">
                            <span class="w-2 h-2 rounded-full @if($session->status === 'active') bg-green-500 animate-pulse @else bg-slate-300 @endif"></span>
                            {{ $session->status_texto }}
                        </div>
                    </div>

                    <div class="space-y-4 pt-8 border-t border-slate-50 dark:border-slate-700/50">
                        @if($session->visitor_cpf)
                        <div class="flex items-center gap-4 group">
                            <div class="w-12 h-12 bg-slate-50 dark:bg-slate-900 rounded-2xl flex items-center justify-center text-slate-400 group-hover:bg-green-50 group-hover:text-green-600 transition-colors">
                                <x-icon name="id-card" style="duotone" class="w-5 h-5" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">CPF do Visitante</p>
                                <p class="text-sm font-bold text-slate-700 dark:text-slate-300">{{ \Modules\Chat\App\Helpers\CpfHelper::format($session->visitor_cpf) }}</p>
                            </div>
                        </div>
                        @endif

                        @if($session->visitor_email)
                        <div class="flex items-center gap-4 group">
                            <div class="w-12 h-12 bg-slate-50 dark:bg-slate-900 rounded-2xl flex items-center justify-center text-slate-400 group-hover:bg-green-50 group-hover:text-green-600 transition-colors">
                                <x-icon name="envelope" style="duotone" class="w-5 h-5" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">E-mail</p>
                                <p class="text-sm font-bold text-slate-700 dark:text-slate-300 truncate">{{ $session->visitor_email }}</p>
                            </div>
                        </div>
                        @endif

                        <div class="flex items-center gap-4 group">
                            <div class="w-12 h-12 bg-slate-50 dark:bg-slate-900 rounded-2xl flex items-center justify-center text-slate-400 group-hover:bg-green-50 group-hover:text-green-600 transition-colors">
                                <x-icon name="clock" style="duotone" class="w-5 h-5" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Duração</p>
                                <p class="text-sm font-bold text-slate-700 dark:text-slate-300">{{ $session->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assignment Card -->
            <div class="bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/50">
                    <h3 class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-widest flex items-center gap-2">
                        <x-icon name="user-plus" style="duotone" class="w-4 h-4 text-green-500" />
                        Atribuir Atendente
                    </h3>
                </div>
                <div class="p-8">
                    @if($session->assignedTo)
                        <div class="flex items-center gap-4 mb-8 p-4 bg-slate-50 dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800">
                            <div class="w-12 h-12 rounded-xl bg-slate-200 dark:bg-slate-800 flex items-center justify-center text-slate-600 font-black text-lg">
                                {{ strtoupper(substr($session->assignedTo->name, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-0.5">Responsável Atual</p>
                                <p class="text-sm font-black text-slate-900 dark:text-white truncate uppercase tracking-tight">{{ $session->assignedTo->name }}</p>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-6 bg-slate-50 dark:bg-slate-900/50 rounded-3xl border border-dashed border-slate-200 dark:border-slate-800 mb-8">
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Ninguém Atribuído</p>
                        </div>
                    @endif

                    @if($session->status !== 'closed')
                        <form action="{{ route('co-admin.chat.assign', $session->id) }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-5 pointer-events-none text-slate-400 group-focus-within:text-green-500 transition-colors">
                                    <x-icon name="users" style="duotone" class="w-4 h-4" />
                                </div>
                                <select name="assigned_to" required
                                        class="w-full bg-slate-50 dark:bg-slate-900 border-slate-100 dark:border-slate-800 rounded-2xl focus:ring-4 focus:ring-green-500/10 text-slate-900 dark:text-white text-xs font-black uppercase tracking-widest pl-12 p-4 transition-all appearance-none">
                                    <option value="">Trocar Atendente</option>
                                    @foreach($agents as $agent)
                                        <option value="{{ $agent->id }}" {{ $session->assigned_to == $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-300">
                                    <x-icon name="chevron-down" class="w-3 h-3" />
                                </div>
                            </div>
                            <button type="submit" class="w-full py-5 bg-slate-900 dark:bg-green-600 text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-black dark:hover:bg-green-700 transition-all shadow-xl shadow-green-500/10 active:scale-95 border-b-4 border-slate-700 dark:border-green-800">
                                {{ $session->assignedTo ? 'Transferir Chat' : 'Assumir Chat' }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if($session->status !== 'closed')
@push('scripts')
<script>
(function() {
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]')?.content || '';
    const sessionId = {{ $session->id }};
    let lastMessageId = {{ $session->messages->last()?->id ?? 0 }};
    let pollInterval = null;

    const messageForm = document.getElementById('message-form');
    const messageInput = document.getElementById('message-input');
    const messagesContainer = document.getElementById('chat-messages-container');

    // Enviar mensagem
    if (messageForm) {
        messageForm.addEventListener('submit', async function(e) {
            e.preventDefault();

            const message = messageInput.value.trim();
            if (!message) return;

            messageInput.disabled = true;
            const originalValue = messageInput.value;
            messageInput.value = '';

            try {
                const response = await fetch(`{{ url('co-admin/chat') }}/${sessionId}/api/message`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                    },
                    body: JSON.stringify({ message }),
                });

                const data = await response.json();

                if (data.success) {
                    appendMessage(data.message);
                    scrollToBottom();
                } else {
                    messageInput.value = originalValue;
                    alert(data.message || 'Erro ao enviar mensagem');
                }
            } catch (error) {
                console.error('Erro:', error);
                messageInput.value = originalValue;
                alert('Erro ao enviar mensagem');
            } finally {
                messageInput.disabled = false;
                messageInput.focus();
            }
        });
    }

    // Polling para novas mensagens
    async function checkNewMessages() {
        try {
            const response = await fetch(`{{ url('co-admin/chat') }}/${sessionId}/api/messages?last_id=${lastMessageId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                },
            });

            const data = await response.json();

            if (data.success && data.messages && data.messages.length > 0) {
                data.messages.forEach(msg => {
                    if (msg.id > lastMessageId) {
                        appendMessage(msg);
                        lastMessageId = msg.id;
                    }
                });
                scrollToBottom();
            }
        } catch (error) {
            console.error('Erro ao verificar mensagens:', error);
        }
    }

    function appendMessage(msg) {
        if (!messagesContainer) return;
        if (messagesContainer.querySelector(`[data-message-id="${msg.id}"]`)) return;

        const isSent = msg.sender_type === 'user';
        const isSystem = msg.sender_type === 'system';

        const wrapper = document.createElement('div');
        wrapper.className = `flex ${isSent ? 'justify-end' : (isSystem ? 'justify-center' : 'justify-start')}`;
        wrapper.setAttribute('data-message-id', msg.id);

        const time = new Date(msg.created_at).toLocaleString('pt-BR', { hour: '2-digit', minute: '2-digit' });
        const senderName = msg.sender_name || (isSent ? 'Você' : 'Visitante');

        if (isSystem) {
            wrapper.innerHTML = `
                <div class="px-6 py-2 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-[10px] font-black uppercase tracking-widest border border-slate-200/50 dark:border-slate-700 shadow-sm">
                    ${escapeHtml(msg.message)}
                    <span class="ml-2 opacity-50">${time}</span>
                </div>
            `;
        } else {
            wrapper.innerHTML = `
                <div class="max-w-[80%] group">
                    <div class="flex items-center gap-2 mb-2 ${isSent ? 'justify-end' : ''}">
                        ${!isSent ? `
                            <div class="w-6 h-6 rounded-lg bg-green-500 flex items-center justify-center text-[10px] font-black text-white shadow-sm">
                                ${escapeHtml(senderName.substring(0,1).toUpperCase())}
                            </div>
                        ` : ''}
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">${escapeHtml(senderName)}</span>
                        <span class="text-[9px] font-black text-slate-300 uppercase">${time}</span>
                        ${isSent ? `
                            <div class="w-6 h-6 rounded-lg bg-slate-900 dark:bg-green-600 flex items-center justify-center text-[10px] font-black text-white shadow-sm">
                                ${escapeHtml(senderName.substring(0,1).toUpperCase())}
                            </div>
                        ` : ''}
                    </div>
                    <div class="relative px-6 py-4 rounded-3xl shadow-sm border ${isSent ? 'bg-slate-900 dark:bg-green-600 text-white border-slate-800 dark:border-green-500 rounded-tr-none' : 'bg-white dark:bg-slate-800 text-slate-900 dark:text-white border-slate-100 dark:border-slate-700 rounded-tl-none'}">
                        <p class="text-sm font-medium leading-relaxed whitespace-pre-wrap break-words">${escapeHtml(msg.message)}</p>
                    </div>
                </div>
            `;
        }

        messagesContainer.appendChild(wrapper);
    }

    function scrollToBottom() {
        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Iniciar polling
    scrollToBottom();
    pollInterval = setInterval(checkNewMessages, 3000);

    // Cleanup
    window.addEventListener('beforeunload', () => {
        if (pollInterval) clearInterval(pollInterval);
    });
})();
</script>
@endpush
@endif
@endsection
