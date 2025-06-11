<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Pesanan;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\penggunaVerif;
use App\Models\Profil;
use App\Services\MidtransService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Carbon\CarbonPeriod;

class pesananController extends Controller
{

    function checkout($id)
    {
        $kendaraan = Kendaraan::find($id);
        $pesanan = Pesanan::find($id);
        $user_id = Auth::id();
        $dataAda = penggunaVerif::where('user_id', $user_id)->first();
        $profil = Profil::where('user_id', $user_id)->first();


        return view('pesanan.checkout', compact('pesanan', 'kendaraan', 'dataAda', 'id', 'profil'));
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
        $pesanan->waktu_jam = $request->waktu_jam;
        $pesanan->lokasi = $request->lokasi;
        $pesanan->detail_lokasi = $request->detail_lokasi;
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

    function detail($id)
    {
        $user_id = Auth::id();
        $dataAda = penggunaVerif::where('user_id', $user_id)->first();

        $pesanan = Pesanan::join('kendaraan', 'kendaraan.id', '=', 'pesanan.kendaraan_id')
            ->join('users', 'users.id', '=', 'pesanan.user_id')
            ->select(
                'pesanan.*',
                'kendaraan.nama as kendaraan_nama',
                'kendaraan.foto as kendaraan_foto',
                'users.name as user_name',
                'users.email as user_email'
            )
            ->where('pesanan.id', $id) // Filter berdasarkan ID dari URL
            ->first();


        return view('admin/pesanan/detail', compact('pesanan', 'dataAda'));
    }

    function penggunaDetail($id)
    {
        $user_id = Auth::id();
        $dataAda = penggunaVerif::where('user_id', $user_id)->first();
        $verifikasi = PenggunaVerif::where('user_id', $user_id)->first();
        $profil = Profil::where('user_id', $user_id)->first();

        $pesanan = Pesanan::join('kendaraan', 'kendaraan.id', '=', 'pesanan.kendaraan_id')
            ->join('users', 'users.id', '=', 'pesanan.user_id')
            ->select(
                'pesanan.*',
                'kendaraan.nama as kendaraan_nama',
                'kendaraan.foto as kendaraan_foto',
                'users.name as user_name',
                'users.email as user_email'
            )
            ->where('pesanan.id', $id) // Filter berdasarkan ID dari URL
            ->first();


        return view('pesanan/detail', compact('verifikasi', 'pesanan', 'dataAda', 'profil'));
    }

    public function updateStatus(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:belum_dibayar,diproses,dikirim,dipakai,selesai',
        ]);

        if ($request->status === 'dikirim') {
            $kendaraan = DB::table('kendaraan')
                ->where('id', $pesanan->kendaraan_id)
                ->first();

            if ($kendaraan) {

                DB::table('kendaraan')
                    ->where('id', $kendaraan->id)
                    ->update(['status' => 'dipakai']);
            }
        }

        if ($request->status === 'selesai') {
            $kendaraan = DB::table('kendaraan')
                ->where('id', $pesanan->kendaraan_id)
                ->first();

            if ($kendaraan) {

                DB::table('kendaraan')
                    ->where('id', $kendaraan->id)
                    ->update(['status' => 'tersedia']);
            }
        }


        // Update status pesanan
        $pesanan->status = $request->status;
        $pesanan->save();

