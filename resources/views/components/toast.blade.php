<div
    x-data="{
        notifications: [],
        add(e) {
            this.notifications.push({
                id: e.timeStamp,
                type: e.detail.type,
                content: e.detail.content,
            })
        },
        remove(id) {
            this.notifications = this.notifications.filter(notification => notification.id !== id)
        }
    }"
    @notify.window="add($event)"
    class="fixed bottom-0 right-0 p-4 space-y-4 w-full max-w-xs z-50 pointer-events-none"
>
    <template x-for="notification in notifications" :key="notification.id">
        <div
            class="pointer-events-auto w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800"
            role="alert"
            x-show="true"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-2"
            x-init="setTimeout(() => remove(notification.id), 3000)"
        >
            <div class="flex items-center">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg"
                     :class="{
                        'text-green-500 bg-green-100 dark:bg-green-800 dark:text-green-200': notification.type === 'success',
                        'text-red-500 bg-red-100 dark:bg-red-800 dark:text-red-200': notification.type === 'error',
                        'text-orange-500 bg-orange-100 dark:bg-orange-700 dark:text-orange-200': notification.type === 'warning',
                        'text-blue-500 bg-blue-100 dark:bg-blue-800 dark:text-blue-200': notification.type === 'info'
                     }">
                    <x-icon name="check" class="w-5 h-5" x-show="notification.type === 'success'" />
                    <x-icon name="xmark" class="w-5 h-5" x-show="notification.type === 'error'" />
                    <x-icon name="triangle-exclamation" class="w-5 h-5" x-show="notification.type === 'warning'" />
                    <x-icon name="info" class="w-5 h-5" x-show="notification.type === 'info'" />
                </div>
                <div class="ml-3 text-sm font-normal" x-text="notification.content"></div>
                <button type="button" @click="remove(notification.id)" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700">
                    <span class="sr-only">Close</span>
                    <x-icon name="xmark" class="w-5 h-5" />
                </button>
            </div>
        </div>
    </template>
</div>
