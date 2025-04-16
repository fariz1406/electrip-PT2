<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\penggunaVerif;
use App\Models\Profil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class KendaraanController extends Controller
{

    function tampil()
    {
        $kendaraan = Kendaraan::get();

        $user_id = Auth::id();
        $dataAda = penggunaVerif::where('user_id', $user_id)->first();

        return view('admin.kendaraan.tampil', compact('kendaraan', 'dataAda'));
    }

    function pilihan(Request $request)
    {
        $user_id = Auth::id();
        $dataAda = penggunaVerif::where('user_id', $user_id)->first();
        $profil = Profil::where('user_id', $user_id)->first();

        if ($request->get('search')) {
            $kendaraan = Kendaraan::where('kategori_id', '1')->where('status', 'tersedia')->where('nama', 'like', '%' . $request->get('search') . '%')->get();
        }else{
            $kendaraan = Kendaraan::where('kategori_id', '1')->where('status', 'tersedia')->get();
        }

        return view('pilihanMobil', compact('kendaraan', 'request', 'dataAda', 'profil'));
    }

    function pilihanMotor(Request $request)
    {
        $user_id = Auth::id();
        $dataAda = penggunaVerif::where('user_id', $user_id)->first();
        $profil = Profil::where('user_id', $user_id)->first();

        if ($request->get('search')) {
            $kendaraan = Kendaraan::where('kategori_id', '2')->where('status', 'tersedia')->where('nama', 'like', '%' . $request->get('search') . '%')->get();
        }else{
            $kendaraan = Kendaraan::where('kategori_id', '2')->where('status', 'tersedia')->get();
        }

        return view('pilihanMotor', compact('kendaraan', 'request', 'dataAda', 'profil'));
    }

    public function detail($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);
        return response()->json($kendaraan);
    }


    function tambah()
    {
        $kendaraan = Kendaraan::get();
        $user_id = Auth::id();
        $dataAda = penggunaVerif::where('user_id', $user_id)->first();

        return view('admin.kendaraan.tambah', compact('dataAda', 'kendaraan'));
    }

    function tambahin()
    {
        $user_id = Auth::id();

        return view('admin/kendaraan/tambahin');
    }

    function submit(Request $request)
    {

        $request->validate([
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'stnk' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Proses gambar jika diunggah
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoName = time() . '.' . $foto->getClientOriginalExtension();
            $foto->move(public_path('img/kendaraan'), $fotoName);
        } else {
            $fotoName = null;
        }

        if ($request->hasFile('stnk')) {
            $stnk = $request->file('stnk');
            $stnkName = time() . '.' . $stnk->getClientOriginalExtension();
            $stnk->move(public_path('img/stnk'), $stnkName);
        } else {
            $stnkName = null;
        }

        $kendaraan = new Kendaraan();
        $kendaraan->kategori_id = $request->kategori_id;
        $kendaraan->nama = $request->nama;
        $kendaraan->foto = $fotoName;
        $kendaraan->deskripsi = $request->deskripsi;
        $kendaraan->harga = $request->harga;
        $kendaraan->stnk = $stnkName;
        $kendaraan->tahun = $request->tahun;
        $kendaraan->save();

        return redirect()->route('kendaraan.tampil');
    }

    function edit($id)
    {
        $kendaraan = Kendaraan::find($id);
        $user_id = Auth::id();
        $dataAda = penggunaVerif::where('user_id', $user_id)->first();
        return view('admin.kendaraan.edit', compact('kendaraan', 'dataAda'));
    }

    function update(Request $request, $id)
    {
        $kendaraan = Kendaraan::find($id);

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');

            $newFileName = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('img/kendaraan'), $newFileName);

            // Update path foto di database
            $kendaraan->foto = $newFileName;
        }

        if ($request->hasFile('stnk')) {
            $stnk = $request->file('stnk');

            $newStnkName = time() . '_' . $stnk->getClientOriginalName();
            $stnk->move(public_path('img/kendaraan'), $newStnkName);

            $kendaraan->stnk = $newStnkName;
        }

        $kendaraan->nama = $request->nama;
        $kendaraan->deskripsi = $request->deskripsi;
        $kendaraan->harga = $request->harga;
        $kendaraan->tahun = $request->tahun;
        $kendaraan->update();

        return redirect()->route('kendaraan.tampil');
    }

    function delete($id)
    {
        $kendaraan = Kendaraan::find($id);
        $kendaraan->delete();
        return redirect()->route('kendaraan.tampil');
    }
}
