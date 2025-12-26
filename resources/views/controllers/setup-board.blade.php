<div x-data="setupBoard()" class="flex flex-col gap-1 w-auto p-3 bg-white">
    <button 
        type="button"
        class="bg-sky-500 hover:bg-sky-700 w-full text-white px-4 font-semibold rounded-full cursor-pointer transition duration-500 ease-in-out disabled:bg-gray-500 disabled:cursor-not-allowed"
        :disabled="isSetupDisabled"
        x-cloak
        @click="setStatus('setup')"
    >
        Setup
    </button>
    <button 
        type="button"
        class="bg-sky-500 hover:bg-sky-700 w-full text-white px-4 font-semibold rounded-full cursor-pointer transition duration-500 ease-in-out disabled:bg-gray-500 disabled:cursor-not-allowed"
        :disabled="isStartDisabled"
        x-cloak
        @click="setStatus('playing')"
    >
        Play
    </button>
    <button 
        type="button"
        class="bg-sky-500 hover:bg-sky-700 w-full text-white px-4 font-semibold rounded-full cursor-pointer transition duration-500 ease-in-out disabled:bg-gray-500 disabled:cursor-not-allowed"
        :disabled="isStopDisabled"
        x-cloak
        @click="setStatus('end')"
    >
        Finish
    </button>
    <button 
        type="button"
        class="bg-sky-500 hover:bg-sky-700 w-full text-white px-4 font-semibold rounded-full cursor-pointer transition duration-500 ease-in-out disabled:bg-gray-500 disabled:cursor-not-allowed"
        :disabled="isPauseDisabled"
        x-cloak
        @click="setStatus('paused')"
        x-text="pauseButtonText"
    >
    </button>
    <button 
        type="button"
        class="bg-sky-500 hover:bg-sky-700 w-full text-white px-4 font-semibold rounded-full cursor-pointer transition duration-500 ease-in-out disabled:bg-gray-500 disabled:cursor-not-allowed"
        :disabled="isBackDisabled"
        x-cloak
        @click="backOneMove"
    >
        Back One Move
    </button>
    <button 
        type="button"
        class="bg-sky-500 hover:bg-sky-700 w-full text-white px-4 font-semibold rounded-full cursor-pointer transition duration-500 ease-in-out disabled:bg-gray-500 disabled:cursor-not-allowed"
        :disabled="isResetDisabled"
        @click="resetGame"
        x-cloak
    >
        Reset
    </button>                    
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('setupBoard', () => ({
            state: 'beginning',
            init() {
                const obj = this;
                const store = Alpine.store('game');
                
                // Initialize state from store if available
                if (store.game_status) {
                    obj.state = store.game_status;
                }
                
                // Watch for changes to store game_status
                this.$watch('$store.game.game_status', function (value) {
                    if (value) {
                        obj.state = value;
                    }
                });
            },
            pauseButtonText() {
                return "Pause";
            },
            isSetupDisabled() {
                return this.state !== 'beginning';
            },
            isStartDisabled() {
                return this.state !== 'setup';
            },
            isStopDisabled() {
                return ['beginning', 'setup', 'end'].includes(this.state);
            },
            isPauseDisabled() {
                return !['playing', 'paused'].includes(this.state);
            },
            isBackDisabled() {
                return !['playing', 'paused'].includes(this.state);
            },
            isResetDisabled() {
                return this.state !== 'end';
            },
            setStatus(state) {
                const store = Alpine.store('game');
                store.setStatus(state);
                // State will be updated via watch when store updates
            },
            resetGame() {
                const store = Alpine.store('game');
                store.resetGame();
                // State will be updated via watch when store updates
            },
            backOneMove() {
                const store = Alpine.store('game');
                store.backOneMove();
            }
        }));
    });
</script>