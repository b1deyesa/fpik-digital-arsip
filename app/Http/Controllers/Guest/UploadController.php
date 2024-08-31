<?php

namespace App\Http\Controllers\Guest;

use App\Models\File;
use App\Models\Field;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UploadController extends Controller
{
    public function index()
    {
        $fields = Field::doesntHave('files')->orderBy('id', 'desc')->get();
        
        return view('guest.upload.index', [
            'fields' => $fields
        ]);
    }
}
