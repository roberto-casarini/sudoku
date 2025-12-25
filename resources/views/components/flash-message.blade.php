<div>
    @if($show && $message)
    <!-- Modal overlay and content -->
    <div
        x-data="{ 
            show: @entangle('show'),
            timeout: @entangle('timeout'),
            timeoutId: null,
            type: '{{ $type ?? 'warning' }}'
        }"
        x-show="show"
        x-init="
            const obj = this;
            function startTimeout() {
                if (obj.timeoutId) clearTimeout(obj.timeoutId);
                if (obj.show && obj.timeout > 0) {
                    obj.timeoutId = setTimeout(() => {
                        show = false;
                        $wire.close();
                    }, obj.timeout);
                }
            }
            $watch('show', value => {
                if (value) {
                    // Update type from Livewire
                    obj.type = $wire.get('type') || 'warning';
                    startTimeout();
                } else if (obj.timeoutId) {
                    clearTimeout(obj.timeoutId);
                    obj.timeoutId = null;
                }
            });
            // Start timeout if already showing on mount
            if (obj.show && obj.timeout > 0) {
                startTimeout();
            }
        "
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
            @click.away="show = false; $wire.close()"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            x-cloak>
            <h2 class="text-xl font-semibold mb-4">{{ $title }}</h2>
            <p class="mb-4">{{ $message }}</p>
            <button 
                class="px-4 py-2 rounded"
                :class="{
                    'bg-orange-500 text-white': type === 'warning',
                    'bg-red-500 text-white': type === 'error',
                    'bg-blue-500 text-white': type === 'info',
                    'bg-green-500 text-white': type === 'success'
                }" 
                @click="show = false; $wire.close()"
            >
                Close
            </button>
        </div>
    </div>
    @endif
</div>
