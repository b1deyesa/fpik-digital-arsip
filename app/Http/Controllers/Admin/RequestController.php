<?php

namespace App\Http\Controllers\Admin;

use App\Models\Field;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\File;

class RequestController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'description' => 'required|max:200'
        ], [
            'user_id.required' => 'Penerima tidak terdaftar',
            'description.required' => 'Pesan tidak boleh kosong',
            'description.max' => 'Pesan terlalu panjang'
        ]);
        
        Field::create([
            'user_id' => $request->user_id,
            'description' => $request->description
        ]);
        
        return redirect()->route('admin.index')->with('success', 'Permintaan file telah terkirim');
    }
    
    public function download(File $file)
    {   
        return response()->download(public_path('storage/'. $file->path), $file->name);
    }
}
