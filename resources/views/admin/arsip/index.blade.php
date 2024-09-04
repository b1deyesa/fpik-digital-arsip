<x-layout.admin>
    <h4 class="title">Arsip</h4>
    @foreach ($pegawais as $key => $pegawai)
        <ul>
            <li>{{ $key }}</li>
            @foreach ($pegawai as $data)
                <ul>
                    <li>
                        <h6>{{ $data['nip'] }}</h6>
                        <h6>{{ $data['nama'] }}</h6>
                        <a href="">Lihat</a>
                    </li>
                </ul>
            @endforeach
        </ul>
    @endforeach
</x-layout.admin>
