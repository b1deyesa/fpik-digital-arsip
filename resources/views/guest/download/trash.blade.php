<x-layout.guest class="download-trash" back="{{ route('guest.download.index') }}">
    <ul>
        @forelse ($files as $file)
            <li>
                <h6 class="title">
                    @if(in_array(pathinfo($file->path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                        <i class="fa-regular fa-file-image"></i>
                    @elseif(pathinfo($file->path, PATHINFO_EXTENSION) === 'pdf')
                        <i class="fa-regular fa-file-pdf"></i>
                    @elseif(in_array(pathinfo($file->path, PATHINFO_EXTENSION), ['doc', 'docx']))
                        <i class="fa-regular fa-file-word"></i>
                    @elseif(in_array(pathinfo($file->path, PATHINFO_EXTENSION), ['xls', 'xlsx']))
                        <i class="fa-regular fa-file-excel"></i>
                    @elseif(in_array(pathinfo($file->path, PATHINFO_EXTENSION), ['ppt', 'pptx']))
                        <i class="fa-regular fa-file-powerpoint"></i>
                    @else
                        <i class="fa-regular fa-file"></i>
                    @endif
                    {{ $file->name }}
                </h6>
                <div class="action">
                    <div class="buttons">
                        <x-modal class="modal-confirm">
                            <x-slot:trigger>
                                <x-button><i class="fas fa-trash"></i></x-button>
                            </x-slot:trigger>
                            <h6 class="title">Hapus Permanen</h6>
                            <p>File akan dihapus permanen</p>
                            <div class="buttons">
                                <x-button x-on:click="open = false">Batal</x-button>
                                <x-form action="{{ route('guest.download.destroy', compact('file')) }}" method="DELETE">
                                    <x-button type="submit">Hapus</x-button>
                                </x-form>
                            </div>
                        </x-modal>
                        <x-modal class="modal-confirm">
                            <x-slot:trigger>
                                <x-button><i class="fas fa-arrow-rotate-left"></i>Pulihkan</x-button>
                            </x-slot:trigger>
                            <h6 class="title">Pulihkan File</h6>
                            <p>File akan dikembalikan ke dalam arsip</p>
                            <div class="buttons">
                                <x-button x-on:click="open = false">Batal</x-button>
                                <x-form action="{{ route('guest.download.restore') }}" method="POST">
                                    <input type="hidden" name="file" value="{{ $file->id }}">
                                    <x-button type="submit">Pulihkan</x-button>
                                </x-form>
                            </div>
                        </x-modal>
                    </div>
                </div>
            </li>
        @empty 
            <span class="empty">Data tidak tersedia.</span>
        @endforelse
    </ul>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#order').on('change', function() {
                    $('#feature').submit();
                });
                $('#search').on('keydown', function(event) {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                        $('#feature').submit();
                    }
                });
            });
        </script>    
    @endpush
</x-layout.guest>