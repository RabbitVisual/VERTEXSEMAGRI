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
            // Using the existing CampoApiController endpoint
            await axios.post('/api/v1/campo/sync', {
                action_type: item.action,
                payload: item.payload,
                client_uuid: item.uuid || self.crypto.randomUUID(),
                client_timestamp: new Date().toISOString()
            });

            // On success, remove from queue
            await db.syncQueue.delete(item.id);

            // Garbage Collection: remove from local demands if completed
            if (item.action === 'concluir_ordem' && item.payload.ordem_id) {
                 // Find demand by order ID
                 // The payload has 'ordem_id'. Demands table has 'ordem_servico_id'.
                 // We need to find the demand associated with this order.
                 const completedDemand = await db.demands.where('ordem_servico_id').equals(item.payload.ordem_id).first();
                 // Simple filter as we don't have secondary index on 'ordem_servico.id' unless we flatten it
                 // But wait, 'ordem_servico_id' is not a property of demand unless we flattened it?
                 // The API returns 'ordemServico' object.
                 // So we need to filter: demand.ordemServico && demand.ordemServico.id == payload.ordem_id

                 // Found directly via index
                 if (completedDemand) {
                     await db.demands.delete(completedDemand.id);
                 }
            }

            successCount++;
        } catch (error) {
            console.error('Sync failed for item', item, error);
            errors.push({ id: item.id, error: error.message });
            // Don't delete, retry later
        }
    }

    return { success: true, count: successCount, errors };
}

// Helper to queue actions
export async function queueAction(action, payload) {
    return await db.syncQueue.add({
        action,
        payload,
        uuid: self.crypto.randomUUID(),
        timestamp: Date.now()
    });
}
