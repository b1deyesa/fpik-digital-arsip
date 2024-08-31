<form
    @if($id) id="{{ $id }}" @endif
    class="form {{ $class }}"
    @if($action) action="{{ $action }}" @endif
    @if($method) method="{{ $method }}" @endif
    @if($wire) wire:submit="{{ $wire }}" @endif
    >
    @if($method !== 'GET') @csrf @endif
    @if($method_name) @method($method_name) @endif
    {{ $slot }}
</form>