<?php

namespace App\Http\Controllers\Admin;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArsipController extends Controller
{
    public function index()
    {
        $pegawais = Pegawai::with('user', 'dataPegawais')
                    ->join('users', 'pegawais.user_id', '=', 'users.id')
                    ->orderBy('users.nip', 'asc')
                    ->select('pegawais.*')
                    ->get()->toArray();
                    
        
        $formattedPegawais = collect($pegawais)->mapWithKeys(function ($pegawai) {
            $name = $pegawai['data_pegawais'][0]['record'] ?? null;
            return [$pegawai['id'] => [
                'nama' => $name,
                'nip'  => $pegawai['user']['nip'],
            ]];
        });
        
        $grouped = $formattedPegawais->groupBy(function ($pegawai) {
            return strtoupper($pegawai['nama'][0]);
        })->sortKeys()->map(function ($group) {
            return $group->sortBy('nama')->toArray();
        })->toArray();
                    
        return view('admin.arsip.index', [
            'pegawais' => $grouped
        ]);
    }
}
