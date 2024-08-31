@if (session())    
    <div class="alert">
        @if (session()->has('error'))
            <div class="alert-container danger" x-data="{ open: true }" x-show="open" x-transition:enter.duration.500ms x-transition:leave.duration.400ms x-cloak>
                <p class="title">{{ session()->get('error') }}</p>
                <span class="close" x-on:click="open = false"><i class="fa-solid fa-xmark"></i></span>
            </div>
        @elseif (session()->has('warning'))
            <div class="alert-container warning" x-data="{ open: true }" x-show="open" x-transition:enter.duration.500ms x-transition:leave.duration.400ms x-cloak>
                <p class="title">{{ session()->get('warning') }}</p>
                <span class="close" x-on:click="open = false"><i class="fa-solid fa-xmark"></i></span>
            </div>
        @elseif (session()->has('success'))
            <div class="alert-container success" x-data="{ open: true }" x-show="open" x-transition:enter.duration.500ms x-transition:leave.duration.400ms x-cloak>
                <p class="title">{{ session()->get('success') }}</p>
                <span class="close" x-on:click="open = false"><i class="fa-solid fa-xmark"></i></span>
            </div>
        @endif
    </div>
    <script>
        setTimeout( function() {
            $('.alert').remove();
        }, 10000);
    </script>
@endif