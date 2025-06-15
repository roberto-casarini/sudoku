<div 
    class="grid grid-cols-3 w-max"  
    wire:mouseout="unsetHovering"
    wire:click.outside="sendValues"
    wire:keyup.esc="closeEdit"
>
    @foreach (range(1, 9) as $i)
    <div 
        wire:mouseover="setHovering({{$i}})"
        wire:click="selectValue({{$i}})"
        @class([
            'text-center align-middle h-8 w-8 cursor-pointer text-2xl border-1',
            'bg-yellow-300 text-black' => $this->isHovering($i),
            'bg-white text-black' => !$this->isHovering($i) && !$this->isSelected($i),
            'bg-green-700 text-white' => $this->isSelected($i)    
        ]);
    >
        {{ $i }}
    </div>
    @endforeach
</div>
