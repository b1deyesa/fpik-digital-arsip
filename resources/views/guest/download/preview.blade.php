<x-layout.guest class="download-preview" back="{{ route('guest.download.index') }}">
    <div class="action">
        <span class="info">
            <h3>{{ $file->name  }}</h3>
            <h3>{{ $file->created_at->format('d F Y - H:i')  }}</h3>
        </span>
        <div class="buttons">
            <x-modal class="modal-confirm">
                <x-slot:trigger>
                    <x-button><i class="fas fa-pencil"></i> Ganti Nama</x-button>
                </x-slot:trigger>
                <h6 class="title">Ganti Nama File</h6>
                <x-form action="{{ route('guest.download.rename') }}" method="POST">
                    <input type="hidden" name="file" value="{{ $file->id }}">
                    <x-input type="text" name="name" value="{{ pathinfo($file->name, PATHINFO_FILENAME) }}" />
                    <div class="buttons">
                        <x-button x-on:click="open = false">Batal</x-button>
                        <x-button type="submit">Ganti</x-button>
                    </div>
                </x-form>
            </x-modal>
            <x-modal class="modal-confirm">
                <x-slot:trigger>
                    <x-button><i class="fas fa-trash"></i>Hapus</x-button>
                </x-slot:trigger>
                <h6 class="title">Hapus File</h6>
                <p>File akan dipindahkan ke folder sampah</p>
                <div class="buttons">
                    <x-button x-on:click="open = false">Batal</x-button>
                    <x-form action="{{ route('guest.download.delete') }}" method="POST">
                        <input type="hidden" name="file" value="{{ $file->id }}">
                        <x-button type="submit">Hapus</x-button>
                    </x-form>
                </div>
            </x-modal>
            <x-modal class="modal-confirm">
                <x-slot:trigger>
                    <x-button><i class="fas fa-download"></i>Unduh</x-button>
                </x-slot:trigger>
                <h6 class="title">Unduh File</h6>
                <p>{{ $file->name }}</p>
                <div class="buttons">
                    <x-button x-on:click="open = false">Batal</x-button>
                    <x-form action="{{ route('guest.download.download') }}" method="POST">
                        <input type="hidden" name="file" value="{{ $file->id }}">
                        <x-button type="submit">Unduh</x-button>
                    </x-form>
                </div>
            </x-modal>
        </div>
    </div>
    @if (in_array(pathinfo($file->path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']))
        <img src="{{ asset('storage/' . $file->path) }}" alt="">
    @else
        <iframe src="{{ asset('storage/' . $file->path) }}"></iframe>
    @endif
</x-layout.guest>