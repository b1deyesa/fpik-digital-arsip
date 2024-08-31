<x-layout.guest class="download-index" back="{{ route('guest.index') }}">
    <x-form method="GET" action="{{ url()->current() }}" class="feature">
        <x-input type="select" name="order" :options="json_encode(['Terbaru', 'Terlama', 'A-Z', 'Z-A'])" :value="request('order')" />
        <x-input type="search" name="search" placeholder="Cari disini" :value="request('search')" />
    </x-form>
    <div class="tools">
        @if ($files->count() > 1)
            <x-button id="downloads">Unduh</x-button>
            <x-modal class="modal-confirm">
                <x-slot:trigger>
                    <x-button id="deletes">Hapus</x-button>
                </x-slot:trigger>
                <h6 class="title">Hapus File</h6>
                <p>File yang dipilih akan dipindahkan ke folder sampah</p>
                <div class="buttons">
                    <x-button x-on:click="open = false">Batal</x-button>
                    <x-button id="action-deletes">Hapus</x-button>
                </div>
            </x-modal>
            <x-button id="select-all"><i class="fas fa-check-double"></i></x-button>
            <x-button id="hide-select-file" class="cancel"><i class="fas fa-xmark"></i>Batal</x-button>
            <x-button id="show-select-file"><i class="fas fa-check"></i>Pilih</x-button>
        @endif
        @if (request()->has('search') && !empty(request()->search))
            <x-button type="link" href="{{ route('guest.download.index') }}" class="clear"><i class="fas fa-xmark"></i>Hapus Pencarian</x-button>
        @endif
        @if ($trash)
            <x-button type="link" href="{{ route('guest.download.trash') }}" class="trash">Tong Sampah</x-button>
        @endif
    </div>
    @error('select-file')
        <span class="error" id="error-select-file">{{ $message }}</span>
    @enderror
    <x-form method="POST" id="form-select-file">
        <ul>
            @forelse ($files as $file)
            <li>
                <span data-target="action-{{ $file->id }}">
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
                    <div class="action" id="action-{{ $file->id }}">
                        <span class="date">{{ $file->created_at->format('d-m-y H:i')  }}</span>
                        <div class="buttons">
                            <x-button type="link" href="{{ route('guest.download.preview', compact('file')) }}"><i class="fas fa-eye"></i></x-button>
                            <x-modal class="modal-confirm">
                                <x-slot:trigger>
                                    <x-button><i class="fas fa-pencil"></i></x-button>
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
                                    <x-button><i class="fas fa-trash"></i></x-button>
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
                                    <x-button><i class="fas fa-download"></i></x-button>
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
                </span>
                <input type="checkbox" name="select-file[{{ $file->id }}]" class="select-file">
            </li>
            @empty 
                <span class="empty">Data tidak tersedia.</span>
            @endforelse
        </ul>
    </x-form>
    @push('scripts')
        <script>
            function updateUrlParameter(param, value) {
                const url = new URL(window.location.href);
                if (value) {
                    url.searchParams.set(param, value);
                } else {
                    url.searchParams.delete(param);
                }
                window.history.replaceState({}, '', url);
            }

            function showSelectFile() {
                updateUrlParameter('select', '1');
                $('.tools .button').hide();
                $('#hide-select-file').css('display', 'flex').show();
                $('#downloads').css('display', 'flex').show();
                $('#deletes').css('display', 'flex').show();
                $('#select-all').css('display', 'flex').show();
                $('.select-file').css('display', 'flex').show();
            }

            function hideSelectFile() {
                updateUrlParameter('select', null);
                $('.tools .button').css('display', 'flex').show();
                $('#hide-select-file').hide();
                $('#error-select-file').hide();
                $('#downloads').hide();
                $('#deletes').hide();
                $('#select-all').hide();
                $('.select-file').prop('checked', false).hide();
            }
            
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
                
                $('span[data-target]').on('click', function() {
                    const targetId = $(this).data('target');
                    const targetElement = $('#' + targetId);
                    if (targetElement.css('display') === 'none') {
                        targetElement.css('display', 'flex');
                    } else {
                        targetElement.css('display', 'none');
                    }
                    $('.action').not(targetElement).hide();
                });
                
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.get('select') === '1') {
                    showSelectFile();
                }
                
                $('#show-select-file').on('click', showSelectFile);
                $('#hide-select-file').on('click', hideSelectFile);
                $('#downloads').on('click', function() {
                    $('#form-select-file').attr('action', "{{ route('guest.download.downloads') }}").submit();
                });
                $('#action-deletes').on('click', function() {
                    $('#form-select-file').attr('action', "{{ route('guest.download.deletes') }}").submit();
                });
                $('#select-all').on('click', function() {
                    $('.select-file').prop('checked', true);
                });
            });
        </script>    
    @endpush
</x-layout.guest>   