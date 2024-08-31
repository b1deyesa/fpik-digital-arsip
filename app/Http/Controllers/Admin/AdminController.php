<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Field;
use App\Models\DataPegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function index()
    {   
        return view('admin.index', [
            'users' => DataPegawai::where('data_id', 1)
                        ->join('pegawais', 'data_pegawais.pegawai_id', '=', 'pegawais.id')
                        ->join('users', 'pegawais.user_id', '=', 'users.id')
                        ->get(['users.id as user_id', 'users.nip', 'data_pegawais.record'])
                        ->mapWithKeys(function ($item) {
                            return [$item->user_id =>  $item->nip .' - '. $item->record];
                        })->toArray(),
            'fields' => Field::orderBy('id', 'desc')->get()
        ]);
    }
}