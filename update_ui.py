import sys

# 1. Update Demand Modal (Insert buttons before observations)
modal_buttons = """                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <label class="flex flex-col items-center justify-center p-3 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 dark:border-gray-600 transition">
                            <x-demandas::icon name="camera" class="w-6 h-6 text-gray-400 mb-1" />
                            <span class="text-xs text-gray-500">Adicionar Foto</span>
                            <input type="file" accept="image/*" capture="environment" class="hidden" @change="capturePhoto($event)">
                        </label>

                        <button @click="toggleRadar()" class="flex flex-col items-center justify-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 dark:border-gray-600 transition" :class="{'bg-indigo-50 border-indigo-200 dark:bg-indigo-900/30': radarActive}">
                            <x-demandas::icon name="map-pin" class="w-6 h-6 mb-1" :class="radarActive ? 'text-indigo-600' : 'text-gray-400'" />
                            <span class="text-xs" :class="radarActive ? 'text-indigo-700 font-semibold' : 'text-gray-500'" x-text="radarActive ? 'Parar Radar' : 'Ativar Radar'"></span>
                        </button>
                    </div>

                    <div x-show="radarActive" class="mb-4 p-4 bg-gray-900 rounded-lg text-center text-white relative overflow-hidden">
                        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle,_var(--tw-gradient-stops))] from-green-500 to-transparent animate-pulse"></div>
                        <div class="relative z-10">
                            <div class="text-3xl font-bold mb-1" x-text="targetDistance ? targetDistance + 'm' : 'Calculando...'"></div>
                            <div class="text-xs text-gray-400 uppercase tracking-widest">Distância do Alvo</div>

                            <div class="mt-4 flex justify-center">
                                <div class="w-16 h-16 rounded-full border-2 border-green-500 flex items-center justify-center" :style="'transform: rotate(' + getRelativeBearing() + 'deg)'">
                                    <x-demandas::icon name="arrow-up" class="w-8 h-8 text-green-500" />
                                </div>
                            </div>
                        </div>
                    </div>
"""

# 2. Add Outbox Modal (Before @push)
outbox_modal = """    <!-- Outbox Modal -->
    <div x-data="{ open: false }" @open-outbox.window="open = true" x-show="open" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" style="display: none;">
        <div class="bg-white dark:bg-gray-800 rounded-lg max-w-lg w-full p-6 relative shadow-xl h-[80vh] flex flex-col" @click.outside="open = false">
             <div class="flex justify-between items-center mb-4">
                 <h2 class="text-xl font-bold dark:text-white flex items-center gap-2">
                     <x-demandas::icon name="paper-airplane" class="w-5 h-5" />
                     Fila de Envio
                 </h2>
                 <button @click="open = false" class="text-gray-500 hover:text-gray-700">&times;</button>
             </div>

             <div class="flex-1 overflow-y-auto space-y-3">
                <template x-for="item in queueItems" :key="item.id">
                    <div class="p-3 border rounded bg-gray-50 dark:bg-gray-700/50 flex items-start gap-3">
                        <div class="mt-1">
                            <x-demandas::icon name="clock" class="w-4 h-4 text-gray-400" />
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between">
                                <strong class="text-sm text-gray-800 dark:text-gray-200" x-text="item.action === 'upload_photo' ? 'Envio de Foto' : 'Atualização de Status'"></strong>
                                <span class="text-xs text-gray-500" x-text="new Date(item.timestamp).toLocaleTimeString()"></span>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" x-text="'ID: ' + (item.payload.demand_id || item.payload.demandId || 'N/A')"></p>
                        </div>
                    </div>
                </template>
                <div x-show="queueItems.length === 0" class="text-center py-8 text-gray-500">
                    Nenhuma pendência na fila.
                </div>
             </div>

             <div class="mt-4 pt-4 border-t dark:border-gray-700">
                 <button @click="processQueue()" :disabled="!online || queueCount === 0" class="w-full bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50 text-white py-3 rounded-lg font-semibold flex items-center justify-center gap-2">
                     <x-demandas::icon name="arrow-path" class="w-5 h-5" />
                     Sincronizar Agora
                 </button>
             </div>
        </div>
    </div>
"""

path = 'Modules/Demandas/resources/views/index.blade.php'
with open(path, 'r') as f:
    content = f.read()

# Insert Modal Buttons
marker = '<div class="mb-4">\n                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Observações</label>'
# We check if marker is exactly as expected, sometimes spaces vary.
if marker not in content:
    # Try simpler marker
    marker = '<label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Observações</label>'

if marker in content:
    content = content.replace(marker, modal_buttons + "\n" + marker)
    print("Modal buttons inserted.")
else:
    print("Modal buttons marker not found.")

# Append Outbox Modal
marker_end = '@push(\'scripts\')'
if marker_end in content:
    content = content.replace(marker_end, outbox_modal + "\n" + marker_end)
    print("Outbox modal appended.")
else:
    print("Outbox modal marker not found.")

with open(path, 'w') as f:
    f.write(content)
