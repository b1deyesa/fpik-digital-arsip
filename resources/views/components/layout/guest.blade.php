<x-layout.app class="guest">
    <div class="container">
        <header>
            @if ($back)
                <a href="{{ $back }}"><i class="fa-solid fa-arrow-left"></i></a>
            @endif
            <h1 class="title">Digital Arsip</h1>
            <x-modal class="modal-confirm">
                <x-slot:trigger>
                    <x-button><i class="fa-solid fa-right-from-bracket"></i></x-button>
                </x-slot:trigger>
                <h6 class="title">Logout</h6>
                <p>Keluar dari digital arsip</p>
                <x-form action="{{ route('logout') }}" method="POST">
                    <div class="buttons">
                        <x-button x-on:click="open = false">Batal</x-button>
                        <x-button type="submit">Keluar</x-button>
                    </div>
                </x-form>
            </x-modal>
        </header>
        <section @if($class) class="{{ $class }}" @endif>
            {{ $slot }}
        </section>
    </div>
</x-layout.app>