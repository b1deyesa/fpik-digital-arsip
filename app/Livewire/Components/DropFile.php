<?php

namespace App\Livewire\Components;

use App\Models\File;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class DropFile extends Component
{
    use WithFileUploads;
    
    public $id;
    public $name;
    public $field;
    public $file;
    public $data;
    
    public function updatedFile()
    {   
        $this->validate([
            'file' => 'max:30000'
        ], [
            'file.max' => 'Ukuran file terlalu besar ('. number_format($this->file->getSize() / (1024 * 1024), 2) .' MB)'
        ]);
        
        $this->data = [
            'name' => pathinfo($this->file->getClientOriginalName(), PATHINFO_FILENAME),
            'extension' => '.'.pathinfo($this->file->getClientOriginalName(), PATHINFO_EXTENSION)
        ];
    }

    public function cancel()
    {
        $this->data = false;
    }
    
    public function save()
    {
        $this->validate([
            'data.name' => 'required' 
        ], [
            'data.name.required' => 'Nama file tidak boleh kosong'
        ]);
        
        $path = date('Ymd') . str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT) . $this->data['extension'];
        $this->file->storeAs('public', $path);
        
        File::create([
            'user_id' => Auth::id(),
            'field_id' => $this->field,
            'name' => $this->data['name'] . $this->data['extension'],
            'path' => $path,
            'isHide'=> false
        ]);
        
        return redirect()->route('guest.upload.index')->with('success', 'File berhasil diunggah');
    }
    
    public function render()
    {
        return view('livewire.components.drop-file', [
            'id' => $this->id,
            'name' => $this->name,
            'field' => $this->field
        ]);
    }
}
