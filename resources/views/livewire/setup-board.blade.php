<div class="flex flex-col gap-1 w-auto p-3 bg-white">
    <button 
        type="button"
        class="bg-sky-500 hover:bg-sky-700 w-full text-white px-4 font-semibold rounded-full cursor-pointer transition duration-500 ease-in-out disabled:bg-gray-500 disabled:cursor-not-allowed"
        {{ $this->isSetupDisabled() ? 'disabled' : '' }}
        x-cloak
        wire:click="setup"
    >
        Setup
    </button>
    <button 
        type="button"
        class="bg-sky-500 hover:bg-sky-700 w-full text-white px-4 font-semibold rounded-full cursor-pointer transition duration-500 ease-in-out disabled:bg-gray-500 disabled:cursor-not-allowed"
        {{ $this->isStartDisabled() ? 'disabled' : '' }}
        x-cloak
        wire:click="play"
    >
        Start
    </button>
    <button 
        type="button"
        class="bg-sky-500 hover:bg-sky-700 w-full text-white px-4 font-semibold rounded-full cursor-pointer transition duration-500 ease-in-out disabled:bg-gray-500 disabled:cursor-not-allowed"
        {{ $this->isStopDisabled() ? 'disabled' : '' }}
        x-cloak
        wire:click="stop"
    >
        Stop
    </button>
    <button 
        type="button"
        class="bg-sky-500 hover:bg-sky-700 w-full text-white px-4 font-semibold rounded-full cursor-pointer transition duration-500 ease-in-out disabled:bg-gray-500 disabled:cursor-not-allowed"
        {{ $this->isPauseDisabled() ? 'disabled' : '' }}
        x-cloak
        wire:click="pause"
    >
        {{ $this->pauseButtonText }}
    </button>
    <button 
        type="button"
        class="bg-sky-500 hover:bg-sky-700 w-full text-white px-4 font-semibold rounded-full cursor-pointer transition duration-500 ease-in-out disabled:bg-gray-500 disabled:cursor-not-allowed"
        {{ $this->isResetDisabled() ? 'disabled' : '' }}
        wire:click="resetGame"
        x-cloak
    >
        Reset
    </button>                    
</div>
