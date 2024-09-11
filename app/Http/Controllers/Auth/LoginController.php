<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home'; // Ini bisa diatur ke default route setelah login

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $user = Auth::user();

            if ($user->type == 'user') {
                return redirect()->route('presence.index'); // Ganti 'presence.index' sesuai dengan nama rute yang sesuai
            } elseif ($user->type == 'admin') {
                return redirect()->route('admin.summary'); // Ganti 'admin.index' sesuai dengan nama rute yang sesuai
            } else {
                // Handle other types if necessary
                return redirect()->route('welcome'); // Default redirect jika tidak ada tipe yang cocok
            }
        }

        return redirect()->route('login')->with('error', 'Email-Address And Password Are Wrong.');
    }
}
