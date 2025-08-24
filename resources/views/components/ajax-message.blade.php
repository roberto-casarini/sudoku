<!-- Modal overlay and content -->
<div
    x-data="ajaxMessage"
    x-show="show"
    class="fixed inset-0 flex items-center justify-center z-50"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    style="background-color: rgba(0, 0, 0, 0.4);"
    x-cloak>

    <div
        x-show="show"
        class="bg-white rounded-lg p-6 w-1/3 relative"
        @click.away="closeModal"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200 transform"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        x-cloak>
        <h2 class="text-xl font-semibold mb-4" x-text="title"></h2>
        <p class="mb-4" x-text="message"></p>
        <button 
            class="px-4 py-2 rounded"
            :class="{
                'bg-orange-500 text-white': type === 'warning',
                'bg-red-500 text-white': type === 'error',
                'bg-blue-500 text-white': type === 'info',
                'bg-green-500 text-white': type === 'success'
            }" 
            @click="closeModal"
        >
            Close
        </button>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('ajaxMessage', () => ({
            show: false,
            title: '',
            message: '',
            type: 'warning',
            timeout: 3000,
            init() {
                const obj = this;
                this.$watch('$store.game.error', function (value) {
                    if (value.length > 0) {
                        const store = Alpine.store('game');
                        obj.title = store.error_title;
                        obj.message = store.error;
                        obj.type = store.error_type;
                        obj.timeout = store.error_timeout;
                        obj.show = true;
                        if (obj.timeout > 0) {
                            setTimeout(() => obj.show = false, obj.timeout);
                            store.resetError();
                        }
                    }
                });
            },
            closeModal() {
                this.show = false;
            }
        }));
    });
</script>
