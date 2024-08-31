@switch($type)
    @case('link')
        <a 
            class="button {{ $class }}"
            @if($href) href="{{ $href }}" @endif
            {{ $attributes }}
            >{{ $slot }}</a>
        @break
    @default
        <button 
            type="{{ $type }}"
            class="button {{ $class }}"
            @if($wire) wire:click="{{ $wire }}" @endif
            {{ $attributes }}
            >{{ $slot }}</button>
@endswitch