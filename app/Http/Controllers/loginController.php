<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class loginController extends Controller    
{
    //
    public function index()
    {
        return view('login');
    }

    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function login(Request $request)
    {

        $user = User::where('email', $request->email)->first();

        // Check if user exists
        if (!$user) {
            return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors([
                'email' => 'Email not found',
            ]);
        }
        // Check password
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors([
                'password' => 'Wrong password',
            ]);
        }

            // Attempt to log the user in
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->filled('remember'))) {
            // If successful, then redirect to their intended location
            if ($request->filled('remember')) {
                // If user wants to be remembered, create a cookie
                Cookie::queue('remember_user', encrypt(Auth::id()), 43200); // 30 days
            }
            return redirect()->intended(route('dashboard'));
        }

        // If unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function logout()
    {
        Auth::logout();

        // Forget the cookie
        Cookie::queue(Cookie::forget('remember_user'));

        return redirect('/');
    }
}