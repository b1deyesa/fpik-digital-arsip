@if (session())    
    <div class="alert">
        @if (session()->has('error'))
            <div class="alert-container danger" x-data="{ open: true }" x-show="open" x-transition:enter.duration.500ms x-transition:leave.duration.400ms x-cloak>
                <p class="title">{{ session()->get('error') }}</p>
                <span class="close"><i class="fa-solid fa-xmark"></i></span>
            </div>
        @elseif (session()->has('warning'))
            <div class="alert-container warning" x-data="{ open: true }" x-show="open" x-transition:enter.duration.500ms x-transition:leave.duration.400ms x-cloak>
                <p class="title">{{ session()->get('warning') }}</p>
                <span class="close"><i class="fa-solid fa-xmark"></i></span>
            </div>
        @elseif (session()->has('success'))
            <div class="alert-container success" x-data="{ open: true }" x-show="open" x-transition:enter.duration.500ms x-transition:leave.duration.400ms x-cloak>
                <p class="title">{{ session()->get('success') }}</p>
                <span class="close"><i class="fa-solid fa-xmark"></i></span>
            </div>
        @endif
    </div>
    <script>
        $(document).ready(function() {
            // Swipe up animation
            $('.alert-container').css({ bottom: '-100px', opacity: 0 })
                                .animate({ bottom: '20px', opacity: 1 }, 500)
                                .delay(8000) // Time before hiding the alert
                                .animate({ bottom: '-100px', opacity: 0 }, 400, function() {
                                    $(this).remove();
                                });

            // Close button click handler
            $('.close').on('click', function() {
                $(this).closest('.alert-container').stop().animate({ bottom: '-100px', opacity: 0 }, 400, function() {
                    $(this).remove();
                });
            });

            // Swipe up gesture detection
            let touchStartY = 0;
            let touchEndY = 0;

            $('.alert-container').on('touchstart', function(event) {
                touchStartY = event.originalEvent.touches[0].clientY;
            });

            $('.alert-container').on('touchend', function(event) {
                touchEndY = event.originalEvent.changedTouches[0].clientY;
                handleSwipe();
            });

            function handleSwipe() {
                if (touchEndY < touchStartY - 100) { // Adjust the threshold value as needed
                    $(this).stop().animate({ bottom: '-100px', opacity: 0 }, 400, function() {
                        $(this).remove();
                    });
                }
            }
        });
    </script>
@endif
