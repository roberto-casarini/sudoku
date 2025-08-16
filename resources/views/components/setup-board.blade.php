<div x-data="setupBoard('{{ $currentState }}')" class="flex flex-col gap-1 w-auto p-3 bg-white">
    <button 
        type="button"
        class="bg-sky-500 hover:bg-sky-700 w-full text-white px-4 font-semibold rounded-full cursor-pointer transition duration-500 ease-in-out disabled:bg-gray-500 disabled:cursor-not-allowed"
        :disabled="isSetupDisabled"
        x-cloak
        @click="setup"
    >
        Setup
    </button>
    <button 
        type="button"
        class="bg-sky-500 hover:bg-sky-700 w-full text-white px-4 font-semibold rounded-full cursor-pointer transition duration-500 ease-in-out disabled:bg-gray-500 disabled:cursor-not-allowed"
        :disabled="isStartDisabled"
        x-cloak
        click="play"
    >
        Start
    </button>
    <button 
        type="button"
        class="bg-sky-500 hover:bg-sky-700 w-full text-white px-4 font-semibold rounded-full cursor-pointer transition duration-500 ease-in-out disabled:bg-gray-500 disabled:cursor-not-allowed"
        :disabled="isStopDisabled"
        x-cloak
        click="stop"
    >
        Stop
    </button>
    <button 
        type="button"
        class="bg-sky-500 hover:bg-sky-700 w-full text-white px-4 font-semibold rounded-full cursor-pointer transition duration-500 ease-in-out disabled:bg-gray-500 disabled:cursor-not-allowed"
        :disabled="isPauseDisabled"
        x-cloak
        click="pause"
        x-text="pauseButtonText"
    >
    </button>
    <button 
        type="button"
        class="bg-sky-500 hover:bg-sky-700 w-full text-white px-4 font-semibold rounded-full cursor-pointer transition duration-500 ease-in-out disabled:bg-gray-500 disabled:cursor-not-allowed"
        :disabled="isResetDisabled"
        click="resetGame"
        x-cloak
    >
        Reset
    </button>                    
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('setupBoard', (currentState) => ({
            state: 'beginning',
            init() {
                this.state = currentState;
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
            isResetDisabled() {
                return this.state !== 'end';
            },
            setup() {
                // chiamo con un push un metodo dal controller
                // modifico lo stato in base alla risposta 
            }
        }));
    });
</script>