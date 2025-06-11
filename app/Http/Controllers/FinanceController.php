<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    function Dashboard()
    {

        // Pendapatan hari ini
        $pendapatanHariIni = DB::table('pesanan')
            ->whereDate('updated_at', now()->toDateString()) // Filter berdasarkan tanggal hari ini
            ->where('status', 'selesai')
            ->sum('biaya');

        // Pendapatan bulan ini
        $pendapatanMingguIni = DB::table('pesanan')
        ->whereBetween('updated_at', [
            now()->startOfWeek(), 
            now() 
        ])
        ->where('status', 'selesai') 
        ->sum('biaya');

        // Pendapatan bulan ini
        $pendapatanBulanIni = DB::table('pesanan')
            ->whereYear('updated_at', now()->year) 
            ->whereMonth('updated_at', now()->month) 
            ->where('status', 'selesai') 
            ->sum('biaya');

        // Total pendapatan
        $totalPendapatan = DB::table('pesanan')
            ->where('status', 'selesai') 
            ->sum('biaya');

        $jumlahPesananRiwayat = DB::table('pesanan')->where('status', 'selesai')->count();

        $kendaraanPalingLaris = DB::table('pesanan')
            ->join('kendaraan', 'pesanan.kendaraan_id', '=', 'kendaraan.id') 
            ->select('kendaraan.nama as nama_kendaraan', DB::raw('COUNT(pesanan.kendaraan_id) as total_pesanan'))
            ->groupBy('pesanan.kendaraan_id', 'kendaraan.nama') 
            ->orderByDesc('total_pesanan') 
            ->limit(1) 
            ->first();

        $kendaraanPalingSedikitDisewa = DB::table('kendaraan')
            ->leftJoin('pesanan', 'kendaraan.id', '=', 'pesanan.kendaraan_id')
            ->select('kendaraan.nama as nama_kendaraan', DB::raw('COUNT(pesanan.kendaraan_id) as total_pesanan'))
            ->groupBy('kendaraan.id', 'kendaraan.nama')
            ->orderBy('total_pesanan', 'asc')
            ->limit(1)
            ->first();





        return view('admin/finance/dashboard_keuangan', compact('pendapatanHariIni', 'pendapatanMingguIni', 'pendapatanBulanIni', 'totalPendapatan', 'kendaraanPalingLaris', 'kendaraanPalingSedikitDisewa', 'jumlahPesananRiwayat'));
    }

    function dataPesanan()
    {

        $dataPesanan = DB::table('pesanan')
            ->join('users', 'pesanan.user_id', '=', 'users.id')
            ->join('kendaraan', 'pesanan.kendaraan_id', '=', 'kendaraan.id')
            ->select(
                'pesanan.id',
                'users.name',
                'kendaraan.nama',
                'pesanan.biaya',
                'pesanan.biaya_tambahan',
                'pesanan.status',
                'pesanan.tanggal_mulai',
                'pesanan.tanggal_selesai'
            )
            ->get();

        return view('admin/finance/data_transaksi', compact('dataPesanan'));
    }
}
