<div x-data="flashMessage">
    <!-- Modal overlay and content -->
    <div
        x-show="showModal"
        class="fixed inset-0 flex items-center justify-center z-50"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        style="background-color: rgba(0, 0, 0, 0.4);"
        x-cloak>
        <!-- Modal content -->
        <div
            class="bg-white rounded-lg p-6 w-1/3 relative"
            @click.away="showModal = false"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95">
            <h2 class="text-xl font-semibold mb-4" x-text="title"></h2>
            <p class="mb-4" x-text="message"></p>
            <button class="bg-red-500 text-white px-4 py-2 rounded" @click="showModal = false">Close</button>
        </div>
    </div>
</div>

@script
<script>
    Alpine.data('flashMessage', () => ({
        showModal: false,
        title: '',
        message: '',
        type: 'warning',
        msDelay: 3000,
        init() {
            $watch('showModal', (value) => {
                if (value) {
                    setTimeout(() => {
                        this.showModal = false;
                    }, this.msDelay);
                }
            });
            Livewire.on('flash_message', (event) => {
                this.title = event.title;
                this.message = event.message;
                this.type = event.type;
                this.showModal = true;
            });
        }
    }));
</script>
@endscript