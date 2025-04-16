<!-- batas -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pemesanan Kendaraan</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #121212;
    }

    .container {
      padding-top: 30px;
      display: flex;
      max-width: 1200px;
      margin: 20px auto;
      background: white;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .form-section {
      flex: 1;
      background-color: #2b2b2b;
      color: white;
      padding: 30px;
    }

    .form-section h1 {
      margin-bottom: 20px;
      font-size: 24px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .form-control {
      width: 100%;
      padding: 10px;
      font-size: 16px;
      border-radius: 5px;
      border: none;
    }

    .form-control:focus {
      outline: none;
      box-shadow: 0 0 5px rgba(255, 255, 255, 0.7);
    }

    .btn {
      display: block;
      width: 100%;
      padding: 10px;
      font-size: 16px;
      color: white;
      background: #ffcc00;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin-top: 15px;
    }

    .btn:hover {
      background: #e59400;
    }

    .details-section {
      flex: 1;
      padding: 30px;
      background-color: #ffcc00;
      text-align: center;
    }


    .image-box {
      max-width: 95%;
      border-radius: 10px;
      margin-bottom: 20px;
    }

    .image-box img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: center;
      border-radius: 15px;
      margin-top: 10px;
      border: 2px solid black;
    }

    .details-section h2 {
      margin-bottom: 15px;
    }

    #map {
      width: 100%;
      height: 200px;
      margin-bottom: 15px;
      border-radius: 5px;
    }
  </style>
</head>

<body>
  @include('partials.navbar')
  <div class="container">       
    <!-- Form Input Section -->
    <div class="form-section">
      <form action="{{ route('pesanan.submit', $id) }}" method="POST">
        @csrf
        <!-- Tanggal dan Waktu Mulai -->
        <div class="form-group">
          <label for="tanggal_mulai">Tanggal dan Waktu Mulai Sewa</label>
          <input type="datetime-local" id="tanggal_mulai" name="tanggal_mulai" class="form-control" required>
        </div>

        <!-- Tanggal Selesai -->
        <div class="form-group">
          <label for="tanggal_selesai">Tanggal Selesai Sewa</label>
          <input type="datetime-local" id="tanggal_selesai" name="tanggal_selesai" class="form-control" required>
        </div>

        <!-- Lokasi Penjemputan -->
        <div class="form-group">
          <label for="lokasi">Lokasi</label>
          <input type="text" id="lokasi" name="lokasi" class="form-control" placeholder="Pilih lokasi di peta" readonly required>
          <div id="map"></div>
          <input type="hidden" id="latitude" name="latitude">
          <input type="hidden" id="longitude" name="longitude">
        </div>

        <!-- Pesan -->
        <div class="form-group">
          <label for="pesan">Pesan (Opsional)</label>
          <textarea id="pesan" name="pesan" rows="3" class="form-control" placeholder="Masukkan pesan tambahan"></textarea>
        </div>

        <button type="submit" class="btn">Pesan Sekarang</button>
      </form>
    </div>

    <!-- Details Section -->
    <div class="details-section">
      <div class="image-box">
        <img src="{{ asset('img/kendaraan/' . $kendaraan->foto) }}" />
      </div>
      <h2>{{ $kendaraan->nama }}</h2>
      <p><strong>Harga:</strong> Rp {{ $kendaraan->harga }}/hari</p>
    </div>
  </div>

  <script>
    // Mengatur tanggal minimum untuk input datetime-local ke tanggal besok
    document.addEventListener('DOMContentLoaded', function () {
      const today = new Date();
      today.setDate(today.getDate() + 1); // Menambahkan 1 hari untuk mendapatkan tanggal besok
      const formattedDate = today.toISOString().slice(0, 16); // Format YYYY-MM-DDTHH:MM
      document.getElementById('tanggal_mulai').setAttribute('min', formattedDate);
      document.getElementById('tanggal_selesai').setAttribute('min', formattedDate);
    });

    const map = L.map('map').setView([-6.973040, 107.630895], 15); // Pusat peta
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
    }).addTo(map);

    let marker;
    map.on('click', function(e) {
      const { lat, lng } = e.latlng;
      if (marker) {
        marker.setLatLng([lat, lng]);
      } else {
        marker = L.marker([lat, lng]).addTo(map);
      }

      document.getElementById('latitude').value = lat;
      document.getElementById('longitude').value = lng;

      fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
        .then(response => response.json())
        .then(data => {
          document.getElementById('lokasi').value = data.display_name;
        });
    });

    document.getElementById('tanggal_mulai').addEventListener('change', function () {
        const startDateInput = document.getElementById('tanggal_mulai');
        const endDateInput = document.getElementById('tanggal_selesai');

        // Ambil nilai dari tanggal_mulai
        const startDate = new Date(startDateInput.value);

        // Jika tanggal_selesai belum diisi, atau ingin diatur ulang
        if (!endDateInput.value) {
            const endDate = new Date(startDate);
            endDate.setDate(startDate.getDate() + 1); // Tambahkan 1 hari
            endDateInput.value = formatDateTimeLocal(endDate); // Format sesuai input datetime-local
        } else {
            const endDate = new Date(endDateInput.value);
            endDate.setFullYear(startDate.getFullYear(), startDate.getMonth(), startDate.getDate());
            endDate.setHours(startDate.getHours());
            endDate.setMinutes(startDate.getMinutes());
            endDateInput.value = formatDateTimeLocal(endDate);
        }
    });

    // Fungsi untuk memformat tanggal ke format datetime-local
    function formatDateTimeLocal(date) {
        const offset = date.getTimezoneOffset() * 60000; // Offset dalam milidetik
        const adjustedDate = new Date(date - offset); // Sesuaikan waktu berdasarkan timezone
        return adjustedDate.toISOString().slice(0, 16); // Format ke datetime-local (YYYY-MM-DDTHH:mm)
    }
  </script>
</body>



</html>