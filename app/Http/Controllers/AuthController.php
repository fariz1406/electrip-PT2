<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\penggunaVerif;


class AuthController extends Controller
{
    function tampil()
    {
        $user = User::get();
        $user_id = Auth::id();
        $dataAda = penggunaVerif::where('user_id', $user_id)->first();

        return view('admin.data_user', compact('user', 'dataAda'));
    }

    function userDetail($id)
    {
        $user_id = Auth::id();

        $data = User::leftJoin('pengguna_profil', 'users.id', '=', 'pengguna_profil.user_id')
        ->leftJoin('pengguna_verifikasi', 'users.id', '=', 'pengguna_verifikasi.user_id')
        ->select(
            'users.*',
            'pengguna_profil.*',
            'pengguna_verifikasi.*'
        )
        ->where('users.id', $id)
        ->first();
    


        return view('admin/user_detail', compact('data'));
    }


    function register()
    {
        return view('register');
    }
    
    function submitRegister(Request $request)
    {
        $user = new User();
        $user->role = 'pengguna';
        $user->name = $request->nama;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('beranda');
    }

    function login() {
        $user_id = Auth::id();

        if ($user_id == ""){
        return view('login');
        } else {
        return view('beranda');
        }
    }
    function submitLogin(Request $request)
    {
        $data = $request->only('email', 'password');
        $user_id = Auth::id();
        $dataAda = penggunaVerif::where('user_id', $user_id)->first();

        if (Auth::attempt($data)) {
            session(['user_id' => Auth::id()]);
            $request->session()->regenerate();

            if (Auth::user()->role == 'admin') {
                return redirect()->route('admin.dashboard', compact('dataAda'));
            }elseif(Auth::user()->role == 'finance') {
                return redirect()->route('finance.dashboard', compact('dataAda'));
            }else {
                return redirect()->route('beranda', compact('dataAda'));
            }
        } else {
            return redirect()->back()->with('gagal', 'Email atau kata sandi anda salah');
        }
    }

    function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }


}
