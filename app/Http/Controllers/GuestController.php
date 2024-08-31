<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index()
    {
        return view('guest.index', [
            'number_required' => Field::doesntHave('files')->count()
        ]);
    }
}
