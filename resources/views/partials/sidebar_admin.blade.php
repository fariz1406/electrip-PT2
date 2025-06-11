<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Verifikasi</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

  <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap");

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      text-decoration: none;
      font-family: "Poppins", sans-serif;
    }

    body {
      background-color: #2B2B3C;
    }

    .sidebar {
      width: 25%;
      height: 100vh;
      background-color: #1E1E2F;
      position: fixed;
      top: 0;
      left: 0;
      padding: 20px;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
    }

    .admin-box {
      background-color: #ffc107;
      color: #1e1e2f;
      font-weight: bold;
      text-align: center;
      padding: 12px;
      border-radius: 8px;
      margin-bottom: 30px;
      font-size: 18px;
    }

    .menu {
      flex-grow: 1;
    }

    .menu-title {
      color: #888;
      font-size: 13px;
      margin-bottom: 10px;
      letter-spacing: 1px;
      text-transform: uppercase;
      border-bottom: 1px solid #333;
      padding-bottom: 5px;
    }

    .sidebar ul {
      list-style: none;
    }

    .sidebar ul li {
      margin: 15px 0;
    }

    .sidebar ul li a {
      color: #E0E0E0;
      font-size: 15px;
      display: block;
      transition: all 0.2s ease-in-out;
    }

    .sidebar ul li a:hover {
      color: #ffc107;
      padding-left: 5px;
    }

    .text-button-sidebar {

      background: none;
      border: none;
      color: inherit;
      font: inherit;
      cursor: pointer;
      padding: 0;
      color: red;
    }
  </style>
</head>

<body>
  <div class="sidebar">
    <div class="admin-box">ADMIN</div>

    <div class="menu">
      <div class="menu-title">Menu</div>
      <ul>
        <li><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li><a href="{{route('users.tampil')}}">Pengguna</a></li>
        <li><a href="{{route('kendaraan.tampil')}}">Kendaraan</a></li>
        <li><a href="{{route('pesanan.data')}}">Pesanan</a></li>
        <li><a href="{{route('validasi.verifikasi')}}">Verifikasi</a></li>
        <li><a href="{{route('finance.dashboard')}}">Rangkuman Pendapatan</a></li>
        <li><a href="{{route('finance.dataPesanan')}}">Riwayat Transaksi</a></li>
      </ul>

      <div class="menu-title" style="margin-top: 30px;">Lainnya</div>
      <ul>

        <form action="{{ route('logout') }}" method="post">
          @csrf
          <button class="text-button-sidebar">Keluar</button>
        </form>
      </ul>
    </div>
  </div>
</body>

</html>