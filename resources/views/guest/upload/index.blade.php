<x-layout.guest class="upload-index" back="{{ route('guest.index') }}">
    <x-input type="drop-file" name="upload" />
    <hr>
    @if ($fields)
        <div class="required">
            <h2 class="title">File yang harus diunggah</h2>
            <ul>
                @forelse ($fields as $field)
                    <li>
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>
                            <h6 class="description">{{ $field->description }}</h6>
                            <x-modal class="modal-confirm" :close="true">
                                <x-slot:trigger>
                                    <x-button>Unggah Disini</x-button>
                                </x-slot:trigger>
                                <h6 class="title">Unggah File</h6>
                                <p>{{ $field->description }}</p>
                                <x-input type="drop-file" name="request" id="request-{{ $field->id }}" field="{{ $field->id }}" />
                            </x-modal>
                        </span>
                    </li>
                @empty
                    <span class="empty">Belum ada.</span>
                @endforelse
            </ul>
        </div>
    @endif
</x-layout.guest>