<x-layout.admin class="index">
    <h2 class="title">Permintaan File</h2>
    <x-form action="{{ route('admin.request.store') }}" method="POST">
        <x-input type="select-search" name="user_id" label="Penerima" :options="json_encode($users)" placeholder="Masukkan NIP/Nama" :required="true" />
        <x-input type="textarea" name="description" label="Pesan" placeholder="Pesan mengenai file yang diminta" :required="true" />
        <x-button type="submit">Kirim</x-button>
    </x-form>
    <x-table>
        <x-slot:head>
            <th>Penerima</th>
            <th>Pesan</th>
            <th>File</th>
        </x-slot:head>
        <x-slot:body>
            @forelse ($fields as $field)
                <tr>
                    <td style="min-width: 20em">{{ $field->user->pegawai->dataPegawais()->where('data_id', 1)->first()->record }}</td>
                    <td>{{ $field->description }}</td>
                    <td align="center" style="white-space: nowrap">
                        @if ($field->files->last())
                            <a href="{{ route('admin.request.download', ['file' => $field->files->last()]) }}">Download</a>
                        @else
                            <span style="opacity: .5">Belum dikirim<span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="empty" colspan="100">Belum ada data.</td>
                </tr>
            @endforelse
        </x-slot:body>
    </x-table>
</x-layout.admin>