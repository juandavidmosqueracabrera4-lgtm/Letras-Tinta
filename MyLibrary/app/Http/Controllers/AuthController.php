<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('books.index');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('books.index'));
        }

        return back()->withErrors([
            'email' => 'The credentials entered do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Invalida la sesión actual y regenera el token CSRF (Exigido en rúbrica)
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Sesión cerrada correctamente.');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([            
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'document' => 'required|string|max:20|unique:users,document',
            'password' => 'required|string|min:6|confirmed',
            ]);

            // Asigna automáticamente el rol 'lector' al registrarse desde afuera
        $readerRole = Role::firstOrCreate(
            ['name' => 'lector'],
            ['description' => 'Consulta de catálogo']
        );

        $user = User::create([
            'name'              => $request->name,
            'email'             => $request->email,
            'document'          => $request->document,
            'role_id'           => $readerRole->id,
            'password'          => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('books.index');
    }
}
