@extends('campo.layouts.app')

@section('title', 'Chat Interno')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-700">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Chat Interno</h1>
        <button onclick="abrirNovaConversa()" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition-colors">
            Nova Conversa
        </button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Lista de Conversas -->
        <div class="lg:col-span-1 bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="font-bold text-gray-900 dark:text-white">Conversas</h2>
            </div>
            <div id="lista-conversas" class="divide-y divide-gray-200 dark:divide-gray-700">
                <div class="p-4 text-center text-sm text-gray-500 dark:text-gray-400">
                    Carregando...
                </div>
            </div>
        </div>

        <!-- Área de Mensagens -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden flex flex-col">
            <div id="chat-mensagens-container" class="flex-1 p-6 overflow-y-auto min-h-[500px]">
                <div class="text-center text-gray-500 dark:text-gray-400 py-12">
                    Selecione uma conversa para começar
                </div>
            </div>
            <div id="chat-input-container" class="hidden p-4 border-t border-gray-200 dark:border-gray-700">
                <form id="chat-form" class="flex gap-3">
                    <input type="text" id="chat-message-input" placeholder="Digite sua mensagem..." class="flex-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-2">
                    <button type="submit" class="px-6 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition-colors">
                        Enviar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nova Conversa -->
<div id="modal-nova-conversa" class="fixed inset-0 z-[9999] hidden" style="display: none;">
    <!-- Background overlay -->
    <div class="fixed inset-0 bg-gray-900 bg-opacity-50" onclick="fecharModalNovaConversa()" style="z-index: 10000;"></div>

    <!-- Modal container -->
    <div class="fixed inset-0 flex items-center justify-center p-4" style="z-index: 10001; pointer-events: none;">
        <!-- Modal panel -->
        <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-lg p-6 pointer-events-auto max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                    Nova Conversa
                </h3>
                <button onclick="fecharModalNovaConversa()" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="form-nova-conversa" class="space-y-4">
                <!-- Seleção de Usuário -->
                <div>
                    <label for="usuario-select" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Selecionar Usuário
                    </label>
                    <select id="usuario-select" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Carregando usuários...</option>
                    </select>
                </div>

                <!-- Mensagem Inicial -->
                <div>
                    <label for="mensagem-inicial" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Mensagem Inicial
                    </label>
                    <textarea id="mensagem-inicial" rows="4" required placeholder="Digite sua mensagem inicial..." class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white px-4 py-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                </div>

                <!-- Botões -->
                <div class="flex gap-3 pt-4">
                    <button type="button" onclick="fecharModalNovaConversa()" class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" id="btn-criar-conversa" class="flex-1 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        Criar Conversa
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let sessaoAtual = null;

    /**
     * Escapar HTML para evitar XSS
     */
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    async function carregarConversas() {
        // Se offline, tentar carregar do cache
        if (!navigator.onLine) {
            await carregarConversasOffline();
            return;
        }

        try {
            const response = await fetch('{{ route("campo.chat.index") }}', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json',
                },
                credentials: 'same-origin'
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                const text = await response.text();
                console.error('Resposta não é JSON:', text.substring(0, 200));
                throw new Error('Resposta não é JSON');
            }
            
            const data = await response.json();

            if (data.success) {
                const container = document.getElementById('lista-conversas');
                const sessoes = data.sessoes.data || [];

                if (sessoes.length === 0) {
                    container.innerHTML = '<div class="p-4 text-center text-sm text-gray-500 dark:text-gray-400">Nenhuma conversa</div>';
                    return;
                }

                container.innerHTML = sessoes.map(sessao => {
                    const nomeDestinatario = sessao.assigned_to ? sessao.assigned_to.name : 'Sistema';
                    const ultimaMensagem = sessao.last_message ? sessao.last_message.message : 'Sem mensagens';
                    const temNaoLidas = sessao.unread_count_user > 0;
                    const isActive = sessao.session_id === sessaoAtual;
                    
                    return `
                        <div onclick="abrirConversa('${sessao.session_id}')" class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors ${isActive ? 'bg-indigo-50 dark:bg-indigo-900/20' : ''}">
                            <div class="flex items-center justify-between">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <p class="font-semibold text-gray-900 dark:text-white truncate ${temNaoLidas ? 'font-bold' : ''}">
                                            ${escapeHtml(nomeDestinatario)}
                                        </p>
                                        ${temNaoLidas ? `<span class="px-2 py-0.5 text-xs font-bold text-white bg-red-500 rounded-full">${sessao.unread_count_user}</span>` : ''}
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate mt-1">
                                        ${escapeHtml(ultimaMensagem.length > 50 ? ultimaMensagem.substring(0, 50) + '...' : ultimaMensagem)}
                                    </p>
                                    ${sessao.last_activity_at ? `<p class="text-xs text-gray-400 dark:text-gray-500 mt-1">${new Date(sessao.last_activity_at).toLocaleDateString('pt-BR')}</p>` : ''}
                                </div>
                            </div>
                        </div>
                    `;
                }).join('');
            }
        } catch (error) {
            console.error('Erro ao carregar conversas:', error);
        }
    }

    async function abrirConversa(sessionId) {
        sessaoAtual = sessionId;
        document.getElementById('chat-input-container').classList.remove('hidden');

        // Se offline, mostrar mensagem
        if (!navigator.onLine) {
            const container = document.getElementById('chat-mensagens-container');
            container.innerHTML = '<div class="text-center text-gray-500 dark:text-gray-400 py-12">Você está offline. Conecte-se à internet para visualizar mensagens.</div>';
            return;
        }

        try {
            const response = await fetch(`{{ route("campo.chat.messages", ":id") }}`.replace(':id', sessionId), {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin'
            });
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const data = await response.json();

            if (data.success) {
                const container = document.getElementById('chat-mensagens-container');
                const messages = data.messages || [];
                
                if (messages.length === 0) {
                    container.innerHTML = '<div class="text-center text-gray-500 dark:text-gray-400 py-12">Nenhuma mensagem ainda. Envie a primeira mensagem!</div>';
                } else {
                    container.innerHTML = messages.map(msg => {
                        const isUser = msg.sender_type === 'user';
                        const senderName = msg.sender ? msg.sender.name : (isUser ? 'Você' : 'Outro usuário');
                        const date = new Date(msg.created_at);
                        
                        return `
                            <div class="mb-4 flex ${isUser ? 'justify-end' : 'justify-start'}">
                                <div class="max-w-xs lg:max-w-md">
                                    ${!isUser ? `<p class="text-xs text-gray-500 dark:text-gray-400 mb-1 px-1">${escapeHtml(senderName)}</p>` : ''}
                                    <div class="px-4 py-2 rounded-lg ${isUser ? 'bg-indigo-600 text-white' : 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white'}">
                                        <p class="text-sm whitespace-pre-wrap">${escapeHtml(msg.message)}</p>
                                        <p class="text-xs mt-1 opacity-75">${date.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' })}</p>
                                    </div>
                                </div>
                            </div>
                        `;
                    }).join('');
                }
                container.scrollTop = container.scrollHeight;
            }
        } catch (error) {
            console.error('Erro ao carregar mensagens:', error);
        }
    }

    document.getElementById('chat-form')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        if (!sessaoAtual) return;

        const input = document.getElementById('chat-message-input');
        const message = input.value.trim();
        if (!message) return;

        // Bloquear envio se offline
        if (!navigator.onLine) {
            alert('Você está offline. Conecte-se à internet para enviar mensagens.');
            return;
        }

        try {
            const response = await fetch(`{{ route("campo.chat.send", ":id") }}`.replace(':id', sessaoAtual), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ message })
            });

            const data = await response.json();
            if (data.success) {
                input.value = '';
                abrirConversa(sessaoAtual);
            }
        } catch (error) {
            console.error('Erro ao enviar mensagem:', error);
        }
    });

    // ============================================
    // NOVA CONVERSA
    // ============================================
    let usuariosDisponiveis = [];

    async function abrirNovaConversa() {
        // Bloquear se offline
        if (!navigator.onLine) {
            alert('Você está offline. Conecte-se à internet para criar uma nova conversa.');
            return;
        }

        const modal = document.getElementById('modal-nova-conversa');
        if (!modal) {
            console.error('Modal não encontrado');
            alert('Erro: Modal não encontrado. Recarregue a página.');
            return;
        }
        
        // Remover classe hidden e garantir visibilidade
        modal.classList.remove('hidden');
        modal.style.display = 'block';
        
        // Prevenir scroll do body
        document.body.style.overflow = 'hidden';
        
        // Carregar usuários disponíveis
        await carregarUsuariosDisponiveis();
    }

    function fecharModalNovaConversa() {
        const modal = document.getElementById('modal-nova-conversa');
        if (!modal) return;
        
        // Adicionar classe hidden e esconder
        modal.classList.add('hidden');
        modal.style.display = 'none';
        
        // Restaurar scroll do body
        document.body.style.overflow = '';
        
        // Limpar formulário
        const selectUsuario = document.getElementById('usuario-select');
        const mensagemInicial = document.getElementById('mensagem-inicial');
        if (selectUsuario) selectUsuario.value = '';
        if (mensagemInicial) mensagemInicial.value = '';
    }

    async function carregarUsuariosDisponiveis() {
        const select = document.getElementById('usuario-select');
        select.innerHTML = '<option value="">Carregando usuários...</option>';
        select.disabled = true;

        // Se offline, tentar carregar do cache
        if (!navigator.onLine) {
            await carregarUsuariosDisponiveisOffline();
            return;
        }

        try {
            const response = await fetch('{{ route("campo.chat.users") }}', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin'
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            if (data.success && data.users) {
                usuariosDisponiveis = data.users;
                
                if (usuariosDisponiveis.length === 0) {
                    select.innerHTML = '<option value="">Nenhum usuário disponível</option>';
                } else {
                    select.innerHTML = '<option value="">Selecione um usuário...</option>';
                    usuariosDisponiveis.forEach(usuario => {
                        const option = document.createElement('option');
                        option.value = usuario.id;
                        option.textContent = usuario.name + (usuario.email ? ` (${usuario.email})` : '');
                        select.appendChild(option);
                    });
                }
                select.disabled = false;
            } else {
                throw new Error('Resposta inválida da API');
            }
        } catch (error) {
            console.error('Erro ao carregar usuários:', error);
            select.innerHTML = '<option value="">Erro ao carregar usuários</option>';
            select.disabled = true;
        }
    }

    // Formulário de nova conversa
    document.getElementById('form-nova-conversa')?.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const btnCriar = document.getElementById('btn-criar-conversa');
        const selectUsuario = document.getElementById('usuario-select');
        const mensagemInicial = document.getElementById('mensagem-inicial');
        
        const usuarioId = selectUsuario.value;
        const mensagem = mensagemInicial.value.trim();

        if (!usuarioId || !mensagem) {
            alert('Por favor, selecione um usuário e digite uma mensagem inicial.');
            return;
        }

        // Desabilitar botão
        btnCriar.disabled = true;
        btnCriar.textContent = 'Criando...';

        try {
            const response = await fetch('{{ route("campo.chat.store") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    assigned_to: parseInt(usuarioId),
                    message: mensagem
                })
            });

            if (!response.ok) {
                const errorData = await response.json().catch(() => ({}));
                throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            if (data.success && data.session) {
                // Fechar modal
                fecharModalNovaConversa();
                
                // Recarregar conversas
                await carregarConversas();
                
                // Abrir a nova conversa
                if (data.session.session_id) {
                    setTimeout(() => {
                        abrirConversa(data.session.session_id);
                    }, 500);
                }
            } else {
                throw new Error(data.error || 'Erro ao criar conversa');
            }
        } catch (error) {
            console.error('Erro ao criar conversa:', error);
            alert('Erro ao criar conversa: ' + error.message);
        } finally {
            // Reabilitar botão
            btnCriar.disabled = false;
            btnCriar.textContent = 'Criar Conversa';
        }
    });

    // Fechar modal com ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('modal-nova-conversa');
            if (modal && !modal.classList.contains('hidden')) {
                fecharModalNovaConversa();
            }
        }
    });

    // Função para carregar conversas offline do cache
    async function carregarConversasOffline() {
        try {
            if (window.campoOffline && window.campoOffline.db) {
                const db = window.campoOffline.db;
                const tx = db.transaction('chatSessionsCache', 'readonly');
                const store = tx.objectStore('chatSessionsCache');
                const request = store.getAll();

                request.onsuccess = () => {
                    const sessoes = request.result || [];
                    const container = document.getElementById('lista-conversas');

                    if (sessoes.length === 0) {
                        container.innerHTML = '<div class="p-4 text-center text-sm text-gray-500 dark:text-gray-400">Nenhuma conversa em cache offline</div>';
                        return;
                    }

                    container.innerHTML = sessoes.map(sessao => {
                        const nomeDestinatario = sessao.assigned_to ? sessao.assigned_to.name : 'Sistema';
                        const ultimaMensagem = sessao.last_message ? sessao.last_message.message : 'Sem mensagens';
                        const temNaoLidas = sessao.unread_count_user > 0;
                        
                        return `
                            <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors opacity-75">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2">
                                            <p class="font-semibold text-gray-900 dark:text-white truncate ${temNaoLidas ? 'font-bold' : ''}">
                                                ${escapeHtml(nomeDestinatario)}
                                            </p>
                                            ${temNaoLidas ? `<span class="px-2 py-0.5 text-xs font-bold text-white bg-red-500 rounded-full">${sessao.unread_count_user}</span>` : ''}
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate mt-1">
                                            ${escapeHtml(ultimaMensagem.length > 50 ? ultimaMensagem.substring(0, 50) + '...' : ultimaMensagem)}
                                        </p>
                                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">📴 Offline</p>
                                    </div>
                                </div>
                            </div>
                        `;
                    }).join('');
                };
            } else {
                const container = document.getElementById('lista-conversas');
                container.innerHTML = '<div class="p-4 text-center text-sm text-gray-500 dark:text-gray-400">Você está offline. Conecte-se para carregar conversas.</div>';
            }
        } catch (error) {
            console.error('Erro ao carregar conversas offline:', error);
        }
    }

    // Função para carregar usuários offline do cache
    async function carregarUsuariosDisponiveisOffline() {
        const select = document.getElementById('usuario-select');
        try {
            if (window.campoOffline && window.campoOffline.db) {
                const db = window.campoOffline.db;
                const tx = db.transaction('chatUsersCache', 'readonly');
                const store = tx.objectStore('chatUsersCache');
                const request = store.getAll();

                request.onsuccess = () => {
                    const users = request.result || [];
                    if (users.length === 0) {
                        select.innerHTML = '<option value="">Nenhum usuário em cache offline</option>';
                    } else {
                        select.innerHTML = '<option value="">Selecione um usuário (offline)...</option>';
                        users.forEach(usuario => {
                            const option = document.createElement('option');
                            option.value = usuario.id;
                            option.textContent = usuario.name + (usuario.email ? ` (${usuario.email})` : '') + ' 📴';
                            select.appendChild(option);
                        });
                    }
                    select.disabled = false;
                };
            } else {
                select.innerHTML = '<option value="">Offline - Conecte-se para carregar usuários</option>';
                select.disabled = true;
            }
        } catch (error) {
            console.error('Erro ao carregar usuários offline:', error);
            select.innerHTML = '<option value="">Erro ao carregar usuários offline</option>';
            select.disabled = true;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        carregarConversas();
        setInterval(carregarConversas, 30000);
        
        // Verificar se há um parâmetro de sessão na URL para abrir automaticamente
        const urlParams = new URLSearchParams(window.location.search);
        const sessionId = urlParams.get('session');
        if (sessionId && navigator.onLine) {
            // Aguardar um pouco para garantir que as conversas foram carregadas
            setTimeout(() => {
                abrirConversa(sessionId);
                // Remover o parâmetro da URL após abrir
                window.history.replaceState({}, document.title, window.location.pathname);
            }, 500);
        }
    });
</script>
@endpush
@endsection
