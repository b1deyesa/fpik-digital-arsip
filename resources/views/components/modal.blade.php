<div x-data="{ open: false }">
    <div class="trigger" x-on:click="open = ! open">{!! $trigger !!}</div>
    <template x-teleport="body">
        <div class="modal" x-show="open" x-trap="open" x-transition.opacity.80>
            <div class="container-modal {{ $class }}" @click.outside="open = false" x-cloak>
                @if($close) <button type="button" class="close-modal" x-on:click="open = false"><i class="fa-solid fa-xmark"></i></button> @endif
                {{ $slot }}
            </div>
        </div>
    </template>
</div>