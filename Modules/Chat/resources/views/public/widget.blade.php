@php
$chatEnabled = \Nwidart\Modules\Facades\Module::isEnabled('Chat');
$publicEnabled = \Modules\Chat\App\Models\ChatConfig::isPublicEnabled();
@endphp
@if($chatEnabled && $publicEnabled)
<!-- Chat Widget SEMAGRI - Sistema 100% Interno -->
<div id="semagri-chat-widget" class="fixed" style="position: fixed !important; bottom: 6rem !important; right: 1.5rem !important; z-index: 9999 !important;">
    <!-- Botão Flutuante -->
    <button id="chat-toggle-btn"
            class="group relative w-16 h-16 bg-gradient-to-br from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 text-white rounded-[1.5rem] shadow-2xl hover:shadow-green-500/20 transition-all duration-300 flex items-center justify-center focus:outline-none focus:ring-4 focus:ring-green-500/20 transform hover:scale-110 active:scale-95 border-b-4 border-green-800"
            aria-label="Abrir chat de suporte">
        <!-- Ícone de Chat -->
        <span id="chat-icon" class="transition-all duration-300 group-hover:rotate-12">
            <x-icon name="comment-dots" style="duotone" class="w-7 h-7" />
        </span>
        <!-- Ícone de Fechar -->
        <span id="chat-close-icon" class="hidden transition-all duration-300 rotate-90">
            <x-icon name="xmark" class="w-7 h-7" />
        </span>
        <!-- Badge de Notificação -->
        <span id="chat-notification-badge" class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-black rounded-full w-6 h-6 flex items-center justify-center hidden animate-bounce border-2 border-white dark:border-slate-900 shadow-lg">1</span>
    </button>

    <!-- Janela do Chat -->
    <div id="chat-window" class="hidden fixed bg-white dark:bg-slate-800 rounded-[2.5rem] shadow-2xl border border-slate-100 dark:border-slate-700 flex flex-col overflow-hidden animate__animated animate__fadeInUp"
         style="bottom: 7.5rem !important; right: 1.5rem !important; width: 400px !important; max-width: calc(100vw - 2rem) !important; height: 650px !important; max-height: calc(100vh - 9rem) !important; z-index: 10000 !important;">

        <!-- Header -->
        <div class="flex items-center justify-between px-8 py-6 bg-gradient-to-br from-green-600 to-green-800 text-white flex-shrink-0 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -mr-16 -mt-16 blur-2xl"></div>
            <div class="relative z-10 flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center shadow-inner">
                    <x-icon name="headset" style="duotone" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <h3 class="font-black text-lg uppercase tracking-tight leading-none mb-1">Suporte SEMAGRI</h3>
                    <p id="chat-status-text" class="text-[10px] font-black uppercase tracking-widest text-green-100/80 flex items-center gap-2">
                        <span class="inline-block w-2 h-2 bg-green-300 rounded-full animate-pulse"></span>
                        Disponível Agora
                    </p>
                </div>
            </div>
            <button id="chat-minimize-btn" class="w-10 h-10 flex items-center justify-center text-white/80 hover:text-white hover:bg-white/10 rounded-xl transition-all active:scale-95 relative z-10">
                <x-icon name="chevron-down" class="w-5 h-5" />
            </button>
        </div>

        <!-- Mensagem Offline -->
        <div id="chat-offline-message" class="hidden px-8 py-10 text-center bg-amber-50 dark:bg-amber-900/10 border-b border-amber-100 dark:border-amber-800/30">
            <div class="w-16 h-16 mx-auto mb-5 bg-amber-100 dark:bg-amber-900/30 rounded-2xl flex items-center justify-center shadow-inner text-amber-500">
                <x-icon name="clock" style="duotone" class="w-8 h-8" />
            </div>
            <h4 class="text-lg font-black text-amber-900 dark:text-amber-200 uppercase tracking-tight mb-2">Fora de Horário</h4>
            <p class="text-[11px] font-bold text-amber-600 dark:text-amber-400 uppercase tracking-widest" id="chat-next-availability">Voltamos em breve!</p>
        </div>

        <!-- Formulário Inicial -->
        <div id="chat-initial-form" class="hidden px-8 py-8 bg-slate-50 dark:bg-slate-900/30 border-b border-slate-100 dark:border-slate-800/50">
            <div class="text-center mb-8">
                <h4 class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-tight mb-2">Bem-vindo!</h4>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Preencha os dados para iniciar</p>
            </div>
            <form id="chat-start-form" class="space-y-5">
                <div class="group">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nome Completo</label>
                    <div class="relative">
                        <x-icon name="user" class="absolute left-4 top-3.5 w-4 h-4 text-slate-300 group-focus-within:text-green-500 transition-colors" />
                        <input type="text" id="visitor-name" name="name" required
                            placeholder="Como podemos te chamar?"
                            class="w-full pl-11 pr-4 py-3.5 text-sm font-bold bg-white dark:bg-slate-800 border-slate-100 dark:border-slate-700 rounded-2xl focus:ring-4 focus:ring-green-500/10 focus:border-green-500 dark:text-white transition-all shadow-sm">
                    </div>
                </div>
                <div class="group">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">CPF</label>
                    <div class="relative">
                        <x-icon name="id-card" class="absolute left-4 top-3.5 w-4 h-4 text-slate-300 group-focus-within:text-green-500 transition-colors" />
                        <input type="text" id="visitor-cpf" name="cpf" required
                            placeholder="000.000.000-00" maxlength="14"
                            class="w-full pl-11 pr-4 py-3.5 text-sm font-bold bg-white dark:bg-slate-800 border-slate-100 dark:border-slate-700 rounded-2xl focus:ring-4 focus:ring-green-500/10 focus:border-green-500 dark:text-white transition-all shadow-sm">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="group">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">E-mail</label>
                        <input type="email" id="visitor-email" name="email"
                            placeholder="Opcional"
                            class="w-full px-5 py-3.5 text-sm font-bold bg-white dark:bg-slate-800 border-slate-100 dark:border-slate-700 rounded-2xl focus:ring-4 focus:ring-green-500/10 focus:border-green-500 dark:text-white transition-all shadow-sm">
                    </div>
                    <div class="group">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Telefone</label>
                        <input type="tel" id="visitor-phone" name="phone"
                            placeholder="Opcional"
                            class="w-full px-5 py-3.5 text-sm font-bold bg-white dark:bg-slate-800 border-slate-100 dark:border-slate-700 rounded-2xl focus:ring-4 focus:ring-green-500/10 focus:border-green-500 dark:text-white transition-all shadow-sm">
                    </div>
                </div>
                <button type="submit" id="chat-start-btn"
                        class="w-full mt-4 px-8 py-5 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white text-[11px] font-black uppercase tracking-widest rounded-2xl transition-all shadow-xl shadow-green-500/20 active:scale-95 border-b-4 border-green-800 flex items-center justify-center gap-3">
                    <span>Iniciar Atendimento</span>
                    <x-icon name="arrow-right" class="w-4 h-4" />
                </button>
            </form>
        </div>

        <!-- Área de Mensagens -->
        <div id="chat-messages-container" class="flex-1 overflow-y-auto p-6 space-y-4 bg-slate-50/50 dark:bg-slate-900/10 custom-scrollbar"
             style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%239C92AC\' fill-opacity=\'0.05\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
            <div id="chat-welcome-message" class="flex flex-col items-center justify-center h-full text-center py-12">
                <div class="w-20 h-20 bg-green-50 dark:bg-green-900/20 rounded-[2rem] flex items-center justify-center mb-6 border-2 border-dashed border-green-200 dark:border-green-700/50">
                    <x-icon name="message-heart" style="duotone" class="w-10 h-10 text-green-500" />
                </div>
                <h4 class="text-lg font-black text-slate-900 dark:text-white uppercase tracking-tight leading-none mb-2">Conectando...</h4>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Aguarde um momento</p>
            </div>
        </div>

        <!-- Indicador de Digitação -->
        <div id="chat-typing-indicator" class="hidden px-6 py-3 bg-white dark:bg-slate-800 border-t border-slate-100 dark:border-slate-700">
            <div class="flex items-center gap-3">
                <div class="flex gap-1.5 bg-slate-100 dark:bg-slate-900 p-2 rounded-xl">
                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-bounce" style="animation-delay: 0ms;"></span>
                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-bounce" style="animation-delay: 150ms;"></span>
                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-bounce" style="animation-delay: 300ms;"></span>
                </div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic animate-pulse">Atendente digitando...</span>
            </div>
        </div>

        <!-- Input de Mensagem -->
        <div id="chat-input-container" class="hidden px-6 py-5 border-t border-slate-100 dark:border-slate-700 bg-white dark:bg-slate-800 relative z-10 transition-all duration-300">
            <form id="chat-message-form" class="flex items-end gap-3 group">
                <div class="flex-1 relative">
                    <textarea id="chat-message-input"
                              rows="1"
                              placeholder="Digite aqui..."
                              class="w-full px-6 py-4 pr-12 text-sm font-bold bg-slate-50 dark:bg-slate-900/50 border-transparent focus:bg-white dark:focus:bg-slate-900 border-slate-100 dark:border-slate-700 rounded-2xl focus:ring-4 focus:ring-green-500/10 dark:text-white transition-all shadow-inner overflow-hidden resize-none"
                              style="max-height: 120px;"></textarea>
                </div>
                <button type="submit" id="chat-send-btn"
                        class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-green-500 to-green-700 hover:from-green-600 hover:to-green-800 text-white rounded-2xl flex items-center justify-center shadow-lg hover:shadow-green-500/20 transition-all transform hover:scale-105 active:scale-95 disabled:opacity-50 disabled:grayscale border-b-4 border-green-800">
                    <x-icon name="paper-plane" class="w-6 h-6" />
                </button>
            </form>
            <p class="text-[9px] font-black text-slate-300 dark:text-slate-600 uppercase tracking-widest text-center mt-3">
                Enter para enviar • Shift+Enter para nova linha
            </p>
        </div>

        <!-- Sessão Encerrada -->
        <div id="chat-session-closed" class="hidden px-8 py-10 bg-slate-50 dark:bg-slate-900/50 border-t border-slate-100 dark:border-slate-700 text-center animate__animated animate__fadeIn">
            <div class="w-16 h-16 mx-auto mb-6 bg-slate-100 dark:bg-slate-800 rounded-2xl flex items-center justify-center text-slate-400 shadow-inner">
                <x-icon name="check-double" style="duotone" class="w-8 h-8" />
            </div>
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-6">Esta conversa foi encerrada com sucesso.</p>
            <button id="chat-new-session-btn"
                    class="w-full py-4 text-[11px] font-black text-green-600 hover:text-white hover:bg-green-600 dark:text-green-400 dark:hover:text-white dark:hover:bg-green-600 rounded-2xl transition-all uppercase tracking-widest border-2 border-green-500/20 active:scale-95 shadow-sm">
                Iniciar Nova Conversa
            </button>
        </div>
    </div>
