<x-layout.guest class="index">
    <x-button type="link" href="{{ route('guest.upload.index') }}">
        <i class="fa-solid fa-arrow-up-from-bracket"></i>
        <h2 class="title">Upload</h2>
        @if ($number_required)
            <div class="number-required">{{ $number_required }}</div>
        @endif
    </x-button>
    <x-button type="link" href="{{ route('guest.download.index') }}">
        <i class="fa-solid fa-cloud-arrow-down"></i>
        <h2 class="title">Download</h2>
    </x-button>
</x-layout.guest>