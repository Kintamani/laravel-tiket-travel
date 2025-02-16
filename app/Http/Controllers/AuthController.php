<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Show layout login
     *
     * @return \Illuminate\Http\Response
     */
    function login()
    {
        return view('auth.index');
    }

    /**
     * Melakukan input data login
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Request  $req
     * @return \Illuminate\Http\Response
     */
    function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = User::where('email', $request->email)->first();
            session([
                'name' => $user->name,
                'email' => $user->email
            ]);
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Data email yang Anda masukkan salah, silakan periksa kembali',
            'password' => 'Data password yang Anda masukkan salah, silakan periksa kembali'
        ])->onlyInput('email');
    }

    /**
     * @param $provider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
