<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\penggunaVerif;
use App\Models\Profil;

class VerifikasiUser extends Controller
{

    public function beranda()
    {
        $user_id = Auth::id();
        $dataAda = penggunaVerif::where('user_id', $user_id)->first();
        $profil = Profil::where('user_id', $user_id)->first();


        if (!session()->has('first_login_done')) {
            session(['first_login_done' => true]);
            return view('beranda', compact('dataAda', 'profil', 'user_id'))->with('isFirstLogin', true);
        }
        if ($user_id == ""){

        return view('beranda');

        }else {

        return view('beranda', compact('dataAda', 'profil', 'user_id'))->with('isFirstLogin', false);

        }
    }

    public function index()
    {
        // Mengambil pengguna saat ini  
        $user_id = Auth::id();
        $dataAda = penggunaVerif::where('user_id', $user_id)->first();

        $user = Auth::user();
        $verifikasi = PenggunaVerif::where('user_id', $user->id)->first();
        $profil = Profil::where('user_id', $user_id)->first();


        if ($dataAda) {
            return view('verifikasi.verifikasi-sudah', compact('dataAda','verifikasi', 'profil'));
        } else {
            return view('verifikasi.verifikasi', compact('dataAda','verifikasi', 'profil'));
        }

        return view('verifikasi.verifikasi', compact('dataAda', 'verifikasi', 'profil'));
    }

    public function edit($id)
    {
        // Mengambil pengguna saat ini  
        $user_id = Auth::id();
        $dataAda = penggunaVerif::where('user_id', $user_id)->first();

        $user = Auth::user();
        $verifikasi = PenggunaVerif::where('user_id', $user->id)->first();
        $profil = Profil::where('user_id', $user_id)->first();

        return view('verifikasi.verifikasi-update', compact('dataAda', 'verifikasi', 'profil', 'user_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'kelamin' => 'required|string',
            'foto_ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto_sim' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user_id = Auth::id();
        $dataAda = penggunaVerif::where('user_id', $user_id)->first();

        if ($dataAda) {
            return redirect()->back()->with('error', 'Akun Anda Sudah Pernah Verifikasi Sebelumnya.');
        }

        // Proses penyimpanan foto  
        $fotoKTP = $request->file('foto_ktp');
        $fotoSIM = $request->file('foto_sim');


        $fotoKTPName = time() . '_ktp_' . $fotoKTP->getClientOriginalName();
        $fotoSIMName = time() . '_sim_' . $fotoSIM->getClientOriginalName();

        $fotoKTP->move(public_path('img/ktp'), $fotoKTPName);
        $fotoSIM->move(public_path('img/sim'), $fotoSIMName);

        // Simpan data pengguna verifikasi  
        penggunaVerif::create([
            'user_id' => $user_id,
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'kelamin' => $request->kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'foto_ktp' => 'img/ktp/' .$fotoKTPName,
            'foto_sim' => 'img/sim/' .$fotoSIMName,
        ]);

        return redirect()->route('beranda')->with('success', 'Data Anda Berhasil Disimpan.');
    }

    function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|numeric|digits:16',
            'kelamin' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Foto opsional
            'foto_sim' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Foto opsional
        ]);
    
        // Cari data pengguna verifikasi
        $penggunaVerif = penggunaVerif::findOrFail($id);
    
        // Proses foto KTP jika diunggah
        if ($request->hasFile('foto_ktp')) {
            $fotoKTP = $request->file('foto_ktp');
            $fotoKTPName = time() . '_ktp_' . $fotoKTP->getClientOriginalName();
            $fotoKTP->move(public_path('img/ktp'), $fotoKTPName);
            $penggunaVerif->foto_ktp = 'img/ktp/' . $fotoKTPName;
        }
    
        // Proses foto SIM jika diunggah
        if ($request->hasFile('foto_sim')) {
            $fotoSIM = $request->file('foto_sim');
            $fotoSIMName = time() . '_sim_' . $fotoSIM->getClientOriginalName();
            $fotoSIM->move(public_path('img/sim'), $fotoSIMName);
            $penggunaVerif->foto_sim = 'img/sim/' . $fotoSIMName;
        }
    
        // Simpan data lainnya
        $penggunaVerif->nama_lengkap = $request->nama_lengkap;
        $penggunaVerif->nik = $request->nik;
        $penggunaVerif->kelamin = $request->kelamin;
        $penggunaVerif->tanggal_lahir = $request->tanggal_lahir;
        $penggunaVerif->alamat = $request->alamat;
        $penggunaVerif->validasi = 'belum';
        $penggunaVerif->save();
    
        return redirect()->route('beranda')->with('success', 'Data Anda Berhasil Disimpan.');
    }
}    