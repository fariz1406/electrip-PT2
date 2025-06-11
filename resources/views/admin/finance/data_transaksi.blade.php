<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>List Pengguna</title>
  <link rel="stylesheet" href="{{ asset('css/admin_finance/data_user.css') }}">
</head>
<style>
  .header {
    background-color: #121212;
    color: white;
    padding: 20px;
    border-radius: 5px;
    margin : 20px;
  }
  
</style>
<body>

@include('partials.sidebar_admin')

  <div class="container">

    <div class="header">
            <h2>List Data Transaksi</h2>
        </div>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>NAMA</th>
          <th>JENIS</th>
          <th>BIAYA</th>
          <th>DURASI</th>
          <th>STATUS</th>
        </tr>
      </thead>
      <tbody>
        @foreach($dataPesanan as $data)
        @php
        $durasiHari = \Carbon\Carbon::parse($data->tanggal_mulai)->diffInDays(\Carbon\Carbon::parse($data->tanggal_selesai));
        @endphp
        <tr>
          <td>{{ $data->id }}</td>
          <td>{{ $data->name }}</td>
          <td>{{ $data->nama }}</td>
          <td>Rp. {{ number_format($data->biaya + $data->biaya_tambahan, 0, ',', '.') }}</td>
          <td>{{ $durasiHari }} hari</td>
          <td>{{ $data->status }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="tombol">
    <a href="proses_sediakan.php">
      <img src="../assets/plus.png" alt="">
    </a>
  </div>
</body>

</html>
