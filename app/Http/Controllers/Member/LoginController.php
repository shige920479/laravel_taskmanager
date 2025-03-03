<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMemberRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('index');
    }
    
    public function create()
    {
        return view('members.createAccount');
    }

    public function store(StoreMemberRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return to_route('index')->with('success', '新規アカンウトを登録しました');

    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if(Auth::guard('users')->attempt($validated)) {
            $request->session()->regenerate();
            return redirect()->intended('/members/dashboard');

        } else {
            return redirect()->route('index')
            ->withErrors([
                'password' => 'メールアドレスあるいはパスワードが正しくありません',
            ])->onlyInput('email');
        }

    }

    public function logout(Request $request)
    {
        Auth::guard('users')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('index');
    }


}
