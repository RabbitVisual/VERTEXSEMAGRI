import sys

new_header = """    <div class="mb-4 flex flex-col sm:flex-row justify-between items-center bg-white dark:bg-gray-800 p-4 rounded-lg shadow gap-4">
        <div class="flex items-center gap-3">
            <div :class="online ? 'bg-green-500' : 'bg-orange-500'" class="w-3 h-3 rounded-full"></div>
            <div class="flex flex-col">
                <span x-text="online ? 'Online' : 'Offline Mode'" class="font-semibold text-gray-700 dark:text-gray-200"></span>
                <span x-show="lastSync" class="text-xs" :class="{
                    'text-green-600': syncColor === 'green',
                    'text-amber-600': syncColor === 'amber',
                    'text-red-600': syncColor === 'red',
                    'text-gray-500': syncColor === 'gray'
                }" x-text="'Último Sync: ' + lastSync"></span>
            </div>
        </div>
        <div class="flex gap-2 w-full sm:w-auto">
            <button @click="$dispatch('open-outbox')" class="flex-1 sm:flex-none px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded transition flex items-center justify-center gap-2 relative">
                <x-demandas::icon name="paper-airplane" class="w-4 h-4" />
                <span>Pendências</span>
                <span x-show="queueCount > 0" x-text="queueCount" class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center"></span>
            </button>
            <button @click="sync()" :disabled="syncing || !online" class="flex-1 sm:flex-none px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded transition disabled:opacity-50 flex items-center justify-center gap-2">
                <x-demandas::icon name="arrow-path" class="w-4 h-4" ::class="{'animate-spin': syncing}" />
                <span x-text="syncStatus"></span>
            </button>
        </div>
    </div>"""

path = 'Modules/Demandas/resources/views/index.blade.php'
with open(path, 'r') as f:
    content = f.read()

old_header_start = '<div class="mb-4 flex justify-between items-center bg-white dark:bg-gray-800 p-4 rounded-lg shadow">'
if old_header_start in content:
    # Find the end of this div block. It's tricky with nested divs.
    # But we know the structure from previous `cat`.
    # It ends before `<div x-show="online">`
    start_idx = content.find(old_header_start)
    end_idx = content.find('<div x-show="online">', start_idx)

    if end_idx != -1:
        # Check if there are exactly two closing divs before the next block or just replace until the next block starts
        # The previous content was:
        # <div class="..."> ... </div>
        # <div x-show="online">

        # Actually, let's just replace the exact string we know is there if possible, or use a sentinel.
        # But the content between start and <div x-show="online"> is what we want to replace.
        # Let's verify the content slice.
        # print(content[start_idx:end_idx])

        content = content[:start_idx] + new_header + "\n\n    " + content[end_idx:]

        with open(path, 'w') as f:
            f.write(content)
        print("Header replaced successfully.")
    else:
        print("End marker not found.")
else:
    print("Start marker not found.")
