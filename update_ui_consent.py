import sys

consent_ui = """                    <div class="mb-4 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="checkbox" x-model="imageConsent" class="form-checkbox h-5 w-5 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                            <span class="text-sm text-gray-700 dark:text-gray-200 font-medium">Cidadão autorizou uso de imagem?</span>
                        </label>
                        <p x-show="!imageConsent" class="mt-2 text-xs text-amber-600 dark:text-amber-400 flex items-center">
                            <x-demandas::icon name="lock" class="w-3 h-3 mr-1" />
                            Foto será marcada como Uso Interno (LGPD)
                        </p>
                    </div>
"""

path = 'Modules/Demandas/resources/views/index.blade.php'
with open(path, 'r') as f:
    content = f.read()

# Insert before the grid buttons (Camera/Radar)
marker = '<div class="grid grid-cols-2 gap-3 mb-4">'
if marker in content:
    content = content.replace(marker, consent_ui + "\n" + marker)
    with open(path, 'w') as f:
        f.write(content)
    print("Consent UI inserted successfully.")
else:
    print("Marker not found.")
