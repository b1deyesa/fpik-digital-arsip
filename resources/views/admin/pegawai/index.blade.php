<x-layout.admin class="pegawai-index">
    <h2 class="title">Data Pegawai</h2>
    <x-form action="{{ route('admin.data.store') }}" method="POST">
        <x-input type="text" label="Tambah Kolom" name="label" placeholder="Masukkan nama kolom" />
        <x-button type="submit"><i class="fas fa-plus"></i></x-button>
    </x-form>
    <div class="table-container">
        <x-table>
            <x-slot:head>
                <th>NIP</th>
                @foreach ($datas as $data)
                    <th>
                        <div class="head">
                            {{ $data->label }}
                            <x-modal class="modal-confirm">
                                <x-slot:trigger>
                                    <x-button><i class="fas fa-trash"></i></x-button>
                                </x-slot:trigger>
                                <h6 class="title">Hapus Kolom</h6>
                                <p>Kolom <b>{{ $data->label }}</b> akan dihapus secara permanen</p>
                                <div class="buttons">
                                    <x-button x-on:click="open = false">Batal</x-button>
                                    <x-form action="{{ route('admin.data.destroy', compact('data')) }}" method="DELETE">
                                        <x-button type="submit">Hapus</x-button>
                                    </x-form>
                                </div>
                            </x-modal>
                        </div>
                    </th>
                @endforeach
                <th></th>
            </x-slot:head>
            <x-slot:body>
                <x-form action="{{ route('admin.pegawai.store') }}" method="POST">
                    <tr>
                        <td style="vertical-align: top"><x-input type="text" name="nip" placeholder="NIP" /></td>
                        @foreach ($datas as $data)
                            <td style="vertical-align: top"><x-input type="text" name="data-{{ $data->id }}" placeholder="{{ $data->label }}" /></td>
                        @endforeach
                        <td width="1%"><x-button type="submit">Kirim</x-button></td>
                    </tr>
                </x-form>
                @foreach ($pegawais as $pegawai)
                    <x-form action="{{ route('admin.pegawai.update', compact('pegawai')) }}" method="PUT">
                        <tr>
                            <td class="edit-{{ $pegawai->id }}" data-value="nip">{{ $pegawai->user->nip }}</td>
                            @foreach ($datas as $data)
                                @php
                                    $dataPegawai = $pegawai->dataPegawais->firstWhere('data_id', $data->id);
                                @endphp
                                <td class="edit-{{ $pegawai->id }}" data-value="data-{{ $data->id }}">{{ $dataPegawai->record ?? '' }}</td>
                            @endforeach
                            <td width="1%">
                                <div class="action action-{{ $pegawai->id }}">
                                    <x-button class="edit" data-target="{{ $pegawai->id }}">Edit</x-button>
                                    <x-modal class="modal-confirm">
                                        <x-slot:trigger>
                                            <x-button>Hapus</x-button>
                                        </x-slot:trigger>
                                        <h6 class="title">Hapus Pegawai</h6>
                                        <p>Data akan dihapus secara permanen</p>
                                        <div class="buttons">
                                            <x-button x-on:click="open = false">Batal</x-button>
                                            <x-form action="{{ route('admin.pegawai.destroy', compact('pegawai')) }}" method="DELETE">
                                                <x-button type="submit">Hapus</x-button>
                                            </x-form>
                                        </div>
                                    </x-modal>
                                </div>
                                <div class="action-confirm confirm-{{ $pegawai->id }}">
                                    <x-button class="cancel" data-target="{{ $pegawai->id }}">Batal</x-button>
                                    <x-button type=submit>Simpan</x-button>
                                </div>
                            </td>
                        </tr>
                    </x-form>
                @endforeach
            </x-slot:body>
        </x-table>
    </div>
    @push('scripts')
        <script>
            $('.edit[data-target]').on('click', function() {
                var id = $(this).data('target');
                
                $('.edit[data-target]').not(`[data-target="${id}"]`).each(function() {
                    var otherId = $(this).data('target');
                    var $otherCells = $('.edit-' + otherId);
                    var $otherAction = $('.action-' + otherId);
                    var $otherConfirm = $('.confirm-' + otherId);
                    $otherCells.each(function() {
                        var $otherCell = $(this);
                        if ($otherCell.find('input').length) {
                            var originalValue = $otherCell.data('original-value');
                            $otherCell.html(originalValue);
                        }
                    });
                    $otherConfirm.hide();
                    $otherAction.show();
                });

                var $cells = $('.edit-' + id);
                var $action = $('.action-' + id);
                var $confirm = $('.confirm-' + id);

                $cells.each(function() {
                    var $cell = $(this);
                    
                    if ($cell.find('input').length) {
                        var value = $cell.find('input').val();
                        $cell.html(value);
                    } else {
                        var text = $cell.text();
                        var name = $cell.data('value');
                        $cell.data('original-value', text);
                        var inputComponent = `<x-input type="text" name="` + name + `"  value="` + text + `"/>`;
                        $cell.html(inputComponent);
                    }
                });
                $action.hide();
                $confirm.show();
            });

            $('.cancel[data-target]').on('click', function() {
                var id = $(this).data('target');

                var $cells = $('.edit-' + id);
                var $action = $('.action-' + id);
                var $confirm = $('.confirm-' + id);
                $cells.each(function() {
                    var $cell = $(this);
                    if ($cell.find('input').length) {
                        var originalValue = $cell.data('original-value');
                        $cell.html(originalValue);
                    }
                });
                $confirm.hide();
                $action.show();
            });
        </script> 
    @endpush
</x-layout.admin>