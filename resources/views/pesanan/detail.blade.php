<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booking Details</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

  <style>
    body {
      font-family: 'Arial', sans-serif;
      background-color: #121212;
    }

    .container {
      width: 75%;
      margin-top: 50px;
      margin-left: 25%;
      padding: 20px;
      background-color: #121212;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      color: #f1f1f1;
    }

    .header {
      text-align: center;
      margin-bottom: 30px;
    }

    .header h1 {
      margin: 0;
      font-size: 28px;
      color: #ffffff;
    }

    .content {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .details {
      flex: 1;
    }

    .details .field {
      margin-bottom: 20px;
    }

    .details .field label {
      display: block;
      font-weight: bold;
      margin-bottom: 8px;
      color: #f1f1f1;
      font-size: 16px;
    }

    .details .field span {
      display: block;
      font-size: 14px;
      color: #dcdcdc;
    }

    .vehicle-image {
      flex: 0 0 300px;
      text-align: center;
    }

    .vehicle-image label {
      display: block;
      font-weight: bold;
      margin-bottom: 8px;
      color: #f1f1f1;
      font-size: 16px;
    }

    .vehicle-image img {
      max-width: 80%;
      height: auto;
      border: 1px solid #ddd;
      border-radius: 8px;
      margin-top: 10px;
      margin-right: 30px;
      transition: transform 0.3s;
    }

    .vehicle-image img:hover {
      transform: scale(1.05);
    }

    .map {
      margin-top: 20px;
      width: 90%;
      height: 300px;
      border: 0;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .container .btn {
      display: block;
      text-align: center;
      margin: 20px auto 0;
      padding: 10px 20px;
      background-color: #ffcc00;
      color: #fff;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      text-decoration: none;
      cursor: pointer;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      transition: background-color 0.3s, box-shadow 0.3s;
    }

    .container .btn:hover {
      background-color: red;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }
  </style>
</head>

<body>
@include('partials.navbar')
@include('partials.sidebar')
  <div class="container">
    <div class="header">
      <h1>Detail Pesanan</h1>
    </div>

    <div class="content">
      <div class="details">
        <div class="field">
          <label for="name">Nama Pemesan:</label>
          <span id="name">{{ $pesanan->user_name }}</span>
        </div>

        <div class="field">
          <label for="email">Email Pemesan:</label>
          <span id="email">{{ $pesanan->user_email }}</span>
        </div>

        <div class="field">
          <label for="vehicle-name">Merk Kendaraan:</label>
          <span id="vehicle-name">{{ $pesanan->kendaraan_nama }}</span>
        </div>

        <div class="field">
          <label for="price">Biaya:</label>
          <span id="price">Rp. {{ number_format($pesanan->biaya, 0, ',', '.') }}</span>
        </div>

        <div class="field">
          <label for="start-date">Waktu Pakai:</label>
          <span id="start-date">Tanggal {{ \Carbon\Carbon::parse($pesanan->tanggal_mulai)->format('d-m-Y') }} Jam {{ \Carbon\Carbon::parse($pesanan->tanggal_mulai)->format('H:i') }} WIB</span>
        </div>

        <div class="field">
          <label for="end-date">Waktu Berakhir:</label>
          <span id="end-date">Tanggal {{ \Carbon\Carbon::parse($pesanan->tanggal_selesai)->format('d-m-Y') }} Jam {{ \Carbon\Carbon::parse($pesanan->tanggal_selesai)->format('H:i') }} WIB</span>
        </div>

        <div class="field">
          <label for="address">Lokasi:</label>
          <span id="address">{{ $pesanan->lokasi }}</span>
        </div>
      </div>

      <div class="vehicle-image">
        <label for="vehicle-image">Gambar Kendaraan:</label>
        <img id="vehicle-image" src="{{ asset('img/kendaraan/' . $pesanan->kendaraan_foto) }}" alt="Vehicle Image">
      </div>
    </div>

    <div id="map" class="map"></div>


    <a href="{{ route('pesanan.riwayat') }}" class="btn">Kembali</a>
  </div>

        <script>
            // Inisialisasi peta
            var map = L.map('map').setView([{{$pesanan->latitude}}, {{$pesanan->longitude}}], 13);

            // Tambahkan tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Tambahkan marker untuk lokasi pesanan
            var pesananMarker = L.marker([{{$pesanan->latitude}}, {{$pesanan->longitude}}])
                .addTo(map)
                .bindPopup('<b>{{ $pesanan->user_name }}</b><br>{{ $pesanan->kendaraan_nama }}')
                .openPopup();

          
        </script>

</body>



</html>