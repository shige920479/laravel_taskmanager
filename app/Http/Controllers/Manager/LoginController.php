<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('manager.login');
    }
    
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if(Auth::guard('manager')->attempt($validated)) {
            $request->session()->regenerate();
            return to_route('manager.dashboard');
        
        } else {
            return redirect()->route('manager.index')
            ->withErrors(['password' => 'メールアドレスかパスワードが違っています'])
            ->onlyInput('email');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('manager')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('manager.index');
    }

}
