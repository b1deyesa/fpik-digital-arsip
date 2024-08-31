<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Data;
use App\Models\DataPegawai;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
    public function index()
    {
        $datas = Data::all();
        $pegawais = Pegawai::with('user', 'dataPegawais')
                            ->join('users', 'pegawais.user_id', '=', 'users.id')
                            ->orderBy('users.nip', 'asc')
                            ->select('pegawais.*')
                            ->get();
                            
        return view('admin.pegawai.index', compact('datas', 'pegawais'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:users,nip'
        ], [
            'nip.required' => 'NIP tidak boleh kosong',
            'nip.unique' => 'NIP telah terdaftar'
        ]);
        
        $datas = [];
        foreach ($request->except(['nip', '_token']) as $key => $value) {
            $new_key = str_replace('data-', '', $key);
            $datas[$new_key] = $value;
        }
        
        $user = User::create([
            'role_id' => 2,
            'nip' => $request->nip,
            'password' => Hash::make($request->nip)
        ]);
        
        $pegawai = Pegawai::create([
            'user_id' => $user->id
        ]);
        
        foreach ($datas as $key => $data) {
            DataPegawai::create([
                'data_id' => $key,
                'pegawai_id' => $pegawai->id,
                'record' => $data
            ]);
        }
        
        return redirect()->back()->with('success', 'Pegawai berhasil ditambahkan');
    }
    
    public function update(Pegawai $pegawai, Request $request)
    {
        dd($request->all());
        
        $request->validate([
            'nip' => 'required|unique:users,nip'
        ], [
            'nip.required' => 'NIP tidak boleh kosong',
            'nip.unique' => 'NIP telah terdaftar'
        ]);
    }
    
    public function destroy(Pegawai $pegawai)
    {
        $pegawai->user->delete();
        $pegawai->delete();
        
        return redirect()->back()->with('success', 'Data pegawai berhasil dihapus');
    }
}