import { db } from './db';
import axios from 'axios';

export async function downloadData() {
    try {
        const response = await axios.get('/demandas/offline/sync');
        const { demands, materials } = response.data;

        await db.transaction('rw', db.demands, db.materials, async () => {
            await db.demands.clear();
            await db.materials.clear();

            if (demands && demands.length > 0) {
                await db.demands.bulkPut(demands);
            }
            if (materials && materials.length > 0) {
                await db.materials.bulkPut(materials);
            }
        });

        return { success: true, count: demands ? demands.length : 0 };
    } catch (error) {
        console.error('Download failed:', error);
        throw error;
    }
}

export async function uploadData() {
    const queue = await db.syncQueue.orderBy('timestamp').toArray();
    if (queue.length === 0) return { success: true, count: 0 };

    let successCount = 0;
    let errors = [];

    for (const item of queue) {
        try {
            if (item.action === 'upload_photo') {
                await processPhotoUpload(item);
            } else {
                // Standard JSON sync
                await axios.post('/api/v1/campo/sync', {
                    action_type: item.action,
                    payload: item.payload,
                    client_uuid: item.uuid || self.crypto.randomUUID(),
                    client_timestamp: new Date().toISOString()
                });

                // Garbage Collection for completed orders
                if (item.action === 'concluir_ordem' && item.payload.ordem_id) {
                     const completedDemand = await db.demands.where('ordem_servico_id').equals(item.payload.ordem_id).first();
                     if (completedDemand) {
                         await db.demands.delete(completedDemand.id);
                     }
                }
            }

            // On success, remove from queue
            await db.syncQueue.delete(item.id);
            successCount++;

        } catch (error) {
            console.error('Sync failed for item', item, error);
            errors.push({ id: item.id, error: error.message });
            // Don't delete, retry later
        }
    }

    return { success: true, count: successCount, errors };
}

async function processPhotoUpload(item) {
    const media = await db.offline_media.get(item.mediaId);
    if (!media) {
        console.warn('Media not found for item', item);
        return; // Skip if media missing (already synced?)
    }

    const formData = new FormData();
    formData.append('photo', media.blob, `photo_${item.payload.demandId}_${Date.now()}.jpg`);
    formData.append('demand_id', item.payload.demandId);
    formData.append('description', item.payload.description || 'Foto de Campo');

    // Add Consent (Default to 0 if undefined)
    formData.append('consent', media.consent ? '1' : '0');

    await axios.post('/api/v1/campo/upload-media', formData, {
        headers: { 'Content-Type': 'multipart/form-data' }
    });

    // Cleanup media blob after successful upload
    await db.offline_media.delete(media.id);
}

// Helper to queue actions
export async function queueAction(action, payload, mediaId = null) {
    return await db.syncQueue.add({
        action,
        payload,
        mediaId, // Link to offline_media if applicable
        uuid: self.crypto.randomUUID(),
        timestamp: Date.now()
    });
}
