<div class="">
    <button 
        wire:click="toggleBtn"
        @class([
            "w-full text-sm border border-gray-200 px-2 py-1 rounded-lg cursor-pointer transition duration-500 ease-in-out",
            "bg-sky-300" => $settingUp,
            "bg-white hover:bg-yellow-300" => !$settingUp
        ])    
    >{{ $title }}</button>
</div>