</div>

<!-- Som de notificação -->
<audio id="chat-notification-sound" preload="auto">
    <source src="/sounds/chat/notification.mp3" type="audio/mpeg">
</audio>

<style>
/* Estilos do Chat Widget */
#semagri-chat-widget .message-bubble {
    max-width: 85%;
    word-wrap: break-word;
    animation: chatFadeIn 0.3s ease;
}

#semagri-chat-widget .message-bubble.sent {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    margin-left: auto;
    border-radius: 20px 20px 4px 20px;
    color: white;
    font-weight: 500;
}

#semagri-chat-widget .message-bubble.received {
    background: white;
    margin-right: auto;
    border-radius: 20px 20px 20px 4px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    color: #1e293b;
    font-weight: 500;
}

.dark #semagri-chat-widget .message-bubble.received {
    background: #1e293b;
    color: #f8fafc;
    border: 1px solid #334155;
}

#semagri-chat-widget .message-bubble.system {
    background: rgba(148, 163, 184, 0.1);
    margin: 8px auto;
    border-radius: 99px;
    font-size: 10px;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    max-width: 90%;
    text-align: center;
    color: #64748b;
    border: 1px solid rgba(148, 163, 184, 0.1);
}

.dark #semagri-chat-widget .message-bubble.system {
    background: rgba(255, 255, 255, 0.05);
    color: #94a3b8;
}

