@extends('campo.layouts.app')

@section('title', 'Comunicação Tática')

@section('breadcrumbs')
    <x-icon name="chevron-right" class="w-2 h-2" />
    <span class="text-emerald-600">Canal de Comunicação Central</span>
@endsection

@section('content')
<div class="h-[calc(100vh-14rem)] flex flex-col space-y-8 animate-fade-in">
    <!-- Header de Canal -->
    <div class="flex items-center justify-between pb-6 border-b border-gray-200 dark:border-slate-800">
        <div class="flex items-center gap-5">
            <div class="w-14 h-14 bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl flex items-center justify-center text-white shadow-2xl transform rotate-3 hover:rotate-0 transition-all">
                <x-icon name="comment-dots" style="duotone" class="w-7 h-7" />
            </div>
            <div>
                <h1 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight uppercase leading-none">Chat de Comando</h1>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] mt-2 italic">Canal Direto com a Base e Operadores</p>
            </div>
        </div>

        <button onclick="abrirNovaConversa()" class="h-12 px-8 bg-indigo-600 text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-600/20 active:scale-95 flex items-center gap-2">
            <x-icon name="plus" class="w-4 h-4" />
            Nova Conversa
        </button>
    </div>

    <div class="flex-1 flex gap-8 min-h-0 overflow-hidden">
        <!-- Sidebar de Contatos (Lista de Conversas) -->
        <div class="w-80 flex flex-col premium-card overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-900/50 flex items-center justify-between">
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic">Conversas Ativas</span>
                <span id="online-status" class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            </div>

            <div id="lista-conversas" class="flex-1 overflow-y-auto custom-scrollbar divide-y divide-gray-50 dark:divide-slate-800/50">
                <div class="p-12 text-center">
                    <x-icon name="spinner" class="w-6 h-6 text-indigo-500 animate-spin mx-auto mb-4" />
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic">Sincronizando...</p>
                </div>
            </div>
        </div>

        <!-- Interface de Mensagens -->
        <div class="flex-1 flex flex-col premium-card overflow-hidden bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]">
            <!-- Topo da Conversa Selecionada -->
            <div id="chat-header" class="p-6 border-b border-gray-100 dark:border-slate-800 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md flex items-center justify-between z-10 hidden">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl flex items-center justify-center text-indigo-600 shadow-inner">
                        <x-icon name="user" style="duotone" class="w-6 h-6" />
                    </div>
                    <div>
                        <p id="chat-header-name" class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-tight">--</p>
                        <p id="chat-header-status" class="text-[9px] font-black text-emerald-500 uppercase tracking-widest mt-0.5">Disponível agora</p>
                    </div>
                </div>

                <div id="chat-header-context" class="hidden flex items-center gap-3 px-4 py-2 bg-slate-50 dark:bg-slate-800 rounded-xl border border-gray-100 dark:border-slate-700">
                    <x-icon name="link" class="w-3 h-3 text-indigo-500 font-black" />
                    <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest">Protocolo Relacionado</span>
                </div>
            </div>

            <!-- Área de Scroll de Balões -->
            <div id="chat-mensagens-container" class="flex-1 p-8 overflow-y-auto custom-scrollbar flex flex-col space-y-6">
                <div class="flex-1 flex flex-col items-center justify-center text-center py-20 animate-pulse">
                    <div class="w-24 h-24 bg-slate-100 dark:bg-slate-800 rounded-[2.5rem] flex items-center justify-center text-slate-300 dark:text-slate-700 mb-6 shadow-inner">
                        <x-icon name="comments" style="duotone" class="w-10 h-10" />
                    </div>
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] italic">Selecione uma Conversa</h3>
                    <p class="text-[10px] text-slate-500 font-medium mt-2">Escolha um canal à esquerda para iniciar a transmissão.</p>
                </div>
            </div>

            <!-- Input de Transmissão -->
            <div id="chat-input-container" class="p-6 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-t border-gray-100 dark:border-slate-800 z-10 hidden">
                <form id="chat-form" class="flex items-center gap-4">
                    <div class="flex-1 relative">
                        <input type="text" id="chat-message-input" placeholder="DIGITE SUA MENSAGEM TÁTICA..." class="w-full pl-6 pr-6 py-5 bg-gray-50 dark:bg-slate-950 border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 dark:text-white placeholder:text-slate-400 transition-all">
                    </div>
                    <button type="submit" class="w-16 h-16 bg-indigo-600 text-white rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-600/20 hover:bg-indigo-700 transition-all active:scale-95 group">
                        <x-icon name="paper-plane" class="w-6 h-6 group-hover:rotate-12 transition-transform" />
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nova Conversa Premium -->
<div id="modal-nova-conversa" class="hidden fixed inset-0 z-[100] bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-6 animate-fade-in">
    <div class="w-full max-w-lg bg-white dark:bg-slate-900 rounded-[3rem] shadow-2xl border border-white/10 overflow-hidden animate-scale-in">
        <div class="p-10 border-b border-gray-100 dark:border-slate-800 bg-indigo-500/5 flex items-center justify-between">
            <div class="flex items-center gap-6">
                <div class="w-14 h-14 bg-indigo-600 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-indigo-600/20">
                    <x-icon name="message-plus" style="duotone" class="w-7 h-7" />
                </div>
                <div>
                    <h2 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight">Novo Canal</h2>
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest italic mt-1">Sincronizar contato na rede</p>
                </div>
            </div>
            <button onclick="fecharModalNovaConversa()" class="w-12 h-12 rounded-2xl bg-gray-50 dark:bg-slate-800 text-slate-400 hover:text-rose-600 transition-colors flex items-center justify-center">
                <x-icon name="xmark" class="w-5 h-5" />
            </button>
        </div>

        <form id="form-nova-conversa" class="p-10 space-y-8">
            <div class="space-y-2">
                <label class="block text-[9px] font-black uppercase text-slate-400 tracking-widest mb-1 italic ml-2">Destinatário Alvo</label>
                <select id="usuario-select" required class="w-full p-5 bg-gray-50 dark:bg-slate-950 border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 dark:text-white transition-all appearance-none cursor-pointer">
                    <option value="">AGUARDANDO CONEXÃO...</option>
                </select>
            </div>

            <div class="space-y-2">
                <label class="block text-[9px] font-black uppercase text-slate-400 tracking-widest mb-1 italic ml-2">Transmissão Inicial</label>
                <textarea id="mensagem-inicial" required rows="4" placeholder="DIGITE O CONTEÚDO DA PRIMEIRA MENSAGEM..." class="w-full p-6 bg-gray-50 dark:bg-slate-950 border-gray-100 dark:border-slate-800 rounded-2xl text-xs font-medium text-slate-600 dark:text-slate-300 focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all"></textarea>
            </div>

            <div class="pt-4 flex gap-4">
                <button type="button" onclick="fecharModalNovaConversa()" class="flex-1 h-14 text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-rose-600 transition-colors">Abortar</button>
                <button type="submit" id="btn-criar-conversa" class="flex-[2] h-14 bg-indigo-600 text-white rounded-2xl text-[11px] font-black uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-600/20 active:scale-95">Inaugurar Canal</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    let sessaoAtual = null;

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    async function carregarConversas() {
        try {
            const res = await fetch('{{ route("campo.chat.index") }}', { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await res.json();
            if (data.success) {
                const container = document.getElementById('lista-conversas');
                const sessoes = data.sessoes.data || [];
                if (sessoes.length === 0) {
                    container.innerHTML = '<div class="p-12 text-center text-[10px] font-black text-slate-400 uppercase italic">Vazio</div>';
                    return;
                }

                container.innerHTML = sessoes.map(s => {
                    const nome = s.assigned_to ? s.assigned_to.name : 'Sistema';
                    const msg = s.last_message ? s.last_message.message : 'Nenhuma mensagem';
                    const active = s.session_id === sessaoAtual;
                    const unread = s.unread_count_user > 0;

                    return `
                        <div onclick="abrirConversa('${s.session_id}')" class="p-6 transition-all cursor-pointer ${active ? 'bg-indigo-500/10 border-l-4 border-indigo-500' : 'hover:bg-gray-50 dark:hover:bg-slate-800/30'}">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-[10px] font-black text-gray-900 dark:text-white uppercase tracking-tight truncate flex-1 ${unread ? 'text-indigo-600 dark:text-indigo-400' : ''}">${escapeHtml(nome)}</span>
                                ${unread ? `<span class="w-4 h-4 rounded-full bg-indigo-600 text-[10px] font-black text-white flex items-center justify-center">${s.unread_count_user}</span>` : ''}
                            </div>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest truncate italic">${escapeHtml(msg)}</p>
                        </div>
                    `;
                }).join('');
            }
        } catch (e) { console.error(e); }
    }

    async function abrirConversa(sid) {
        sessaoAtual = sid;
        document.getElementById('chat-header').classList.remove('hidden');
        document.getElementById('chat-input-container').classList.remove('hidden');

        try {
            const res = await fetch(`{{ route("campo.chat.messages", ":id") }}`.replace(':id', sid), { headers: { 'Accept': 'application/json' } });
            const data = await res.json();
            if (data.success) {
                // Atualizar Header
                const s = data.messages[0]?.sender || { name: 'Chat' };
                document.getElementById('chat-header-name').textContent = s.name;

                const container = document.getElementById('chat-mensagens-container');
                container.innerHTML = data.messages.map(m => {
                    const isMe = m.sender_type === 'user';
                    return `
                        <div class="flex ${isMe ? 'justify-end' : 'justify-start'} animate-fade-in">
                            <div class="max-w-[80%]">
                                <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest mb-1 italic ${isMe ? 'text-right' : ''}">${escapeHtml(isMe ? 'Você' : m.sender.name)}</p>
                                <div class="px-6 py-4 rounded-3xl ${isMe ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-gray-100 dark:border-slate-700 shadow-sm'}">
                                    <p class="text-xs font-medium leading-relaxed">${escapeHtml(m.message)}</p>
                                    <p class="text-[8px] font-black uppercase tracking-widest mt-2 opacity-50">${new Date(m.created_at).toLocaleTimeString('pt-BR', {hour:'2-digit', minute:'2-digit'})}</p>
                                </div>
                            </div>
                        </div>
                    `;
                }).join('');
                container.scrollTop = container.scrollHeight;
                carregarConversas(); // Sincroniza labels laterais (limpa unread)
            }
        } catch (e) { console.error(e); }
    }

    document.getElementById('chat-form').onsubmit = async (e) => {
        e.preventDefault();
        const input = document.getElementById('chat-message-input');
        const msg = input.value.trim();
        if (!msg || !sessaoAtual) return;

        try {
            const res = await fetch(`{{ route("campo.chat.send", ":id") }}`.replace(':id', sessaoAtual), {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ message: msg })
            });
            if ((await res.json()).success) {
                input.value = '';
                abrirConversa(sessaoAtual);
            }
        } catch (e) { console.error(e); }
    };

    async function abrirNovaConversa() {
        const modal = document.getElementById('modal-nova-conversa');
        modal.classList.remove('hidden');
        const select = document.getElementById('usuario-select');
        select.innerHTML = '<option>SINCRONIZANDO CANAIS...</option>';
        try {
            const res = await fetch('{{ route("campo.chat.users") }}', { headers: { 'Accept': 'application/json' } });
            const data = await res.json();
            if (data.users) {
                select.innerHTML = '<option value="">SELECIONE O ALVO DA TRANSMISSÃO...</option>' +
                    data.users.map(u => `<option value="${u.id}">${u.name.toUpperCase()} (${u.email.toUpperCase()})</option>`).join('');
            }
        } catch (e) { console.error(e); }
    }

    function fecharModalNovaConversa() { document.getElementById('modal-nova-conversa').classList.add('hidden'); }

    document.getElementById('form-nova-conversa').onsubmit = async (e) => {
        e.preventDefault();
        const uid = document.getElementById('usuario-select').value;
        const msg = document.getElementById('mensagem-inicial').value;
        const btn = document.getElementById('btn-criar-conversa');
        btn.disabled = true;
        try {
            const res = await fetch('{{ route("campo.chat.store") }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ assigned_to: uid, message: msg })
            });
            const data = await res.json();
            if (data.success) {
                fecharModalNovaConversa();
                await carregarConversas();
                abrirConversa(data.session.session_id);
            }
        } catch (e) { console.error(e); } finally { btn.disabled = false; }
    };

    document.addEventListener('DOMContentLoaded', () => {
        carregarConversas();
        setInterval(carregarConversas, 10000);

        // Verifica se veio de uma OS
        const urlParams = new URLSearchParams(window.location.search);
        const osNum = urlParams.get('os');
        if (osNum) {
            document.getElementById('chat-message-input').value = `SOBRE O PROTOCOLO #${osNum}: `;
            abrirNovaConversa();
        }
    });
</script>
@endpush
@endsection
