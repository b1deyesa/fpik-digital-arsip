<?php

namespace App\Http\Controllers\Guest;

use ZipArchive;
use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function index(Request $request)
    {
        $query = File::where('user_id', Auth::id())->where('isHide', false);

        if ($request->order == 1) {
            $query->orderBy('id', 'asc');
        } elseif ($request->order == 2) {
            $query->orderBy('name', 'asc');
        } elseif ($request->order == 3) {
            $query->orderBy('name', 'desc');
        } else {
            $query->orderBy('id', 'desc');
        }

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        return view('guest.download.index', [
            'files' => $query->get(),
            'trash' => File::where('user_id', Auth::id())->where('isHide', true)->count()
        ]);
    }
    
    public function trash()
    {
        if (Auth::user()->files->where('isHide', true)->whereNotNull('name')->count() == 0) {
            return redirect()->route('guest.download.index');
        }
        
        return view('guest.download.trash', [
            'files' => File::where('user_id', Auth::id())->where('isHide', true)->orderBy('id', 'desc')->get()
        ]);
    }
    
    public function restore(Request $request)
    {
        $file = File::find($request->file);
        
        $file->update([
            'isHide' => false
        ]);
        
        return redirect()->route('guest.download.trash')->with('success',  'File berhasil dikembalikan');
    }
    
    public function destroy(File $file)
    {
        $file->delete();
        
        return redirect()->route('guest.download.trash')->with('success', 'File berhasil di hapus permanen');
    }
    
    public function preview(File $file)
    {
        return view('guest.download.preview', [
            'file' => $file
        ]);
    }
    
    public function rename(Request $request)
    {
        $file = File::find($request->file);

        if (!is_null($request->name)) {
            $file->update([
                'name' => $request->name . '.' . pathinfo($file->path, PATHINFO_EXTENSION)
            ]);

            return redirect()->back()->with('success', 'Nama file berhasil diubah');
        }
        
        return redirect()->back()->with('error', 'Nama file tidak boleh kosong');
    }
    
    public function delete(Request $request)
    {
        $file = File::find($request->file);
        
        $file->update([
            'isHide' => true
        ]);
        
        return redirect()->route('guest.download.index')->with('success', 'File dipindahkan ke tong sampah');
    }
    
    public function deletes(Request $request)
    {
        $request->validate([
            'select-file' => 'required'
        ], [
            'select-file.required' => 'Pilih file terlebih dahulu'
        ]);
        
        $files = $request->input('select-file', []);
        foreach ($files as $key => $value) {
            File::find($key)->update([
                'isHide' => true
            ]);
        }

        return redirect()->route('guest.download.index')->with('success', 'File yang diplih telah ke tong sampah');
    }
    
    public function download(Request $request)
    {
        $file = File::find($request->file);

        return response()->download(public_path('storage/'. $file->path), $file->name);
    }
    
    public function downloads(Request $request)
    {
        $request->validate([
            'select-file' => 'required'
        ], [
            'select-file.required' => 'Pilih file terlebih dahulu'
        ]);
        
        $files = $request->input('select-file', []);
        $zipFileName = 'fpik-digital-arsip.zip';
        $zipFilePath = storage_path('app/' . $zipFileName);
        $zip = new ZipArchive;

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
            foreach ($files as $key => $value) {
                $file = File::find($key);
                $zip->addFile(Storage::path('public/'. $file->path), $file->name);
            }
            $zip->close();
        }

        return response()->download($zipFilePath)->deleteFileAfterSend(true);

    }
}