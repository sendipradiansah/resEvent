<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function registerForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name'      => 'required|string|max:255',
            'username'  => 'required|string|max:50|unique:users,username',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|string|min:6|confirmed'
        ], [
            'name.required'         => 'Nama wajib diisi.',
            'name.string'           => 'Nama harus berupa teks.',
            'name.max'              => 'Nama tidak boleh lebih dari 255 karakter.',
            'username.required'     => 'Username wajib diisi.',
            'username.unique'       => 'Username sudah digunakan.',
            'username.string'       => 'Nama harus berupa teks.',
            'username.max'          => 'Nama tidak boleh lebih dari 50 karakter.',
            'email.required'        => 'Email wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'email.unique'          => 'Email sudah digunakan.',
            'name.required'         => 'Nama wajib diisi.',
            'password.required'     => 'Password wajib diisi.',
            'password.string'       => 'Password harus berupa teks.',
            'password.min'          => 'Password minimal 6 karakter.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name'      => $request->name,
            'username'  => $request->username,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => 'user'
        ]);

        return redirect()->route('login.form')->with('success', 'Selamat, Anda berhasil registrasi!');
    }

    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validate = $request->validate([
            'username'  => 'required',
            'password'  => 'required|string'
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.string' => 'Password harus berupa teks.',
        ]);

        if (Auth::attempt($validate)) {
            $request->session()->regenerate();

            if (Auth::user()->role == 'admin') {
                return redirect()->intended(route('admin.event.index'));
            }

            return redirect()->intended(route('event.index'));
        }

        return back()->withErrors([
            'message'  => 'Nama pengguna atau kata sandi tidak valid.'
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
