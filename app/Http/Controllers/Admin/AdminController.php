<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function loginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        
        if(Auth::guard('admin')->attempt($validated)) {
            $request->session()->regenerate();
            return redirect()->intended(RouteServiceProvider::ADMIN_HOME);
        } else {
            return redirect()->route('admin.loginForm')
            ->withErrors(['password' => 'メールアドレスかパスワードが違っています'])
            ->onlyInput('email');
        }
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function migrate()
    {
        try {
            Artisan::call('migrate:fresh --seed');
            return response()->json(['message' => 'データベースがリフレッシュされました']);

        } catch(\Exception $e) {
            return response()->json(['message' => 'データベースの更新に失敗しました', 'error' => $e->getMessage()], 500);
        }

    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('admin.loginForm');

    }
}