@keyframes chatFadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Scrollbar personalizada */
#chat-messages-container::-webkit-scrollbar {
    width: 6px;
}

#chat-messages-container::-webkit-scrollbar-track {
    background: transparent;
}

#chat-messages-container::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

.dark #chat-messages-container::-webkit-scrollbar-thumb {
    background: #475569;
}

/* Máscara de CPF */
#visitor-cpf {
    font-variant-numeric: tabular-nums;
}
</style>

<script>
(function() {
    'use strict';

    // Evitar inicialização duplicada
    if (window.semagriChatInitialized) return;
    window.semagriChatInitialized = true;

    // Configuração
    const POLLING_INTERVAL = 3000;
    const ROUTES = {
        status: '{{ route("chat.status") }}',
        start: '{{ route("chat.start") }}',
        session: (id) => `/chat/session/${id}`,
        message: (id) => `/chat/session/${id}/message`,
    };

    // Estado
    const state = {
            isOpen: false,
            sessionId: null,
            isAvailable: false,
        lastMessageId: 0,
            pollInterval: null,
            notificationSound: null,
    };

    // Elementos DOM
    const elements = {
        toggleBtn: null,
        chatWindow: null,
        chatIcon: null,
        closeIcon: null,
        minimizeBtn: null,
        offlineMessage: null,
        initialForm: null,
        startForm: null,
        messagesContainer: null,
        welcomeMessage: null,
        inputContainer: null,
        messageForm: null,
        messageInput: null,
        sendBtn: null,
        sessionClosed: null,
        newSessionBtn: null,
        notificationBadge: null,
        typingIndicator: null,
        statusText: null,
        nextAvailability: null,
    };

    // Inicialização
    function init() {
        cacheElements();
        setupEventListeners();
        setupCpfMask();
        restoreSession();
    }

    // Cache de elementos
    function cacheElements() {
        elements.toggleBtn = document.getElementById('chat-toggle-btn');
        elements.chatWindow = document.getElementById('chat-window');
        elements.chatIcon = document.getElementById('chat-icon');
        elements.closeIcon = document.getElementById('chat-close-icon');
        elements.minimizeBtn = document.getElementById('chat-minimize-btn');
        elements.offlineMessage = document.getElementById('chat-offline-message');
        elements.initialForm = document.getElementById('chat-initial-form');
        elements.startForm = document.getElementById('chat-start-form');
        elements.messagesContainer = document.getElementById('chat-messages-container');
        elements.welcomeMessage = document.getElementById('chat-welcome-message');
        elements.inputContainer = document.getElementById('chat-input-container');
        elements.messageForm = document.getElementById('chat-message-form');
        elements.messageInput = document.getElementById('chat-message-input');
        elements.sendBtn = document.getElementById('chat-send-btn');
        elements.sessionClosed = document.getElementById('chat-session-closed');
        elements.newSessionBtn = document.getElementById('chat-new-session-btn');
        elements.notificationBadge = document.getElementById('chat-notification-badge');
        elements.typingIndicator = document.getElementById('chat-typing-indicator');
        elements.statusText = document.getElementById('chat-status-text');
        elements.nextAvailability = document.getElementById('chat-next-availability');
        state.notificationSound = document.getElementById('chat-notification-sound');
    }

    // Event Listeners
    function setupEventListeners() {
        if (elements.toggleBtn) {
            elements.toggleBtn.addEventListener('click', toggleChat);
        }

        if (elements.minimizeBtn) {
            elements.minimizeBtn.addEventListener('click', toggleChat);
        }

        if (elements.startForm) {
            elements.startForm.addEventListener('submit', handleStartChat);
        }

        if (elements.messageForm) {
            elements.messageForm.addEventListener('submit', handleSendMessage);
        }

        if (elements.messageInput) {
            elements.messageInput.addEventListener('input', handleInputResize);
            elements.messageInput.addEventListener('keydown', handleInputKeydown);
        }

        if (elements.newSessionBtn) {
            elements.newSessionBtn.addEventListener('click', handleNewSession);
        }
    }

    // Máscara de CPF
    function setupCpfMask() {
        const cpfInput = document.getElementById('visitor-cpf');
        if (cpfInput) {
            cpfInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 11) value = value.slice(0, 11);

                if (value.length > 9) {
                    value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
                } else if (value.length > 6) {
                    value = value.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
                } else if (value.length > 3) {
                    value = value.replace(/(\d{3})(\d{1,3})/, '$1.$2');
                }

                e.target.value = value;
            });
        }
    }

    // Toggle chat
    function toggleChat() {
        state.isOpen = !state.isOpen;

        if (state.isOpen) {
            elements.chatWindow?.classList.remove('hidden');
            elements.chatIcon?.classList.add('hidden');
            elements.closeIcon?.classList.remove('hidden');
            elements.notificationBadge?.classList.add('hidden');

            checkAvailability().then(() => {
                if (state.sessionId) {
                    showChatInterface();
                    loadMessages();
                    startPolling();
                } else if (state.isAvailable) {
                    showInitialForm();
                } else {
                    showOfflineMessage();
                }
            });
        } else {
            elements.chatWindow?.classList.add('hidden');
            elements.chatIcon?.classList.remove('hidden');
            elements.closeIcon?.classList.add('hidden');
            stopPolling();
        }
    }

    // Verificar disponibilidade
    async function checkAvailability() {
        try {
            const response = await fetch(ROUTES.status);
            const data = await response.json();

            state.isAvailable = data.available || false;

            if (elements.statusText) {
                if (state.isAvailable) {
                    elements.statusText.innerHTML = '<span class="inline-block w-2 h-2 bg-green-300 rounded-full mr-1 animate-pulse"></span>Online';
                } else {
                    elements.statusText.innerHTML = '<span class="inline-block w-2 h-2 bg-amber-300 rounded-full mr-1"></span>Offline';
                }
            }

            if (!state.isAvailable && data.next_availability && elements.nextAvailability) {
                elements.nextAvailability.textContent = `Próxima disponibilidade: ${data.next_availability.day} às ${data.next_availability.time}`;
            }
        } catch (error) {
            console.error('Erro ao verificar disponibilidade:', error);
            state.isAvailable = true; // Assumir disponível em caso de erro
        }
    }

    // Restaurar sessão
    async function restoreSession() {
        const savedSessionId = localStorage.getItem('semagri_chat_session');
        if (!savedSessionId) return;

        try {
            const response = await fetch(ROUTES.session(savedSessionId), {
                headers: { 'Accept': 'application/json' }
            });

            if (response.ok) {
                const data = await response.json();
                if (data.success && data.session && data.session.status !== 'closed') {
                    state.sessionId = savedSessionId;
                }
            }

            if (!state.sessionId) {
                localStorage.removeItem('semagri_chat_session');
            }
        } catch (error) {
            console.error('Erro ao restaurar sessão:', error);
        }
    }

    // Iniciar chat
    async function handleStartChat(e) {
        e.preventDefault();

        const name = document.getElementById('visitor-name')?.value.trim();
        const cpf = document.getElementById('visitor-cpf')?.value.replace(/\D/g, '');
        const email = document.getElementById('visitor-email')?.value.trim();
        const phone = document.getElementById('visitor-phone')?.value.trim();

            if (!name) {
            showAlert('Por favor, informe seu nome completo.');
                return;
            }

            if (!cpf || cpf.length !== 11) {
            showAlert('Por favor, informe um CPF válido com 11 dígitos.');
                return;
            }

        const startBtn = document.getElementById('chat-start-btn');
        if (startBtn) {
            startBtn.disabled = true;
            startBtn.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
            }

            try {
            const response = await fetch(ROUTES.start, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    },
                body: JSON.stringify({ name, cpf, email, phone }),
                });

                const data = await response.json();

                if (data.success) {
                state.sessionId = data.session_id;
                localStorage.setItem('semagri_chat_session', state.sessionId);
                showChatInterface();
                loadMessages();
                startPolling();
            } else if (response.status === 409 && data.existing_session_id) {
                // Sessão existente
                state.sessionId = data.existing_session_id;
                localStorage.setItem('semagri_chat_session', state.sessionId);
                showChatInterface();
                loadMessages();
                startPolling();
                showAlert('Você já possui uma conversa ativa. Continuando com a sessão anterior.');
            } else {
                showAlert(data.message || 'Erro ao iniciar o chat. Tente novamente.');
            }
        } catch (error) {
            console.error('Erro ao iniciar chat:', error);
            showAlert('Erro ao iniciar o chat. Tente novamente.');
        } finally {
            if (startBtn) {
                startBtn.disabled = false;
                startBtn.innerHTML = '<span>Iniciar Conversa</span><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" /></svg>';
            }
        }
    }

    // Enviar mensagem
    async function handleSendMessage(e) {
        e.preventDefault();

        if (!state.sessionId || !elements.messageInput) return;

        const message = elements.messageInput.value.trim();
        if (!message) return;

        elements.messageInput.disabled = true;
        if (elements.sendBtn) elements.sendBtn.disabled = true;

        const originalValue = elements.messageInput.value;
        elements.messageInput.value = '';
        elements.messageInput.style.height = 'auto';

        try {
            const response = await fetch(ROUTES.message(state.sessionId), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                },
                body: JSON.stringify({ message }),
            });

            const data = await response.json();

            if (data.success) {
                appendMessage(data.message);
                scrollToBottom();
            } else {
                elements.messageInput.value = originalValue;

                if (data.message?.includes('encerrada')) {
                    handleSessionClosed();
                    } else {
                    showAlert(data.message || 'Erro ao enviar mensagem.');
                }
            }
        } catch (error) {
            console.error('Erro ao enviar mensagem:', error);
            elements.messageInput.value = originalValue;
            showAlert('Erro ao enviar mensagem. Tente novamente.');
        } finally {
            elements.messageInput.disabled = false;
            if (elements.sendBtn) elements.sendBtn.disabled = false;
            elements.messageInput.focus();
        }
    }

    // Carregar mensagens
    async function loadMessages() {
        if (!state.sessionId) return;

        try {
            const response = await fetch(ROUTES.session(state.sessionId), {
                headers: { 'Accept': 'application/json' }
                });

                if (!response.ok) {
                if (response.status === 404 || response.status === 403) {
                    handleSessionClosed();
                    }
                    return;
                }

                const data = await response.json();

            if (data.success && data.messages) {
                // Verificar se sessão foi encerrada
                if (data.session?.status === 'closed') {
                    handleSessionClosed();
                    return;
                }

                const previousCount = state.lastMessageId;
                let hasNewFromAgent = false;

                // Limpar container se for primeira carga
                if (previousCount === 0 && elements.messagesContainer) {
                    elements.messagesContainer.innerHTML = '';
                }

                data.messages.forEach(msg => {
                    if (msg.id > state.lastMessageId) {
                        appendMessage(msg);
                        state.lastMessageId = msg.id;

                        if (msg.sender_type === 'user' && previousCount > 0) {
                            hasNewFromAgent = true;
                        }
                    }
                });

                if (hasNewFromAgent && !state.isOpen) {
                    showNotificationBadge();
                    playNotificationSound();
                } else if (hasNewFromAgent) {
                    playNotificationSound();
                }

                scrollToBottom();
            }
        } catch (error) {
            console.error('Erro ao carregar mensagens:', error);
        }
    }

    // Adicionar mensagem ao DOM
    function appendMessage(msg) {
        if (!elements.messagesContainer) return;

        // Verificar se já existe
        if (elements.messagesContainer.querySelector(`[data-message-id="${msg.id}"]`)) return;

        const isSent = msg.sender_type === 'visitor';
            const isSystem = msg.sender_type === 'system';

        const wrapper = document.createElement('div');
        wrapper.className = `flex ${isSent ? 'justify-end' : (isSystem ? 'justify-center' : 'justify-start')}`;
        wrapper.setAttribute('data-message-id', msg.id);

        const time = new Date(msg.created_at).toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });

        if (isSystem) {
            wrapper.innerHTML = `
                <div class="message-bubble system px-4 py-2">
                    <p class="text-gray-600 dark:text-gray-400">${escapeHtml(msg.message)}</p>
                </div>
            `;
        } else {
            wrapper.innerHTML = `
                <div class="message-bubble ${isSent ? 'sent' : 'received'} px-4 py-2.5 shadow-sm">
                    <p class="text-sm whitespace-pre-wrap break-words text-gray-900 dark:text-white">${escapeHtml(msg.message)}</p>
                    <div class="flex items-center justify-end gap-1 mt-1">
                        <span class="text-xs opacity-60">${time}</span>
                        ${isSent ? `
                        <svg class="w-4 h-4 ${msg.is_read ? 'text-blue-500' : 'opacity-60'}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                        ` : ''}
                    </div>
                </div>
            `;
        }

        elements.messagesContainer.appendChild(wrapper);
    }

    // UI Helpers
    function showInitialForm() {
        elements.offlineMessage?.classList.add('hidden');
        elements.initialForm?.classList.remove('hidden');
        elements.messagesContainer?.classList.add('hidden');
        elements.welcomeMessage?.classList.add('hidden');
        elements.inputContainer?.classList.add('hidden');
        elements.sessionClosed?.classList.add('hidden');
    }

    function showOfflineMessage() {
        elements.offlineMessage?.classList.remove('hidden');
        elements.initialForm?.classList.add('hidden');
        elements.messagesContainer?.classList.add('hidden');
        elements.welcomeMessage?.classList.add('hidden');
        elements.inputContainer?.classList.add('hidden');
        elements.sessionClosed?.classList.add('hidden');
    }

    function showChatInterface() {
        elements.offlineMessage?.classList.add('hidden');
        elements.initialForm?.classList.add('hidden');
        elements.messagesContainer?.classList.remove('hidden');
        elements.welcomeMessage?.classList.add('hidden');
        elements.inputContainer?.classList.remove('hidden');
        elements.sessionClosed?.classList.add('hidden');
    }

    function handleSessionClosed() {
        localStorage.removeItem('semagri_chat_session');
        state.sessionId = null;
        state.lastMessageId = 0;
        stopPolling();

        elements.inputContainer?.classList.add('hidden');
        elements.sessionClosed?.classList.remove('hidden');
    }

    function handleNewSession() {
        localStorage.removeItem('semagri_chat_session');
        state.sessionId = null;
        state.lastMessageId = 0;

        if (elements.messagesContainer) {
            elements.messagesContainer.innerHTML = '';
        }

        if (state.isAvailable) {
            showInitialForm();
        } else {
            showOfflineMessage();
        }
    }

    function handleInputResize() {
        if (elements.messageInput) {
            elements.messageInput.style.height = 'auto';
            elements.messageInput.style.height = Math.min(elements.messageInput.scrollHeight, 100) + 'px';
        }
    }

    function handleInputKeydown(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            elements.messageForm?.dispatchEvent(new Event('submit'));
        }
    }

    function showNotificationBadge() {
        if (elements.notificationBadge) {
            elements.notificationBadge.classList.remove('hidden');
        }
    }

    function playNotificationSound() {
        if (state.notificationSound && !document.hidden) {
            state.notificationSound.currentTime = 0;
            state.notificationSound.play().catch(() => {});
        }
    }

    function scrollToBottom() {
        if (elements.messagesContainer) {
            elements.messagesContainer.scrollTop = elements.messagesContainer.scrollHeight;
        }
    }

    // Polling
    function startPolling() {
        stopPolling();
        state.pollInterval = setInterval(loadMessages, POLLING_INTERVAL);
    }

    function stopPolling() {
        if (state.pollInterval) {
            clearInterval(state.pollInterval);
            state.pollInterval = null;
        }
    }

    // Utilitários
    function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

    function showAlert(message) {
        // Toast simples
        const toast = document.createElement('div');
        toast.className = 'fixed bottom-20 right-4 px-4 py-3 bg-gray-900 text-white text-sm rounded-lg shadow-lg z-[10001] animate-pulse';
        toast.textContent = message;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transition = 'opacity 0.3s';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // Pausar polling quando aba não está visível
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            stopPolling();
        } else if (state.sessionId && state.isOpen) {
            loadMessages();
            startPolling();
        }
    });

    // Cleanup
    window.addEventListener('beforeunload', stopPolling);

    // Inicializar quando DOM estiver pronto
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
</script>
@endif