        return redirect()->route('pesanan.data')->with('success', 'Status pesanan berhasil diubah');
    }

    /**
     * @throws \Exception
     */
    function belumDibayar(Request $request)
    {
        $status = 'belum_dibayar';

        // Ambil ID pengguna dari session
        $user = Auth::user();
        $user_id = Auth::id();
        $dataAda = penggunaVerif::where('user_id', $user_id)->first();

        $verifikasi = PenggunaVerif::where('user_id', $user->id)->first();
        $profil = Profil::where('user_id', $user->id)->first();

        $dataPesanan = Pesanan::where('user_id', $user->id)
            ->where('status', 'belum_dibayar')
            ->with('kendaraan')
            ->get();

        return view('pesanan/belum_dibayar', compact('status', 'dataPesanan', 'dataAda', 'verifikasi', 'profil'));
    }

    public function order(MidtransService $midtransService, Request $request)
    {
        // Ambil ID pengguna dari session
        $user = Auth::user();
        $user_id = Auth::id();
        $verifikasi = PenggunaVerif::where('user_id', $user->id)->first();
        $profil = Profil::where('user_id', $user->id)->first();
        $dataAda = penggunaVerif::where('user_id', $user_id)->first();

        $order = Pesanan::join('kendaraan', 'kendaraan.id', '=', 'pesanan.kendaraan_id')
            ->join('users', 'users.id', '=', 'pesanan.user_id')
            ->select(
                'pesanan.*',
                'kendaraan.nama as kendaraan_nama',
                'kendaraan.foto as kendaraan_foto',
                'users.name as user_name',
                'users.email as user_email'
            )
            ->where('pesanan.id', $request->route('id'))->first();

        $payment = $order->payments()->latest()->first();

        if ($payment == null || $payment->status === 'EXPIRED') {
            // Buat Snap Token baru jika belum ada atau sudah expired di DB
            $snapToken = $midtransService->createSnapToken($order);

            $order->payments()->create([
                'pesanan_id' => $order->id,
                'snap_token' => $snapToken,
                'status' => 'PENDING',
            ]);
        } else {
            // Cek status transaksi langsung ke Midtrans
            $midtransStatus = $midtransService->checkTransactionStatus($order->id);

            if (!is_object($midtransStatus) || $midtransStatus->transaction_status === 'expire') {

                // Kalau status expired, buat Snap Token baru
                $snapToken = $midtransService->createSnapToken($order);

                $order->payments()->create([
                    'pesanan_id' => $order->id,
                    'snap_token' => $snapToken,
                    'status' => 'PENDING',
                ]);
            } else {
                // Transaksi masih aktif, gunakan Snap Token lama
                $snapToken = $payment->snap_token;
            }
        }

        return view('pesanan.order', compact('order', 'snapToken', 'verifikasi', 'dataAda', 'profil'));
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
        $profil = Profil::where('user_id', $user->id)->first();


        // Ambil data pesanan yang belum dibayar
        $dataPesanan = Pesanan::where('user_id', $user->id)
            ->where('status', 'diproses')
            ->with('kendaraan')
            ->get();

        return view('pesanan/diproses', compact('status', 'dataPesanan', 'dataAda', 'verifikasi', 'profil'));
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
        $profil = Profil::where('user_id', $user->id)->first();


        // Ambil data pesanan yang belum dibayar
        $dataPesanan = Pesanan::where('user_id', $user->id)
            ->where('status', 'dikirim')
            ->with('kendaraan')
            ->get();

        return view('pesanan/dikirim', compact('status', 'dataPesanan', 'dataAda', 'verifikasi', 'profil'));
    }

    function map($id)
    {
        $user_id = Auth::id();
        $dataAda = penggunaVerif::where('user_id', $user_id)->first();
        $profil = Profil::where('user_id', $user_id)->first();

        $pesanan = Pesanan::join('kendaraan', 'kendaraan.id', '=', 'pesanan.kendaraan_id')
            ->join('users', 'users.id', '=', 'pesanan.user_id')
            ->select(
                'pesanan.*',
                'kendaraan.nama as kendaraan_nama',
                'kendaraan.foto as kendaraan_foto',
                'users.name as user_name',
                'users.email as user_email'
            )
            ->where('pesanan.id', $id) // Filter berdasarkan ID dari URL
            ->first();


        return view('pesanan/map', compact('pesanan', 'dataAda', 'profil'));
    }

    function diPakai(Request $request)
    {
        $status = 'dipakai';
        $user = Auth::user();
        $user_id = $user->id;

        $dataAda = penggunaVerif::where('user_id', $user_id)->first();
        $verifikasi = PenggunaVerif::where('user_id', $user_id)->first();
        $profil = Profil::where('user_id', $user_id)->first();

        // Ambil data pesanan milik user yang sedang dipakai
        $dataPesanan = Pesanan::where('user_id', $user_id)
            ->where('status', 'dipakai')
            ->with('kendaraan')
            ->get();

        return view('pesanan/dipakai', compact(
            'status',
            'dataPesanan',
            'dataAda',
            'verifikasi',
            'profil'
        ));
    }



    public function getDisabledDates($kendaraanId, $excludePesananId)
    {
        $pesanans = Pesanan::where('kendaraan_id', $kendaraanId)
            ->where('id', '!=', $excludePesananId)
            ->whereIn('status', ['belum_dibayar', 'diproses', 'dikirim', 'dipakai'])
            ->get();

        $disabledDates = [];

        foreach ($pesanans as $pesanan) {
            $periode = CarbonPeriod::create($pesanan->tanggal_mulai, $pesanan->tanggal_selesai);
            foreach ($periode as $date) {
                $disabledDates[] = $date->format('Y-m-d');
            }
        }

        $tanggalTerdekat = $pesanans->where('tanggal_mulai', '>', now())->sortBy('tanggal_mulai')->first()?->tanggal_mulai;

        return response()->json([
            'disabled_dates' => array_values(array_unique($disabledDates)),
            'min_conflict_date' => $tanggalTerdekat
        ]);
    }


    public function tambahDurasi(Request $request, $id)
    {
        $request->validate([
            'tanggal_selesai' => 'required|date|after:now',
        ]);

        $pesanan = Pesanan::with('kendaraan')->findOrFail($id);
        $tanggalMulai = Carbon::parse($pesanan->tanggal_mulai);
        $tanggalSelesaiSebelumnya = Carbon::parse($pesanan->tanggal_selesai);
        $tanggalBaru = Carbon::parse($request->tanggal_selesai);

        // Validasi konflik tanggal
        $tanggalBentrokTerdekat = Pesanan::where('kendaraan_id', $pesanan->kendaraan_id)
            ->where('id', '!=', $pesanan->id)
            ->whereIn('status', ['belum_dibayar', 'diproses', 'dikirim', 'dipakai'])
            ->whereDate('tanggal_mulai', '>', $tanggalSelesaiSebelumnya)
            ->orderBy('tanggal_mulai', 'asc')
            ->value('tanggal_mulai');

        if ($tanggalBentrokTerdekat) {
            $tanggalBentrokCarbon = Carbon::parse($tanggalBentrokTerdekat);
            if ($tanggalBaru >= $tanggalBentrokCarbon) {
                return redirect()->back()->withErrors([
                    'tanggal_selesai' => 'Anda tidak bisa memperpanjang karena sudah ada pesanan lain mulai tanggal ' . $tanggalBentrokCarbon->format('Y-m-d')
                ]);
            }
        }

        // Hitung ulang biaya
        $harga_perhari = $pesanan->kendaraan->harga;
        $selisihHari = $tanggalMulai->diffInDays($tanggalBaru);
        $totalHarga = $harga_perhari * $selisihHari;

        $pesanan->biaya_tambahan = $totalHarga - $pesanan->biaya;
        $pesanan->tanggal_selesai = $request->tanggal_selesai;
        $pesanan->save();

        return redirect()->back()->with('success', 'Durasi berhasil diperbarui.');
    }


    public function updateSelesai($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->status = 'selesai';
        $pesanan->save();

        return redirect()->route('pesanan.riwayat');
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
        $profil = Profil::where('user_id', $user->id)->first();


        $dataPesanan = Pesanan::where('user_id', $user->id)
            ->where('status', 'selesai')
            ->with('kendaraan')
            ->get();

        return view('pesanan/riwayat_pesanan', compact('status', 'dataPesanan', 'dataAda', 'verifikasi', 'profil'));
    }
}
