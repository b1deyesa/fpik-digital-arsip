<div class="input">
    
    @if($label)
        <label for="{{ $id }}" class="label">{{ $label }}@if($required)<span>*</span>@endif</label>
    @endif
    
    @switch($type)
        @case('range')
            <input 
                type="range"
                id="{{ $id }}"
                name="{{ $name }}"
                class="range {{ $class ?? null }}" 
                @if($wire) wire:model="{{ $wire }}" @endif
                @if($min) min="{{ $min }}" @endif
                @if($max) max="{{ $max }}" @endif
                @if($step) step="{{ $step }}" @endif
                @if(old($name, $value)) value="{{ old($name, $value) }}" @endif
                @if($disabled) disabled @endif
                {{ $attributes }}
                >
            @break
        @case('radio')
            <div class="options">
                @foreach ($options as $key => $option)
                    <label for="{{ $name }}{{ $key }}" class="radio" >
                        <input 
                            type="radio" 
                            id="{{ $name }}{{ $key }}" 
                            name="{{ $name }}" 
                            value="{{ $key }}"
                            @if($class) class="{{ $class }}" @endif
                            @if($wire) wire:model="{{ $wire }}" @endif
                            @if(old($name, $value)) @checked($key === old($name, $value)) @endif
                            {{ $attributes }}
                            >
                        {{ $option }}
                    </label>
                @endforeach
            </div>
            @break
        @case('checkbox')
            <div class="options">
                @foreach ($options as $key => $option)
                    <label for="{{ $name }}{{ $key }}" class="checkbox">
                        <input 
                            type="checkbox"  
                            id="{{ $name }}{{ $key }}" 
                            name="{{ $name }}[{{ $key }}]" 
                            value="{{ $option }}"
                            @if($class) class="{{ $class }}" @endif
                            @if($wire) wire:model="{{ $wire }}.{{ $key }}" @endif
                            @if(old($name, $value)) @checked(in_array($key, old($name, $value))) @endif
                            {{ $attributes }}
                            >
                        {{ $option }}
                    </label>
                @endforeach
            </div>
            @break
        @case('color')
            <input 
                type="color"
                id="{{ $id }}"
                name="{{ $name }}"
                class="color {{ $class ?? null }}" 
                @if($wire) wire:model="{{ $wire }}" @endif
                @if(old($name, $value)) value="{{ old($name, $value) }}" @endif
                @if($disabled) disabled @endif
                {{ $attributes }}
                > 
            @break
        @case('drop-file')
            @livewire('components.drop-file', ['id' => $id, 'name' => $name, 'field' => $field])
            @break
        @case('textarea')
            <textarea 
                id="{{ $id }}"
                name="{{ $name }}"
                @if($class) class="{{ $class }}" @endif
                @if($cols) cols="{{ $cols }}" @endif
                @if($rows) rows="{{ $rows }}" @endif
                @if($wire) wire:model="{{ $wire }}" @endif
                @if($placeholder) placeholder="{{ $placeholder }}" @endif
                @if($readonly) readonly @endif
                @if($disabled) disabled @endif
                @if($autofocus) autofocus @endif
                {{ $attributes }}
                >@if(old($name, $value)) {{ old($name, $value) }} @endif</textarea>
            @break
        @case('select')
            <div class="select">
                <select
                    id="{{ $id }}"
                    name="{{ $name }}"
                    @if($class) class="{{ $class }}" @endif
                    @if($wire) wire:model="{{ $wire }}" @endif
                    {{ $attributes }}
                    >
                    @if($placeholder) <option value="" selected disabled>{{ $placeholder }}</option> @endif
                    @foreach ($options as $key => $option)
                        <option value="{{ $key }}" @selected($key === old($name, $value))>{{ $option }}</option>
                    @endforeach
                </select>
            </div>
            @break
        @case('select-search')
            <div class="select-search" x-data="selectComponent()" x-init="initialize()">
                <input 
                    type="text" 
                    x-model="search" 
                    x-on:input="open = true"
                    x-on:click="open = true"
                    x-on:click.away="open = false"
                    x-on:keydown.arrow-down.prevent="navigate(1)"
                    x-on:keydown.arrow-up.prevent="navigate(-1)"
                    x-on:keydown.enter.prevent="selectHighlightedOption()"
                    x-ref="input"
                    @if($class) class="{{ $class }}" @endif
                    @if($wire) wire:model="{{ $wire }}" @endif
                    @if($placeholder) placeholder="{{ $placeholder }}" @endif
                    @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
                    @if($readonly) readonly @endif
                    @if($disabled) disabled @endif
                    {{ $attributes }}
                >
                <input type="hidden" id="{{ $id }}" name="{{ $name }}" :value="selectedIndex">
                <ul x-show="open" x-on:click.away="open = false">
                    <small>Options</small>
                    <template x-if="Object.keys(filteredOptions).length === 0">
                        <li><small>No data available</small></li>
                    </template>
                    <template x-for="(option, key) in filteredOptions" :key="key">
                        <li
                            x-bind:class="{ 'highlighted': key === highlightedIndex }"
                            x-text="option"
                            x-on:click="selectOption(key)"
                        ></li>
                    </template>
                </ul>
            </div>
            <script>
                function selectComponent() {
                    return {
                        open: false,
                        search: '',
                        options: @json($options),
                        highlightedIndex: null,
                        selectedIndex: @json(old($name, $value)),
                        initialize() {
                            // Set initial search value based on selectedIndex
                            if (this.selectedIndex !== null) {
                                this.search = this.options[this.selectedIndex];
                            }
                        },
                        get filteredOptions() {
                            const lowercasedSearch = this.search.toLowerCase();
                            return Object.entries(this.options)
                                .filter(([key, value]) => value.toLowerCase().includes(lowercasedSearch))
                                .reduce((acc, [key, value]) => {
                                    acc[key] = value;
                                    return acc;
                                }, {});
                        },
                        selectOption(key) {
                            this.search = this.options[key];
                            this.selectedIndex = key;
                            this.open = false;
                            this.$refs.input.blur();
                        },
                        navigate(direction) {
                            if (!this.open) return;
                            const keys = Object.keys(this.filteredOptions);
                            if (keys.length === 0) return;
                            const currentIndex = keys.indexOf(this.highlightedIndex);
                            const nextIndex = (currentIndex + direction + keys.length) % keys.length;
                            this.highlightedIndex = keys[nextIndex];
                            this.$refs.input.focus();
                        },
                        selectHighlightedOption() {
                            if (this.highlightedIndex !== null) {
                                this.selectOption(this.highlightedIndex);
                            }
                        }
                    }
                }
            </script>
            @break
        @default
            <input
                type="{{ $type }}"
                id="{{ $id }}"
                name="{{ $name }}"
                @if($class) class="{{ $class }}" @endif
                @if($wire) wire:model="{{ $wire }}" @endif
                @if(old($name, $value)) value="{{ old($name, $value) }}" @endif
                @if($placeholder) placeholder="{{ $placeholder }}" @endif
                @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
                @if($readonly) readonly @endif
                @if($disabled) disabled @endif
                @if($autofocus) autofocus @endif
                {{ $attributes }}
                >
    @endswitch
    
    @error($name)
        <span class="error">{{ $message }}</span>
    @enderror
    
</div>