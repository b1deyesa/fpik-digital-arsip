<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Data;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required',
        ], [
            'label.required' => 'Nama kolom tidak boleh kosong',
        ]);
        
        Data::create([
            'label' => $request->label,
        ]);
        
        return redirect()->back()->with('succees', 'Kolom berhasil dibuat');
    }
    
    public function destroy(Data $data, Request $request)
    {
        $data->delete();
        
        return redirect()->back()->with('success', 'Kolom berhasil dihapus');
    }
}
