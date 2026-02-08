/**
 * SEMAGRI Campo - Sistema Offline Profissional
 *
 * Gerenciamento de dados offline com:
 * - UUID único para cada ação (evita duplicatas)
 * - Verificação de integridade (hash)
 * - Auditoria vinculada ao funcionário
 * - Sincronização idempotente
 * - Cache completo de dados necessários
 * - Suporte para Chat, Relatórios e todas as melhorias
 *
 * @version 5.1.0
 * @date 2026-01-30
 */

// Sistema de Logging Condicional - Apenas em desenvolvimento
// Verificar se já foi declarado para evitar erro de redeclaração
if (typeof window.isDevelopment === 'undefined') {
    window.isDevelopment = window.location.hostname === 'localhost' ||
        window.location.hostname === '127.0.0.1' ||
        window.location.hostname.includes('.local') ||
        localStorage.getItem('campo_debug') === 'true';
}

// Forçar silêncio em produção se não estiver explicitamente em debug
if (!window.isDevelopment) {
    // Sobrescrever console apenas se não for dev
    // window.console.log = function() {};
    // Não sobrescrevemos o console nativo para não quebrar outras libs,
    // mas nosso logger respeitará a flag.
}

if (typeof window.logger === 'undefined') {
    window.logger = {
        log: (...args) => window.isDevelopment && console.log(...args),
        warn: (...args) => window.isDevelopment && console.warn(...args),
        error: (...args) => console.error(...args), // Erros sempre são logados
        info: (...args) => window.isDevelopment && console.info(...args)
    };
}

// Manter compatibilidade com código que usa logger diretamente
const isDevelopment = window.isDevelopment;
const logger = window.logger;

class CampoOfflineManager {
    constructor() {
        this.dbName = 'SemagriCampoDB';
        this.dbVersion = 3; // Incrementado para incluir chat e outras funcionalidades
        this.db = null;
        this.isOnline = navigator.onLine;
        this.syncInProgress = false;
        this.deviceId = this.getOrCreateDeviceId();
        this.userId = null;
        this.userName = null;

        this.init();
    }

    /**
     * Gera ou recupera um ID único do dispositivo
     */
    getOrCreateDeviceId() {
        let deviceId = localStorage.getItem('semagri_device_id');
        if (!deviceId) {
            deviceId = 'device_' + this.generateUUID();
            localStorage.setItem('semagri_device_id', deviceId);
        }
        return deviceId;
    }

