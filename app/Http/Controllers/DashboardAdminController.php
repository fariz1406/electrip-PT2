<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardAdminController extends Controller
{
    function jumlah()
    {
        
    $jumlahUser = DB::table('users')->count();
    $jumlahPesanan = DB::table('pesanan')
                    ->where('status', '!=', 'selesai')
                    ->count();
    $jumlahPesananRiwayat = DB::table('pesanan')->where('status', 'selesai')->count();
    $jumlahMobil = DB::table('kendaraan')->where('kategori_id', '1')->count();
    $jumlahMotor = DB::table('kendaraan')->where('kategori_id', '2')->count();


        return view('/admin/dashboard_admin', compact('jumlahUser', 'jumlahPesanan', 'jumlahPesananRiwayat', 'jumlahMobil', 'jumlahMotor'));
    }
}
