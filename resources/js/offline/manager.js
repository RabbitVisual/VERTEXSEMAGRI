import { db } from './db';
import { downloadData, uploadData, queueAction } from './sync';

export default () => ({
    online: navigator.onLine,
    syncing: false,
    syncStatus: 'Sincronizar',
    lastSync: localStorage.getItem('lastSync'),
    queueCount: 0,
    localDemands: [],
    selectedDemand: null,

    async init() {
        window.addEventListener('online', () => {
            this.online = true;
            this.processQueue();
        });
        window.addEventListener('offline', () => this.online = false);

        await this.refreshData();
        setInterval(() => this.updateQueueCount(), 5000);
    },

    async refreshData() {
        this.localDemands = await db.demands.toArray();
        this.updateQueueCount();
    },

    async updateQueueCount() {
        this.queueCount = await db.syncQueue.count();
    },

    async processQueue() {
        if (!this.online) return;
        this.syncing = true;
        this.syncStatus = 'Enviando...';
        await uploadData();
        this.syncStatus = 'Sincronizado';
        this.syncing = false;
        await this.refreshData();
        setTimeout(() => this.syncStatus = 'Sincronizar', 2000);
    },

    async sync() {
        if (!this.online) return;

        this.syncing = true;
        this.syncStatus = 'Baixando...';
        try {
            await uploadData();
            const downloadResult = await downloadData();

            this.lastSync = new Date().toLocaleString('pt-BR');
            localStorage.setItem('lastSync', this.lastSync);

            this.syncStatus = `Ok (${downloadResult.count})`;
            await this.refreshData();
        } catch (e) {
            console.error(e);
            this.syncStatus = 'Erro';
        } finally {
            this.syncing = false;
            setTimeout(() => this.syncStatus = 'Sincronizar', 3000);
        }
    },

    handleLinkClick(e) {
        if (this.online) return;

        const link = e.target.closest('a');
        if (!link) return;

        const href = link.href;
        if (href.match(/\/demandas\/\d+$/)) {
            e.preventDefault();
            const id = href.split('/').pop();
            this.openDemand(id);
        }
    },

    async saveStatus() {
        if (!this.selectedDemand) return;

        const payload = {
            ordem_id: this.selectedDemand.ordem_servico?.id,
            demanda_id: this.selectedDemand.id,
            observacoes: this.selectedDemand.observacoes_temp,
            client_timestamp: new Date().toISOString()
        };

        await queueAction('concluir_ordem', payload);

        // Optimistic update
        const demand = await db.demands.get(this.selectedDemand.id);
        if (demand) {
            demand.status = 'concluida';
            await db.demands.put(demand);
            this.localDemands = await db.demands.toArray();
        }
        this.selectedDemand = null;
        alert('Ação salva offline. Sincronize para enviar.');
    },

    async openDemand(demandId) {
        const demand = this.localDemands.find(d => d.id == demandId);
        if (demand) {
            this.selectedDemand = demand;
        } else {
            alert('Demanda não encontrada offline. Sincronize antes.');
        }
    }
});