    /**
     * Gera UUID v4 único
     */
    generateUUID() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
            const r = Math.random() * 16 | 0;
            const v = c === 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
        });
    }

    /**
     * Gera hash SHA-256 para verificação de integridade
     */
    async generateHash(data) {
        const msgBuffer = new TextEncoder().encode(JSON.stringify(data));
        const hashBuffer = await crypto.subtle.digest('SHA-256', msgBuffer);
        const hashArray = Array.from(new Uint8Array(hashBuffer));
        return hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
    }

    async init() {
        try {
            // Inicializar IndexedDB
            await this.openDatabase();

            // Registrar Service Worker
            await this.registerServiceWorker();

            // Configurar listeners de conexão
            this.setupConnectionListeners();

            // Atualizar UI de status
            this.updateConnectionStatus();

            // Se online, sincronizar dados pendentes e pré-carregar
            if (this.isOnline) {
                await this.syncPendingData();
                // Pré-carregar todos os dados na primeira visita
                await this.preloadAllData();
            }

            logger.log('[Campo Offline] Sistema inicializado v3.0 - PWA 100% Offline');
            logger.log('[Campo Offline] Device ID:', this.deviceId);

        } catch (error) {
            logger.error('[Campo Offline] Erro na inicialização:', error);
        }
    }

    /**
     * Pré-carregar todos os dados necessários para funcionamento offline
     */
    async preloadAllData() {
        const lastPreload = localStorage.getItem('last_preload');
        const now = Date.now();
        const oneDay = 24 * 60 * 60 * 1000;

        // Pré-carregar apenas se passou mais de 1 dia ou nunca foi feito
        if (lastPreload && (now - parseInt(lastPreload)) < oneDay) {
            logger.log('[Campo Offline] Pré-carregamento recente, pulando...');
            return;
        }

        logger.log('[Campo Offline] 🚀 Iniciando pré-carregamento completo de dados...');
        this.showNotification('Pré-carregando dados para uso offline...', 'info');

        try {
            // 1. Pré-carregar Ordens
            await this.preloadOrdens();

            // 2. Pré-carregar Materiais
            await this.preloadMateriais();

            // 3. Pré-carregar Localidades
            await this.preloadLocalidades();

            // 4. Pré-carregar Equipes
            await this.preloadEquipes();

            // 5. Pré-carregar Perfil do Usuário
            await this.preloadUserProfile();

            // 6. Pré-carregar Chat (se online)
            if (this.isOnline) {
                await this.preloadChat();
            }

            // Marcar último pré-carregamento
            localStorage.setItem('last_preload', now.toString());

            logger.log('[Campo Offline] ✅ Pré-carregamento completo! PWA 100% offline habilitada.');
            this.showNotification('✅ Dados pré-carregados! O app funciona 100% offline agora.', 'success');

        } catch (error) {
            logger.error('[Campo Offline] ❌ Erro no pré-carregamento:', error);
            this.showNotification('⚠️ Erro ao pré-carregar alguns dados. Tente novamente.', 'warning');
        }
    }

    /**
     * Pré-carregar ordens de serviço
     */
    async preloadOrdens() {
        try {
            const response = await fetch('/api/v1/campo/ordens', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            if (response.ok) {
                const data = await response.json();
                const ordens = data.data || data.ordens || [];

                for (const ordem of ordens) {
                    await this.saveOrdem(ordem);
                }

                logger.log(`[Campo Offline] ✅ ${ordens.length} ordens pré-carregadas`);
            }
        } catch (error) {
            logger.warn('[Campo Offline] ⚠️ Erro ao pré-carregar ordens:', error);
        }
    }

    /**
     * Pré-carregar materiais
     */
    async preloadMateriais() {
        try {
            const response = await fetch('/api/v1/campo/materiais', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            if (response.ok) {
                const data = await response.json();
                const materiais = data.data || data.materiais || [];

                for (const material of materiais) {
                    await this.saveMaterial(material);
                }

                logger.log(`[Campo Offline] ✅ ${materiais.length} materiais pré-carregados`);
            }
        } catch (error) {
            logger.warn('[Campo Offline] ⚠️ Erro ao pré-carregar materiais:', error);
        }
    }

    /**
     * Pré-carregar localidades
     */
    async preloadLocalidades() {
        try {
            const response = await fetch('/api/v1/campo/localidades', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            if (response.ok) {
                const data = await response.json();
                const localidades = data.data || data.localidades || [];

                if (!this.db) await this.openDatabase();

                return new Promise((resolve, reject) => {
                    const tx = this.db.transaction('localidadesCache', 'readwrite');
                    const store = tx.objectStore('localidadesCache');

                    localidades.forEach(loc => {
                        store.put(loc);
                    });

                    tx.oncomplete = () => {
                        logger.log(`[Campo Offline] ✅ ${localidades.length} localidades pré-carregadas`);
                        resolve();
                    };
                    tx.onerror = () => reject(tx.error);
                });
            }
        } catch (error) {
            logger.warn('[Campo Offline] ⚠️ Erro ao pré-carregar localidades:', error);
        }
    }

    /**
     * Pré-carregar equipes
     */
    async preloadEquipes() {
        try {
            const response = await fetch('/api/v1/campo/equipes', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            });

            if (response.ok) {
                const data = await response.json();
                const equipes = data.data || data.equipes || [];

                if (!this.db) await this.openDatabase();

                // Criar store de equipes se não existir
                if (!this.db.objectStoreNames.contains('equipesCache')) {
                    const tx = this.db.transaction(['equipesCache'], 'readwrite');
                    const store = tx.objectStore('equipesCache');
                    // Store será criado no onupgradeneeded
                }

                return new Promise((resolve, reject) => {
                    if (!this.db.objectStoreNames.contains('equipesCache')) {
                        resolve(); // Store não existe ainda, será criado no próximo upgrade
                        return;
                    }

                    const tx = this.db.transaction('equipesCache', 'readwrite');
                    const store = tx.objectStore('equipesCache');

                    equipes.forEach(equipe => {
                        store.put(equipe);
                    });

                    tx.oncomplete = () => {
                        logger.log(`[Campo Offline] ✅ ${equipes.length} equipes pré-carregadas`);
                        resolve();
                    };
                    tx.onerror = () => reject(tx.error);
                });
            }
        } catch (error) {
            logger.warn('[Campo Offline] ⚠️ Erro ao pré-carregar equipes:', error);
        }
    }

    /**
     * Pré-carregar dados do perfil do usuário
     */
    async preloadUserProfile() {
        try {
            if (!this.db) await this.openDatabase();

            // Buscar dados do usuário da página atual ou fazer requisição
            const userData = {
                id: window.currentUserId || null,
                name: window.currentUserName || null,
                email: window.currentUserEmail || null,
                photo: window.currentUserPhoto || null,
                phone: window.currentUserPhone || null,
                updatedAt: new Date().toISOString()
            };

            // Se não tiver dados na página, tentar buscar via API
            if (!userData.id) {
                try {
                    const response = await fetch('/api/campo/profile', {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        credentials: 'same-origin'
                    });

                    if (response.ok) {
                        const data = await response.json();
                        Object.assign(userData, data);
                    }
                } catch (e) {
                    // Se não conseguir buscar, usar dados do localStorage
                    const cached = localStorage.getItem('user_profile');
                    if (cached) {
                        Object.assign(userData, JSON.parse(cached));
                    }
                }
            }

            if (userData.id) {
                const tx = this.db.transaction(['userProfileCache'], 'readwrite');
                const store = tx.objectStore('userProfileCache');
                await store.put(userData);

                // Também salvar no localStorage como backup
                localStorage.setItem('user_profile', JSON.stringify(userData));

                logger.log('[Campo Offline] ✅ Perfil do usuário pré-carregado');
            }
        } catch (error) {
            logger.warn('[Campo Offline] ⚠️ Erro ao pré-carregar perfil:', error);
        }
    }

    /**
     * Pré-carregar dados de chat
     */
    async preloadChat() {
        try {
            // Pré-carregar conversas
            await this.preloadChatSessions();

            // Pré-carregar usuários disponíveis
            await this.preloadChatUsers();

            logger.log('[Campo Offline] ✅ Chat pré-carregado');
        } catch (error) {
            logger.warn('[Campo Offline] ⚠️ Erro ao pré-carregar chat:', error);
        }
    }

    /**
     * Pré-carregar sessões de chat
     */
    async preloadChatSessions() {
        try {
            const response = await fetch('/campo/chat', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin'
            });

            if (response.ok) {
                const data = await response.json();
                if (data.success && data.sessoes && data.sessoes.data) {
                    const sessoes = data.sessoes.data;

                    if (!this.db) await this.openDatabase();

                    const tx = this.db.transaction('chatSessionsCache', 'readwrite');
                    const store = tx.objectStore('chatSessionsCache');

                    for (const sessao of sessoes) {
                        sessao.updatedAt = Date.now();
                        await store.put(sessao);
                    }

                    logger.log(`[Campo Offline] ✅ ${sessoes.length} sessões de chat pré-carregadas`);
                }
            }
        } catch (error) {
            logger.warn('[Campo Offline] ⚠️ Erro ao pré-carregar sessões de chat:', error);
        }
    }

    /**
     * Pré-carregar usuários disponíveis para chat
     */
    async preloadChatUsers() {
        try {
            const response = await fetch('/campo/chat/users', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'same-origin'
            });

            if (response.ok) {
                const data = await response.json();
                if (data.success && data.users) {
                    const users = data.users;

                    if (!this.db) await this.openDatabase();

                    const tx = this.db.transaction('chatUsersCache', 'readwrite');
                    const store = tx.objectStore('chatUsersCache');

                    for (const user of users) {
                        user.updatedAt = Date.now();
                        await store.put(user);
                    }

                    logger.log(`[Campo Offline] ✅ ${users.length} usuários de chat pré-carregados`);
                }
            }
        } catch (error) {
            logger.warn('[Campo Offline] ⚠️ Erro ao pré-carregar usuários de chat:', error);
        }
    }

    /**
     * Obter dados do perfil do cache
     */
    async getUserProfile() {
        try {
            if (!this.db) await this.openDatabase();

            const tx = this.db.transaction(['userProfileCache'], 'readonly');
            const store = tx.objectStore('userProfileCache');
            const request = store.getAll();

            return new Promise((resolve, reject) => {
                request.onsuccess = () => {
                    const profiles = request.result;
                    if (profiles.length > 0) {
                        resolve(profiles[0]);
                    } else {
                        // Tentar do localStorage
                        const cached = localStorage.getItem('user_profile');
                        resolve(cached ? JSON.parse(cached) : null);
                    }
                };
                request.onerror = () => {
                    const cached = localStorage.getItem('user_profile');
                    resolve(cached ? JSON.parse(cached) : null);
                };
            });
        } catch (error) {
            logger.warn('[Campo Offline] Erro ao obter perfil:', error);
            const cached = localStorage.getItem('user_profile');
            return cached ? JSON.parse(cached) : null;
        }
    }

    async openDatabase() {
        return new Promise((resolve, reject) => {
            const request = indexedDB.open(this.dbName, this.dbVersion);

            request.onerror = () => {
                logger.error('[Campo Offline] Erro ao abrir IndexedDB:', request.error);
                reject(request.error);
            };

            request.onsuccess = () => {
                this.db = request.result;
                logger.log('[Campo Offline] IndexedDB aberto com sucesso');
                resolve(this.db);
            };

            request.onupgradeneeded = (event) => {
                const db = event.target.result;

                // Store para ordens em cache
                if (!db.objectStoreNames.contains('ordensCache')) {
                    const ordensStore = db.createObjectStore('ordensCache', { keyPath: 'id' });
                    ordensStore.createIndex('status', 'status', { unique: false });
                    ordensStore.createIndex('updatedAt', 'updatedAt', { unique: false });
                }

                // Store para materiais em cache
                if (!db.objectStoreNames.contains('materiaisCache')) {
                    db.createObjectStore('materiaisCache', { keyPath: 'id' });
                }

                // Store para localidades em cache
                if (!db.objectStoreNames.contains('localidadesCache')) {
                    db.createObjectStore('localidadesCache', { keyPath: 'id' });
                }

                // Store para equipes em cache
                if (!db.objectStoreNames.contains('equipesCache')) {
                    db.createObjectStore('equipesCache', { keyPath: 'id' });
                }

                // Store para fotos pendentes
                if (!db.objectStoreNames.contains('fotosPendentes')) {
                    const fotosStore = db.createObjectStore('fotosPendentes', {
                        keyPath: 'uuid'  // Usar UUID como chave primária
                    });
                    fotosStore.createIndex('ordemId', 'ordemId', { unique: false });
                    fotosStore.createIndex('synced', 'synced', { unique: false });
                }

                // Store para ações pendentes (com UUID)
                if (!db.objectStoreNames.contains('pendingActions')) {
                    const actionsStore = db.createObjectStore('pendingActions', {
                        keyPath: 'uuid'  // UUID como chave primária
                    });
                    actionsStore.createIndex('synced', 'synced', { unique: false });
                    actionsStore.createIndex('type', 'type', { unique: false });
                    actionsStore.createIndex('timestamp', 'timestamp', { unique: false });
                }

                // Store para histórico de sincronizações
                if (!db.objectStoreNames.contains('syncHistory')) {
                    const historyStore = db.createObjectStore('syncHistory', {
                        keyPath: 'uuid'
                    });
                    historyStore.createIndex('syncedAt', 'syncedAt', { unique: false });
                }

                // Store para dados do perfil do usuário
                if (!db.objectStoreNames.contains('userProfileCache')) {
                    const profileStore = db.createObjectStore('userProfileCache', {
                        keyPath: 'id'
                    });
                    profileStore.createIndex('updatedAt', 'updatedAt', { unique: false });
                }

                // Store para cache de conversas de chat
                if (!db.objectStoreNames.contains('chatSessionsCache')) {
                    const chatStore = db.createObjectStore('chatSessionsCache', {
                        keyPath: 'session_id'
                    });
                    chatStore.createIndex('updatedAt', 'updatedAt', { unique: false });
                    chatStore.createIndex('assigned_to', 'assigned_to', { unique: false });
                }

                // Store para cache de mensagens de chat
                if (!db.objectStoreNames.contains('chatMessagesCache')) {
                    const messagesStore = db.createObjectStore('chatMessagesCache', {
                        keyPath: 'id',
                        autoIncrement: true
                    });
                    messagesStore.createIndex('session_id', 'session_id', { unique: false });
                    messagesStore.createIndex('created_at', 'created_at', { unique: false });
                }

                // Store para cache de usuários disponíveis para chat
                if (!db.objectStoreNames.contains('chatUsersCache')) {
                    const usersStore = db.createObjectStore('chatUsersCache', {
                        keyPath: 'id'
                    });
                    usersStore.createIndex('updatedAt', 'updatedAt', { unique: false });
                }

                // Migrar dados antigos se existir pendingSync
                if (db.objectStoreNames.contains('pendingSync')) {
                    // A migração será feita após o upgrade
                    logger.log('[Campo Offline] Migração de dados pendentes será realizada');
                }

                logger.log('[Campo Offline] Estrutura do banco criada/atualizada v3');
            };
        });
    }

    async registerServiceWorker() {
        if ('serviceWorker' in navigator) {
            try {
                const registration = await navigator.serviceWorker.register('/sw.js', {
                    scope: '/'
                });

                logger.log('[Campo Offline] Service Worker registrado:', registration.scope);

                // Escutar mensagens do SW
                navigator.serviceWorker.addEventListener('message', (event) => {
                    if (event.data && event.data.type === 'SYNC_COMPLETE') {
                        this.onSyncComplete();
                    }
                });

            } catch (error) {
                logger.error('[Campo Offline] Erro ao registrar Service Worker:', error);
            }
        }
    }

    setupConnectionListeners() {
        window.addEventListener('online', () => {
            this.isOnline = true;
            this.updateConnectionStatus();
            this.showNotification('Conexão restabelecida! Sincronizando...', 'success');
            this.syncPendingData();
        });

        window.addEventListener('offline', () => {
            this.isOnline = false;
            this.updateConnectionStatus();
            this.showNotification('Você está offline. Dados serão salvos localmente.', 'warning');
        });
    }

    updateConnectionStatus() {
        const statusBadge = document.getElementById('connection-status');

        if (statusBadge) {
            if (this.isOnline) {
                statusBadge.className = 'connection-badge online';
                statusBadge.innerHTML = `
                    <span class="status-dot"></span>
                    <span>Online</span>
                `;
            } else {
                statusBadge.className = 'connection-badge offline';
                statusBadge.innerHTML = `
                    <span class="status-dot"></span>
                    <span>Offline</span>
                `;
            }
        }

        this.updatePendingCount();
    }

    async updatePendingCount() {
        const pendingBadge = document.getElementById('pending-count-badge');
        if (!pendingBadge || !this.db) return;

        try {
            const tx = this.db.transaction('pendingActions', 'readonly');
            const store = tx.objectStore('pendingActions');
            const request = store.getAll();

            request.onsuccess = () => {
                const items = request.result || [];
                const count = items.filter(item => !item.synced).length;
                if (count > 0) {
                    pendingBadge.textContent = count;
                    pendingBadge.classList.remove('hidden');
                } else {
                    pendingBadge.classList.add('hidden');
                }
            };
        } catch (error) {
            logger.warn('[Campo Offline] Erro ao contar pendentes:', error);
        }
    }

    // === OPERAÇÕES CRUD COM SUPORTE OFFLINE ===

    async saveOrdem(ordem) {
        if (!this.db) await this.openDatabase();

        return new Promise((resolve, reject) => {
            const tx = this.db.transaction('ordensCache', 'readwrite');
            const store = tx.objectStore('ordensCache');
            ordem.updatedAt = Date.now();
            ordem.cachedAt = new Date().toISOString();
            const request = store.put(ordem);

            request.onsuccess = () => resolve(ordem);
            request.onerror = () => reject(request.error);
        });
    }

    async getOrdem(id) {
        if (!this.db) await this.openDatabase();

        return new Promise((resolve, reject) => {
            const tx = this.db.transaction('ordensCache', 'readonly');
            const store = tx.objectStore('ordensCache');
            const request = store.get(id);

            request.onsuccess = () => resolve(request.result);
            request.onerror = () => reject(request.error);
        });
    }

    async getAllOrdens() {
        if (!this.db) await this.openDatabase();

        return new Promise((resolve, reject) => {
            const tx = this.db.transaction('ordensCache', 'readonly');
            const store = tx.objectStore('ordensCache');
            const request = store.getAll();

            request.onsuccess = () => resolve(request.result || []);
            request.onerror = () => reject(request.error);
        });
    }

    async saveMaterial(material) {
        if (!this.db) await this.openDatabase();

        return new Promise((resolve, reject) => {
            const tx = this.db.transaction('materiaisCache', 'readwrite');
            const store = tx.objectStore('materiaisCache');
            const request = store.put(material);

            request.onsuccess = () => resolve(material);
            request.onerror = () => reject(request.error);
        });
    }

    async getAllMateriais() {
        if (!this.db) await this.openDatabase();

        return new Promise((resolve, reject) => {
            const tx = this.db.transaction('materiaisCache', 'readonly');
            const store = tx.objectStore('materiaisCache');
            const request = store.getAll();

            request.onsuccess = () => resolve(request.result || []);
            request.onerror = () => reject(request.error);
        });
    }

    // === AÇÕES OFFLINE COM UUID ===

    /**
     * Enfileira uma ação para sincronização posterior
     * Cada ação tem UUID único para garantir idempotência
     */
    async queueAction(type, data) {
        if (!this.db) await this.openDatabase();

        const uuid = this.generateUUID();
        const timestamp = Date.now();
        const hash = await this.generateHash({ type, data, timestamp });

        const action = {
            uuid,
            type,
            data,
            timestamp,
            hash,
            synced: false,
            attempts: 0,
            createdAt: new Date().toISOString(),
            deviceId: this.deviceId,
        };

        return new Promise((resolve, reject) => {
            const tx = this.db.transaction('pendingActions', 'readwrite');
            const store = tx.objectStore('pendingActions');
            const request = store.add(action);

            request.onsuccess = () => {
                this.updatePendingCount();
                logger.log(`[Campo Offline] Ação enfileirada: ${type} (${uuid})`);
                resolve(uuid);
            };
            request.onerror = () => reject(request.error);
        });
    }

    /**
     * Salva foto offline com UUID único
     */
    async saveFotoOffline(ordemId, fotoData, tipo) {
        if (!this.db) await this.openDatabase();

        const uuid = this.generateUUID();

        const foto = {
            uuid,
            ordemId,
            data: fotoData,
            tipo, // 'antes' ou 'depois'
            timestamp: Date.now(),
            synced: false,
            deviceId: this.deviceId,
        };

        return new Promise((resolve, reject) => {
            const tx = this.db.transaction('fotosPendentes', 'readwrite');
            const store = tx.objectStore('fotosPendentes');
            const request = store.add(foto);

            request.onsuccess = () => {
                this.updatePendingCount();
                logger.log(`[Campo Offline] Foto enfileirada: ${tipo} para ordem ${ordemId} (${uuid})`);
                resolve(uuid);
            };
            request.onerror = () => reject(request.error);
        });
    }

    // === SINCRONIZAÇÃO COM AUDITORIA ===

    async syncPendingData() {
        if (this.syncInProgress) {
            logger.log('[Campo Offline] Sincronização já em andamento');
            return;
        }

        if (!navigator.onLine) {
            logger.log('[Campo Offline] Dispositivo offline - sincronização adiada');
            return;
        }

        this.syncInProgress = true;
        this.showSyncStatus(true);

        let syncedActions = 0;
        let syncedFotos = 0;
        let duplicateCount = 0;
        let failedCount = 0;

        try {
            // Sincronizar ações pendentes
            const actionResult = await this.syncPendingActions();
            syncedActions = actionResult.synced;
            duplicateCount = actionResult.duplicates;
            failedCount = actionResult.failed;

            // Sincronizar fotos pendentes
            syncedFotos = await this.syncPendingFotos();

            // Atualizar cache de ordens
            await this.refreshOrdensCache();

            // Atualizar cache de materiais
            await this.refreshMateriaisCache();

            // Mostrar resultado
            if (syncedActions > 0 || syncedFotos > 0) {
                this.showNotification(
                    `✅ Sincronizado: ${syncedActions} ações, ${syncedFotos} fotos` +
                    (duplicateCount > 0 ? ` (${duplicateCount} já processados)` : ''),
                    'success'
                );
            }

            logger.log('[Campo Offline] Sincronização concluída:', {
                actions: syncedActions,
                fotos: syncedFotos,
                duplicates: duplicateCount,
                failed: failedCount
            });

        } catch (error) {
            if (navigator.onLine) {
                logger.error('[Campo Offline] Erro na sincronização:', error);
                this.showNotification('Erro na sincronização. Tentaremos novamente.', 'error');
            }
        } finally {
            this.syncInProgress = false;
            this.showSyncStatus(false);
            this.updatePendingCount();
        }
    }

    async syncPendingActions() {
        if (!this.db) await this.openDatabase();

        // Buscar ações não sincronizadas
        const actions = await new Promise((resolve, reject) => {
            const tx = this.db.transaction('pendingActions', 'readonly');
            const store = tx.objectStore('pendingActions');
            const request = store.getAll();

            request.onsuccess = () => {
                const items = (request.result || []).filter(item => !item.synced);
                resolve(items);
            };
            request.onerror = () => reject(request.error);
        });

        if (actions.length === 0) {
            return { synced: 0, duplicates: 0, failed: 0 };
        }

        // Enviar todas as ações de uma vez para o servidor
        try {
            const response = await fetch('/api/v1/campo/sync', {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    actions: actions.map(a => ({
                        uuid: a.uuid,
                        type: a.type,
                        data: a.data,
                        timestamp: a.timestamp,
                        hash: a.hash,
                    })),
                    device_id: this.deviceId,
                    device_info: navigator.userAgent.substring(0, 255),
                })
            });

            if (!response.ok) {
                throw new Error(`HTTP ${response.status}`);
            }

            const result = await response.json();

            // Atualizar status local das ações
            if (result.results) {
                for (const actionResult of result.results) {
                    await this.markActionSynced(actionResult.uuid, actionResult.status);
                }
            }

            // Salvar informações do usuário
            if (result.user) {
                this.userId = result.user.id;
                this.userName = result.user.name;
            }

            return {
                synced: result.summary?.synced || 0,
                duplicates: result.summary?.duplicates || 0,
                failed: result.summary?.failed || 0,
            };

        } catch (error) {
            logger.error('[Campo Offline] Erro ao sincronizar ações:', error);
            return { synced: 0, duplicates: 0, failed: actions.length };
        }
    }

    async markActionSynced(uuid, status) {
        const tx = this.db.transaction('pendingActions', 'readwrite');
        const store = tx.objectStore('pendingActions');
        const getRequest = store.get(uuid);

        getRequest.onsuccess = () => {
            const action = getRequest.result;
            if (action) {
                action.synced = true;
                action.syncStatus = status;
                action.syncedAt = new Date().toISOString();
                store.put(action);

                // Mover para histórico
                this.addToSyncHistory(action);
            }
        };
    }

    async addToSyncHistory(action) {
        try {
            const tx = this.db.transaction('syncHistory', 'readwrite');
            const store = tx.objectStore('syncHistory');
            store.put({
                ...action,
                syncedAt: new Date().toISOString(),
            });
        } catch (e) {
            // Ignorar erros do histórico
        }
    }

    async syncPendingFotos() {
        if (!this.db) await this.openDatabase();

        // Buscar fotos não sincronizadas
        const fotos = await new Promise((resolve, reject) => {
            const tx = this.db.transaction('fotosPendentes', 'readonly');
            const store = tx.objectStore('fotosPendentes');
            const request = store.getAll();

            request.onsuccess = () => {
                const items = (request.result || []).filter(item => !item.synced);
                resolve(items);
            };
            request.onerror = () => reject(request.error);
        });

        let syncedCount = 0;

        for (const foto of fotos) {
            try {
                const formData = new FormData();
                formData.append('tipo', foto.tipo);
                formData.append('fotos[]', this.dataURLtoBlob(foto.data), `foto_${foto.uuid}.jpg`);
                formData.append('offline_uuid', foto.uuid); // Para verificação de duplicata

                const response = await fetch(`/campo/ordens/${foto.ordemId}/fotos`, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                if (response.ok) {
                    await this.markFotoSynced(foto.uuid);
                    syncedCount++;
                    logger.log(`[Campo Offline] Foto sincronizada: ${foto.uuid}`);
                }
            } catch (error) {
                if (navigator.onLine) {
                    logger.warn('[Campo Offline] Erro ao sincronizar foto:', error.message);
                }
            }
        }

        return syncedCount;
    }

    async markFotoSynced(uuid) {
        const tx = this.db.transaction('fotosPendentes', 'readwrite');
        const store = tx.objectStore('fotosPendentes');
        const getRequest = store.get(uuid);

        getRequest.onsuccess = () => {
            const foto = getRequest.result;
            if (foto) {
                foto.synced = true;
                foto.syncedAt = new Date().toISOString();
                store.put(foto);
            }
        };
    }

    async refreshOrdensCache() {
        if (!navigator.onLine) return;

        try {
            const response = await fetch('/api/v1/campo/ordens', {
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.ok) {
                const result = await response.json();
                const ordens = result.data || result;

                // Salvar informações do usuário
                if (result.user_id) {
                    this.userId = result.user_id;
                    this.userName = result.user_name;
                }

                if (Array.isArray(ordens)) {
                    for (const ordem of ordens) {
                        await this.saveOrdem(ordem);
                    }
                    logger.log(`[Campo Offline] Cache de ordens atualizado: ${ordens.length} ordens`);
                }
            }
        } catch (error) {
            if (navigator.onLine) {
                logger.warn('[Campo Offline] Erro ao atualizar cache de ordens:', error.message);
            }
        }
    }

    async refreshMateriaisCache() {
        if (!navigator.onLine) return;

        try {
            const response = await fetch('/api/v1/campo/materiais', {
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (response.ok) {
                const result = await response.json();
                const materiais = result.data || result;

                if (Array.isArray(materiais)) {
                    for (const material of materiais) {
                        await this.saveMaterial(material);
                    }
                    logger.log(`[Campo Offline] Cache de materiais atualizado: ${materiais.length} materiais`);
                }
            }
        } catch (error) {
            if (navigator.onLine) {
                logger.warn('[Campo Offline] Erro ao atualizar cache de materiais:', error.message);
            }
        }
    }

    // === UTILITÁRIOS ===

    dataURLtoBlob(dataURL) {
        const arr = dataURL.split(',');
        const mime = arr[0].match(/:(.*?);/)[1];
        const bstr = atob(arr[1]);
        let n = bstr.length;
        const u8arr = new Uint8Array(n);
        while (n--) {
            u8arr[n] = bstr.charCodeAt(n);
        }
        return new Blob([u8arr], { type: mime });
    }

    showNotification(message, type = 'info') {
        const container = document.getElementById('notifications-container') || this.createNotificationContainer();

        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <span class="notification-icon">${this.getNotificationIcon(type)}</span>
                <span class="notification-message">${message}</span>
            </div>
            <button class="notification-close" onclick="this.parentElement.remove()">×</button>
        `;

        container.appendChild(notification);

        setTimeout(() => {
            notification.classList.add('notification-fade');
            setTimeout(() => notification.remove(), 300);
        }, 5000);
    }

    createNotificationContainer() {
        const container = document.createElement('div');
        container.id = 'notifications-container';
        container.className = 'notifications-container';
        document.body.appendChild(container);
        return container;
    }

    getNotificationIcon(type) {
        const icons = {
            success: '✓',
            error: '✕',
            warning: '⚠',
            info: 'ℹ'
        };
        return icons[type] || icons.info;
    }

    showSyncStatus(syncing) {
        const indicator = document.getElementById('sync-indicator');
        const defaultIcon = document.getElementById('sync-icon-default');

        if (indicator && defaultIcon) {
            if (syncing) {
                indicator.classList.remove('hidden');
                defaultIcon.classList.add('hidden');
            } else {
                indicator.classList.add('hidden');
                defaultIcon.classList.remove('hidden');
            }
        }
    }

    onSyncComplete() {
        this.showNotification('Dados sincronizados com sucesso!', 'success');
        this.updatePendingCount();

        if (typeof window.reloadPageData === 'function') {
            window.reloadPageData();
        }
    }

    /**
     * Obtém estatísticas do cache local
     */
    async getStats() {
        if (!this.db) await this.openDatabase();

        const stats = {
            ordens: 0,
            materiais: 0,
            acoesPendentes: 0,
            fotosPendentes: 0,
            deviceId: this.deviceId,
            userId: this.userId,
            userName: this.userName,
        };

        try {
            // Contar ordens
            const ordensTx = this.db.transaction('ordensCache', 'readonly');
            const ordensCount = await new Promise(resolve => {
                const req = ordensTx.objectStore('ordensCache').count();
                req.onsuccess = () => resolve(req.result);
                req.onerror = () => resolve(0);
            });
            stats.ordens = ordensCount;

            // Contar materiais
            const matTx = this.db.transaction('materiaisCache', 'readonly');
            const matCount = await new Promise(resolve => {
                const req = matTx.objectStore('materiaisCache').count();
                req.onsuccess = () => resolve(req.result);
                req.onerror = () => resolve(0);
            });
            stats.materiais = matCount;

            // Contar ações pendentes
            const actionsTx = this.db.transaction('pendingActions', 'readonly');
            const actionsAll = await new Promise(resolve => {
                const req = actionsTx.objectStore('pendingActions').getAll();
                req.onsuccess = () => resolve(req.result || []);
                req.onerror = () => resolve([]);
            });
            stats.acoesPendentes = actionsAll.filter(a => !a.synced).length;

            // Contar fotos pendentes
            const fotosTx = this.db.transaction('fotosPendentes', 'readonly');
            const fotosAll = await new Promise(resolve => {
                const req = fotosTx.objectStore('fotosPendentes').getAll();
                req.onsuccess = () => resolve(req.result || []);
                req.onerror = () => resolve([]);
            });
            stats.fotosPendentes = fotosAll.filter(f => !f.synced).length;

        } catch (e) {
            logger.warn('[Campo Offline] Erro ao obter estatísticas:', e);
        }

        return stats;
    }

    /**
     * Limpa dados antigos sincronizados (housekeeping)
     */
    async cleanupOldData() {
        if (!this.db) await this.openDatabase();

        const oneWeekAgo = Date.now() - (7 * 24 * 60 * 60 * 1000);

        try {
            // Limpar ações sincronizadas antigas
            const actionsTx = this.db.transaction('pendingActions', 'readwrite');
            const actionsStore = actionsTx.objectStore('pendingActions');
            const actionsRequest = actionsStore.getAll();

            actionsRequest.onsuccess = () => {
                const actions = actionsRequest.result || [];
                actions.forEach(action => {
                    if (action.synced && action.timestamp < oneWeekAgo) {
                        actionsStore.delete(action.uuid);
                    }
                });
            };

            // Limpar fotos sincronizadas antigas
            const fotosTx = this.db.transaction('fotosPendentes', 'readwrite');
            const fotosStore = fotosTx.objectStore('fotosPendentes');
            const fotosRequest = fotosStore.getAll();

            fotosRequest.onsuccess = () => {
                const fotos = fotosRequest.result || [];
                fotos.forEach(foto => {
                    if (foto.synced && foto.timestamp < oneWeekAgo) {
                        fotosStore.delete(foto.uuid);
                    }
                });
            };

            logger.log('[Campo Offline] Limpeza de dados antigos concluída');

        } catch (e) {
            logger.warn('[Campo Offline] Erro na limpeza:', e);
        }
    }
}

// Inicializar quando DOM estiver pronto
document.addEventListener('DOMContentLoaded', () => {
    window.campoOffline = new CampoOfflineManager();

    // Limpeza periódica de dados antigos
    setTimeout(() => {
        window.campoOffline.cleanupOldData();
    }, 60000); // Após 1 minuto
});

// === FUNÇÕES GLOBAIS PARA USO NAS VIEWS ===

/**
 * Iniciar ordem com suporte offline e UUID
 */
async function iniciarOrdemOffline(ordemId) {
    if (navigator.onLine) {
        // Online - fazer requisição normal
        const response = await fetch(`/campo/ordens/${ordemId}/iniciar`, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Content-Type': 'application/json'
            }
        });
        return response;
    } else {
        // Offline - salvar para sincronização com UUID único
        const uuid = await window.campoOffline.queueAction('iniciar_ordem', {
            ordem_id: ordemId,
            client_timestamp: new Date().toISOString(),
        });

        // Atualizar cache local
        const ordem = await window.campoOffline.getOrdem(ordemId);
        if (ordem) {
            ordem.status = 'em_execucao';
            ordem.data_inicio = new Date().toISOString();
            ordem.status_texto = 'Em Execução';
            await window.campoOffline.saveOrdem(ordem);
        }

        window.campoOffline.showNotification('Ação salva para sincronização (ID: ' + uuid.substring(0, 8) + ')', 'warning');
        return { ok: true, offline: true, uuid };
    }
}

/**
 * Adicionar material com suporte offline e UUID
 */
async function adicionarMaterialOffline(ordemId, materialId, quantidade) {
    const data = {
        ordem_id: ordemId,
        material_id: materialId,
        quantidade: quantidade,
        client_timestamp: new Date().toISOString(),
    };

    if (navigator.onLine) {
        return fetch(`/campo/ordens/${ordemId}/materiais`, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
    } else {
        const uuid = await window.campoOffline.queueAction('adicionar_material', data);
        window.campoOffline.showNotification('Material será adicionado quando online (ID: ' + uuid.substring(0, 8) + ')', 'warning');
        return { ok: true, offline: true, uuid };
    }
}

/**
 * Remover material com suporte offline e UUID
 */
async function removerMaterialOffline(ordemId, materialId) {
    const data = {
        ordem_id: ordemId,
        material_id: materialId,
        client_timestamp: new Date().toISOString(),
    };

    if (navigator.onLine) {
        return fetch(`/campo/ordens/${ordemId}/materiais/${materialId}`, {
            method: 'DELETE',
            credentials: 'same-origin',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Content-Type': 'application/json'
            }
        });
    } else {
        const uuid = await window.campoOffline.queueAction('remover_material', data);
        window.campoOffline.showNotification('Material será removido quando online', 'warning');
        return { ok: true, offline: true, uuid };
    }
}

/**
 * Salvar relatório com suporte offline e UUID
 */
async function salvarRelatorioOffline(ordemId, relatorio) {
    const data = {
        ordem_id: ordemId,
        relatorio: relatorio,
        client_timestamp: new Date().toISOString(),
    };

    if (navigator.onLine) {
        return fetch(`/campo/ordens/${ordemId}/relatorio`, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ relatorio_execucao: relatorio })
        });
    } else {
        const uuid = await window.campoOffline.queueAction('atualizar_relatorio', data);

        // Atualizar cache local
        const ordem = await window.campoOffline.getOrdem(ordemId);
        if (ordem) {
            ordem.relatorio_execucao = relatorio;
            await window.campoOffline.saveOrdem(ordem);
        }

        window.campoOffline.showNotification('Relatório salvo localmente', 'warning');
        return { ok: true, offline: true, uuid };
    }
}

/**
 * Concluir ordem com suporte offline e UUID
 */
async function concluirOrdemOffline(ordemId, relatorio, observacoes) {
    const data = {
        ordem_id: ordemId,
        relatorio: relatorio,
        observacoes: observacoes,
        client_timestamp: new Date().toISOString(),
    };

    if (navigator.onLine) {
        const formData = new FormData();
        formData.append('relatorio_execucao', relatorio);
        if (observacoes) formData.append('observacoes', observacoes);

        return fetch(`/campo/ordens/${ordemId}/concluir`, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            },
            body: formData
        });
    } else {
        const uuid = await window.campoOffline.queueAction('concluir_ordem', data);

        // Atualizar cache local
        const ordem = await window.campoOffline.getOrdem(ordemId);
        if (ordem) {
            ordem.status = 'concluida';
            ordem.status_texto = 'Concluída';
            ordem.data_conclusao = new Date().toISOString();
            ordem.relatorio_execucao = relatorio;
            await window.campoOffline.saveOrdem(ordem);
        }

        window.campoOffline.showNotification('Conclusão salva para sincronização', 'warning');
        return { ok: true, offline: true, uuid };
    }
}

/**
 * Capturar e salvar foto com suporte offline e UUID
 */
async function capturarFotoOffline(ordemId, tipo, file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = async (e) => {
            const dataURL = e.target.result;

            if (navigator.onLine) {
                const formData = new FormData();
                formData.append('tipo', tipo);
                formData.append('fotos[]', file);

                const response = await fetch(`/campo/ordens/${ordemId}/fotos`, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                    },
                    body: formData
                });

                resolve(response);
            } else {
                const uuid = await window.campoOffline.saveFotoOffline(ordemId, dataURL, tipo);
                window.campoOffline.showNotification('Foto salva para envio posterior', 'warning');
                resolve({ ok: true, offline: true, preview: dataURL, uuid });
            }
        };
        reader.onerror = reject;
        reader.readAsDataURL(file);
    });
}

/**
 * Sincronizar manualmente
 */
function sincronizarAgora() {
    if (window.campoOffline) {
        window.campoOffline.syncPendingData();
    }
}

/**
 * Obter estatísticas do cache
 */
async function getOfflineStats() {
    if (window.campoOffline) {
        return await window.campoOffline.getStats();
    }
    return null;
}
