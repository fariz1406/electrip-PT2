<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/admin_finance/dashboard_keuangan.css')}}">
</head>

<body>

    @include('partials.admin_finance.dashboard_sidebar')
    <div class="main-content">
        <div class="header">
            <h2>Hallo Admin Keuangan</h2>
        </div>
        <div class="info-cards">
            <div class="card">
                <h3>Pendapatan Hari Ini</h3>
                <p>Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</p>
            </div>
            <div class="card">
                <h3>Pendapatan Minggu Ini</h3>
                <p>Rp {{ number_format($pendapatanMingguIni, 0, ',', '.') }}</p>
            </div>
            <div class="card">
                <h3>Pendapatan Bulan Ini</h3>
                <p>Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</p>
            </div>
            <div class="card">
                <h3>Kendaraan Terlaris</h3>
                <p>{{ $kendaraanPalingLaris->nama_kendaraan }}</p>
            </div>
            <div class="card">
                <h3>Pesanan Selesai</h3>
                <p>{{$jumlahPesananRiwayat}}</p>
            </div>
            <div class="card">
                <h3>Kendaraan Sedikit disewa</h3>
                <p>{{ $kendaraanPalingSedikitDisewa->nama_kendaraan }}</p>
            </div>
            <div class="card">
                <h3>Total Pendapatan</h3>
                <p>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
            </div>

        </div>
    </div>
</body>

</html>