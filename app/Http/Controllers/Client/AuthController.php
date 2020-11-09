<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;
use Session;

class AuthController extends Controller
{
    public function showFormLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function showFormRegister()
    {
        return view('register');
    }

    public function login(Request $req)
    {
        $this->validate($req, [
            'email'                 => 'required|email',
            'password'              => 'required|string'
        ], [
            'email.required'        => 'Email wajib diisi',
            'email.email'           => 'Email tidak valid',
            'password.required'     => 'Password wajib diisi',
            'password.string'       => 'Password harus berupa string'
        ]);

        Auth::attempt(['email' => $req->email, 'password' => $req->password]);

        if (Auth::check()) {
            return redirect()->route('dashboard');
        } else {
            $req->session()->flash('error', 'Email atau Password tidak valid');
            return redirect()->route('login');
        }
    }

    public function register(Request $req)
    {
        $this->validate($req, [
            'name'                  => 'required|min:3|max:35',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|confirmed'
        ], [
            'name.required'         => 'Nama Lengkap wajib diisi',
            'name.min'              => 'Nama lengkap minimal 3 karakter',
            'name.max'              => 'Nama lengkap maksimal 35 karakter',
            'email.required'        => 'Email wajib diisi',
            'email.email'           => 'Email tidak valid',
            'email.unique'          => 'Email sudah terdaftar',
            'password.required'     => 'Password wajib diisi',
            'password.confirmed'    => 'Password tidak sama dengan konfirmasi password'
        ]);

        $user = User::create([
            'name' => ucwords(strtolower($req->name)),
            'email' => strtolower($req->email),
            'password' => bcrypt($req->password),
            'email_verified_at' => \Carbon\Carbon::now()
        ]);

        if ($user) {
            Session::flash('success', 'Register berhasil! Silahkan login untuk mengakses data');
            return redirect()->route('login');
        } else {
            Session::flash('errors', ['' => 'Register gagal! Silahkan ulangi beberapa saat lagi']);
            return redirect()->route('register');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
