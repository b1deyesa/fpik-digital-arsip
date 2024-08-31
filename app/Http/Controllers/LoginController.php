<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('index');
    }
    
    public function post(Request $request)
    {
        $request->validate([
            'nip' => 'required',
            'password' => 'required'
        ]);
        
        if (Auth::attempt(['nip' => $request->nip, 'password' => $request->password])) {
            $request->session()->regenerate();
            if (Auth::user()->role->name == 'admin') {
                return redirect()->intended(route('admin.index'));
            } elseif (Auth::user()->role->name == 'guest') {
                return redirect()->intended(route('guest.index'));
            }
            
            return redirect()->back()->with('error', 'Tidak memiliki hak akses');
        }

        return redirect()->back()->with('error', 'NIP atau Password Salah');
    }
    
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil logout');
    }
}
