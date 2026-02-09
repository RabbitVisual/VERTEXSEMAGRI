import Dexie from 'dexie';

export const db = new Dexie('PainelCampoDB');

db.version(1).stores({
    demands: 'id, status, localidade_id, ordem_servico_id', // Index server ID
    materials: 'id, nome, codigo',
    syncQueue: '++id, action, timestamp' // action: string (e.g., 'conclude'), payload: object
});

export async function clearLocalData() {
    await db.demands.clear();
    await db.materials.clear();
    // Do not clear syncQueue as it might have pending uploads!
}
