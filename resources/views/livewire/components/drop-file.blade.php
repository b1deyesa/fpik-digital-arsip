<div  class="drop-file">
    <div class="drop-file-container">
        @if ($data)
            <x-form wire="save()">
                <label for="{{ $id }}" class="label">Nama File</label>
                <div class="file-input">
                    <input type="text" id="{{ $id }}" name="{{ $name }}" wire:model="data.name" value="{{ $data['name'] }}" autofocus>
                    <input type="text" value="{{ $data['extension'] }}" disabled>
                </div>
                @error('data.name')
                    <span class="error">{{ $message }}</span>
                @enderror
                <div class="buttons">
                    <x-button wire="cancel()">Batal</x-button>
                    <x-button type="submit">Kirim</x-button>
                </div>
            </x-form>
        @else
            <label for="{{ $id }}">
                <input type="file" id="{{ $id }}" name="{{ $name }}" wire:model="file"><i class="fa-solid fa-arrow-up-from-bracket"></i>
                Click atau Drop File
                <small>File yang diupload maximal 30 MB</small>
            </label>
        @endif
    </div>
    @error('file')
        <span class="error">{{ $message }}</span>
    @enderror
</div>
