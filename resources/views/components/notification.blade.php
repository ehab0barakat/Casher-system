<div
    class="fixed inset-0 flex items-end justify-center px-4 py-6 pointer-events-none sm:p-6 sm:items-start sm:justify-end">
    <div x-data="{ show: false, message: '', isError: false }"
        x-on:notify.window="show = true; message = $event.detail.message; isError = $event.detail.isError; setTimeout(() => { show = false }, 15000)"
        x-show="show" x-description="Notification panel, show/hide based on alert state."
        x-transition:enter="transform ease-out duration-300 transition"
        x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="w-full max-w-sm bg-white rounded-lg shadow-lg pointer-events-auto"
        style="display: none;">
        <div class="overflow-hidden rounded-lg shadow-xs">
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg :class="{'text-red-400': isError, 'text-m-orange': !isError}" class="w-6 h-6"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="mx-4 w-0 flex-1 pt-0.5">
                        <p x-text="message" class="text-sm font-medium leading-5 text-gray-900"></p>
                    </div>
                    <div class="flex flex-shrink-0 ml-4">
                        <button @click="show = false"
                            class="inline-flex text-gray-400 transition duration-150 ease-in-out focus:outline-none focus:text-gray-500">
                            <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
