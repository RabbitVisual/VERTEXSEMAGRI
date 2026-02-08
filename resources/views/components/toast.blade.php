<div
    x-data="{
        notifications: [],
        add(e) {
            this.notifications.push({
                id: e.timeStamp,
                type: e.detail.type || 'info',
                content: e.detail.content,
            })
        },
        remove(id) {
            this.notifications = this.notifications.filter(notification => notification.id !== id)
        }
    }"
    @notify.window="add($event)"
    class="fixed bottom-0 right-0 p-6 space-y-4 w-full max-w-sm z-50 pointer-events-none font-['Inter']"
>
    <template x-for="notification in notifications" :key="notification.id">
        <div
            class="pointer-events-auto w-full max-w-sm overflow-hidden bg-white rounded-xl shadow-lg border border-gray-100 dark:bg-slate-800 dark:border-slate-700 backdrop-blur-sm"
            :class="{
                'border-l-4 border-l-emerald-500': notification.type === 'success',
                'border-l-4 border-l-red-500': notification.type === 'error',
                'border-l-4 border-l-amber-500': notification.type === 'warning',
                'border-l-4 border-l-blue-500': notification.type === 'info'
            }"
            role="alert"
            x-show="true"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-2 scale-95"
            x-init="setTimeout(() => remove(notification.id), 4000)"
        >
            <div class="p-4 flex items-start">
                <div class="flex-shrink-0">
                    <template x-if="notification.type === 'success'">
                        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400">
                            <i class="fa-duotone fa-check"></i>
                        </div>
                    </template>
                    <template x-if="notification.type === 'error'">
                        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400">
                            <i class="fa-duotone fa-xmark"></i>
                        </div>
                    </template>
                    <template x-if="notification.type === 'warning'">
                        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400">
                            <i class="fa-duotone fa-triangle-exclamation"></i>
                        </div>
                    </template>
                    <template x-if="notification.type === 'info'">
                        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400">
                            <i class="fa-duotone fa-info"></i>
                        </div>
                    </template>
                </div>
                <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="notification.type.charAt(0).toUpperCase() + notification.type.slice(1)"></p>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400" x-text="notification.content"></p>
                </div>
                <div class="ml-4 flex-shrink-0 flex">
                    <button @click="remove(notification.id)" class="inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:hover:text-gray-300">
                        <span class="sr-only">Close</span>
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>
