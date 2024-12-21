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
  background-color: #121212;
}

    .map {
      margin: 0;
      width: 100%;
      height: 730px;
    }

    .btn {
      display: block;
      text-align: center;
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

    .btn:hover {
      background-color: red;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

  </style>
</head>

<body>

    <div id="map" class="map"></div>


    <a href="{{ route('pesanan.diKirim') }}" class="btn">Kembali</a>

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