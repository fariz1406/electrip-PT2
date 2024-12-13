<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Pesanan;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\penggunaVerif;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class pesananController extends Controller
{

    function checkout($id)
    {
        $kendaraan = Kendaraan::find($id);
        $pesanan = Pesanan::find($id);
        $user_id = Auth::id();
        $dataAda = penggunaVerif::where('user_id', $user_id)->first();

        return view('pesanan.checkout', compact('pesanan', 'kendaraan', 'dataAda', 'id'));
    }

    function submit(Request $request, $id)
    {
        $kendaraan = Kendaraan::find($id);
        $kendaraan_id = $kendaraan->id;
        $harga_kendaraan_perhari = $kendaraan->harga;
        $pesanan = new Pesanan();

        $pesanan->kendaraan_id = $kendaraan_id;
        $pesanan->user_id = Auth::id();
        $pesanan->pesan = $request->pesan;
        $pesanan->tanggal_mulai = $request->tanggal_mulai;
        $pesanan->tanggal_selesai = $request->tanggal_selesai;
        $pesanan->lokasi = $request->lokasi;
        $pesanan->latitude = $request->latitude;
        $pesanan->longitude = $request->longitude;

        $tanggal_mulai = Carbon::parse($request->tanggal_mulai);
        $tanggal_selesai = Carbon::parse($request->tanggal_selesai);
        // Hitung jumlah hari, minimal 1 hari
        $jumlah_hari = $tanggal_mulai->diffInDays($tanggal_selesai);

        $pesanan->biaya = $jumlah_hari * $harga_kendaraan_perhari;
        $pesanan->save();

        return redirect()->route('pesanan.belumDibayar');
    }

    function tampil()
    {
        $user_id = Auth::id();
        $dataAda = penggunaVerif::where('user_id', $user_id)->first();

        $dataPesanan = DB::table('pesanan')
            ->join('users', 'pesanan.user_id', '=', 'users.id') // Gabungkan tabel users
            ->join('kendaraan', 'pesanan.kendaraan_id', '=', 'kendaraan.id') // Gabungkan tabel kendaraan
            ->select(
                'pesanan.id',
                'users.name',
                'kendaraan.nama',
                'pesanan.biaya',
                'pesanan.status',
                'pesanan.tanggal_mulai',
                'pesanan.tanggal_selesai'
            )
            ->get();
        return view('admin/pesanan/tampil', compact('dataPesanan', 'dataAda'));
    }

    public function updateStatus(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        // Validasi status yang dikirimkan
        $validated = $request->validate([
            'status' => 'required|in:belum_dibayar,diproses,dikirim,dipakai,selesai',
        ]);

        // Update status pesanan
        $pesanan->status = $request->status;
        $pesanan->save();

        return redirect()->route('pesanan.data')->with('success', 'Status pesanan berhasil diubah');
    }


    function belumDibayar(Request $request)
    {
        $status = 'belum_dibayar';

        // Ambil ID pengguna dari session
        $user = Auth::user();
        $user_id = Auth::id();
        $dataAda = penggunaVerif::where('user_id', $user_id)->first();

        $user = Auth::user();
        $verifikasi = PenggunaVerif::where('user_id', $user->id)->first();


        // Ambil data pesanan yang belum dibayar
        $dataPesanan = Pesanan::where('user_id', $user->id)
            ->where('status', 'belum_dibayar')
            ->with('kendaraan')
            ->get();

        return view('pesanan/belum_dibayar', compact('status', 'dataPesanan', 'dataAda', 'verifikasi'));
    }

    function diProses(Request $request)
    {
        $status = 'diproses';
        // Ambil ID pengguna dari session
        $user = Auth::user();
        $user_id = Auth::id();
        $dataAda = penggunaVerif::where('user_id', $user_id)->first();

        $user = Auth::user();
        $verifikasi = PenggunaVerif::where('user_id', $user->id)->first();


        // Ambil data pesanan yang belum dibayar
        $dataPesanan = Pesanan::where('user_id', $user->id)
            ->where('status', 'diproses')
            ->with('kendaraan')
            ->get();

        return view('pesanan/diproses', compact('status', 'dataPesanan', 'dataAda', 'verifikasi'));
    }

    function diKirim(Request $request)
    {
        $status = 'dikirim';
        // Ambil ID pengguna dari session
        $user = Auth::user();
        $user_id = Auth::id();
        $dataAda = penggunaVerif::where('user_id', $user_id)->first();

        $user = Auth::user();
        $verifikasi = PenggunaVerif::where('user_id', $user->id)->first();


        // Ambil data pesanan yang belum dibayar
        $dataPesanan = Pesanan::where('user_id', $user->id)
            ->where('status', 'dikirim')
            ->with('kendaraan')
            ->get();

        return view('pesanan/dikirim', compact('status', 'dataPesanan', 'dataAda', 'verifikasi'));
    }

    function diPakai(Request $request)
    {
        $status = 'dipakai';
        // Ambil ID pengguna dari session
        $user = Auth::user();
        $user_id = Auth::id();
        $dataAda = penggunaVerif::where('user_id', $user_id)->first();

        $user = Auth::user();
        $verifikasi = PenggunaVerif::where('user_id', $user->id)->first();


        // Ambil data pesanan yang belum dibayar
        $dataPesanan = Pesanan::where('user_id', $user->id)
            ->where('status', 'dipakai')
            ->with('kendaraan')
            ->get();

        return view('pesanan/dipakai', compact('status', 'dataPesanan', 'dataAda', 'verifikasi'));
    }

    public function tambahDurasi(Request $request, $id)
    {
        $request->validate([
            'tanggal_selesai' => 'required|date|after:now', // Validasi datetime harus setelah saat ini
        ]);

        $pesanan = Pesanan::findOrFail($id);

        // Pastikan tanggal baru lebih besar dari tanggal sebelumnya (tanggal_selesai)
        if ($request->tanggal_selesai <= $pesanan->tanggal_selesai) {
            return redirect()->back()->withErrors(['datetime' => 'Tanggal baru harus lebih besar dari tanggal sebelumnya.']);
        }

        $pesanan->tanggal_selesai = $request->tanggal_selesai; // Update tanggal selesai
        $pesanan->save();

        return redirect()->back()->with('success', 'Durasi berhasil diperbarui.');
    }


    function riwayat(Request $request)
    {
        $status = 'riwayat';
        // Ambil ID pengguna dari session
        $user = Auth::user();
        $user_id = Auth::id();
        $dataAda = penggunaVerif::where('user_id', $user_id)->first();

        $user = Auth::user();
        $verifikasi = PenggunaVerif::where('user_id', $user->id)->first();


        $dataPesanan = Pesanan::where('user_id', $user->id)
            ->where('status', 'riwayat')
            ->with('kendaraan')
            ->get();

        return view('pesanan/riwayat_pesanan', compact('status', 'dataPesanan', 'dataAda', 'verifikasi'));
    }
}
