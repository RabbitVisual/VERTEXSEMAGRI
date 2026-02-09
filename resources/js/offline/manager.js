import { db } from './db';
import { downloadData, uploadData, queueAction } from './sync';

export default () => ({
    online: navigator.onLine,
    syncing: false,
    syncStatus: 'Sincronizar',
    lastSync: localStorage.getItem('lastSync'),
    syncColor: 'gray',
    queueCount: 0,
    queueItems: [],
    localDemands: [],
    selectedDemand: null,

    // Radar
    radarActive: false,
    radarWatchId: null,
    targetDistance: null,
    targetBearing: null,
    currentHeading: 0,

    async init() {
        window.addEventListener('online', () => {
            this.online = true;
            this.processQueue();
        });
        window.addEventListener('offline', () => this.online = false);

        await this.refreshData();
        this.updateSyncColor();

        // Periodic updates
        setInterval(() => {
            this.updateQueueCount();
            this.updateSyncColor();
        }, 5000);

        // Compass heading
        if (window.DeviceOrientationEvent) {
            window.addEventListener('deviceorientation', (e) => {
                if (e.webkitCompassHeading) {
                    this.currentHeading = e.webkitCompassHeading;
                } else if (e.alpha) {
                    this.currentHeading = 360 - e.alpha;
                }
            });
        }
    },

    async refreshData() {
        this.localDemands = await db.demands.toArray();
        this.updateQueueCount();
        this.loadQueueItems();
    },

    async updateQueueCount() {
        this.queueCount = await db.syncQueue.count();
    },

    async loadQueueItems() {
        this.queueItems = await db.syncQueue.orderBy('timestamp').reverse().toArray();
    },

    updateSyncColor() {
        if (!this.lastSync) {
            this.syncColor = 'gray';
            return;
        }

        // Parse "dd/mm/yyyy, hh:mm:ss" - PT-BR locale string format from sync.js
        // Ideally we should store ISO string in localStorage for reliable parsing
        // But let's try to parse the string or change storage to ISO
        // Let's assume we update sync.js to store ISO separately or parse string carefully.

        // Actually, let's fix the storage in sync() below.
        const lastSyncTime = localStorage.getItem('lastSyncISO');
        if (!lastSyncTime) {
             this.syncColor = 'gray';
             return;
        }

        const diffHours = (new Date() - new Date(lastSyncTime)) / (1000 * 60 * 60);

        if (diffHours < 4) this.syncColor = 'green';
        else if (diffHours < 12) this.syncColor = 'amber';
        else this.syncColor = 'red';
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

            const now = new Date();
            this.lastSync = now.toLocaleString('pt-BR');
            localStorage.setItem('lastSync', this.lastSync);
            localStorage.setItem('lastSyncISO', now.toISOString());

            this.syncStatus = `Ok (${downloadResult.count})`;
            await this.refreshData();
            this.updateSyncColor();
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
            // Stop radar if running
            this.stopRadar();
        } else {
            alert('Demanda não encontrada offline. Sincronize antes.');
        }
    },

    // Photo Logic
    async capturePhoto(event) {
        const file = event.target.files[0];
        if (!file || !this.selectedDemand) return;

        try {
            // Store blob
            const mediaId = await db.offline_media.add({
                demandId: this.selectedDemand.id,
                type: 'photo',
                blob: file,
                timestamp: Date.now()
            });

            // Queue Action
            await queueAction('upload_photo', {
                demandId: this.selectedDemand.id,
                description: 'Foto ' + new Date().toLocaleTimeString()
            }, mediaId);

            await this.updateQueueCount();
            alert('Foto salva na fila de envio!');
        } catch (e) {
            console.error(e);
            alert('Erro ao salvar foto.');
        }
    },

    // Radar Logic
    toggleRadar() {
        if (this.radarActive) {
            this.stopRadar();
        } else {
            this.startRadar();
        }
    },

    startRadar() {
        if (!this.selectedDemand?.localidade) {
            alert('Localidade sem coordenadas.');
            return;
        }

        const targetLat = this.selectedDemand.localidade.latitude;
        const targetLon = this.selectedDemand.localidade.longitude;

        if (!targetLat || !targetLon) {
             alert('Coordenadas inválidas para esta demanda.');
             return;
        }

        this.radarActive = true;

        if (navigator.geolocation) {
            this.radarWatchId = navigator.geolocation.watchPosition((pos) => {
                const userLat = pos.coords.latitude;
                const userLon = pos.coords.longitude;

                this.targetDistance = this.calculateDistance(userLat, userLon, targetLat, targetLon);
                this.targetBearing = this.calculateBearing(userLat, userLon, targetLat, targetLon);

            }, (err) => {
                console.error(err);
                alert('Erro de GPS: ' + err.message);
                this.stopRadar();
            }, {
                enableHighAccuracy: true
            });
        } else {
            alert('Geolocalização não suportada.');
        }
    },

    stopRadar() {
        this.radarActive = false;
        if (this.radarWatchId) {
            navigator.geolocation.clearWatch(this.radarWatchId);
            this.radarWatchId = null;
        }
    },

    calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371e3; // metres
        const φ1 = lat1 * Math.PI/180; // φ, λ in radians
        const φ2 = lat2 * Math.PI/180;
        const Δφ = (lat2-lat1) * Math.PI/180;
        const Δλ = (lon2-lon1) * Math.PI/180;

        const a = Math.sin(Δφ/2) * Math.sin(Δφ/2) +
                  Math.cos(φ1) * Math.cos(φ2) *
                  Math.sin(Δλ/2) * Math.sin(Δλ/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));

        return Math.round(R * c); // in metres
    },

    calculateBearing(startLat, startLng, destLat, destLng) {
        startLat = startLat * Math.PI / 180;
        startLng = startLng * Math.PI / 180;
        destLat = destLat * Math.PI / 180;
        destLng = destLng * Math.PI / 180;

        const y = Math.sin(destLng - startLng) * Math.cos(destLat);
        const x = Math.cos(startLat) * Math.sin(destLat) -
                  Math.sin(startLat) * Math.cos(destLat) * Math.cos(destLng - startLng);
        const brng = Math.atan2(y, x);
        const deg = (brng * 180 / Math.PI + 360) % 360; // in degrees
        return deg;
    },

    getRelativeBearing() {
        if (!this.targetBearing) return 0;
        // Arrow rotation: target - userHeading
        return (this.targetBearing - this.currentHeading + 360) % 360;
    }
});
