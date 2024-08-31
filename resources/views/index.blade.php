<x-layout.app class="login">
    <div class="container">
        <h1 class="title">Digital Arsip</h1>
        <x-form action="{{ route('login.post') }}" method="POST">
            <x-input type="text" label="Nomor Induk Pegawai (NIP)" name="nip" :autofocus="true" />
            <x-input type="password" label="Password" name="password" />
            <x-button type="submit">Masuk</x-button>
        </x-form>
    </div>
</x-layout.app>