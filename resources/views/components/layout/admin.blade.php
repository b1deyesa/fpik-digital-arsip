<x-layout.app class="admin">
    <span id="openSidebar"><i class="fas fa-bars"></i></span>
    <div class="sidebar">
        <span id="closeSidebar"><i class="fas fa-xmark"></i></span>
        <div class="banner">
            <h1 class="title">FPIK Digital Arsip</h1>
        </div>
        <div class="menu">
            <a href="{{ route('admin.index') }}">Permintaan File</a>
            <a href="{{ route('admin.arsip.index') }}">Arsip</a>
            <a href="{{ route('admin.pegawai.index') }}">Data Pegawai</a>
        </div>
        <x-modal class="modal-confirm">
            <x-slot:trigger>
                <x-button><i class="fa-solid fa-right-from-bracket"></i> Keluar</x-button>
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
    </div>
    <section @if($class) class="{{ $class }}" @endif>
        {{ $slot }}
    </section>
    @push('scripts')
        <script>
            $('#openSidebar').on('click', function() {
                $('.sidebar').css('display', 'flex');
                $('#openSidebar').hide();
            });
            $('#closeSidebar').on('click', function() {
                $('.sidebar').hide();
                $('#openSidebar').show();
            });
        </script>
    @endpush
</x-layout.app>