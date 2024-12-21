<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booking Details</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f0f4f8;
    }

    .container {
      width: 75%;
      margin-left: 25%;
      padding: 20px;
      background-color: #5b5b5b;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
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

    .field {
      margin-bottom: 20px;
    }

    .field label {
      display: block;
      font-weight: bold;
      margin-bottom: 8px;
      color: #f1f1f1;
      font-size: 16px;
    }

    .field span {
      display: block;
      font-size: 14px;
      color: #dcdcdc;
    }

    .field img {
      max-width: 100%;
      height: auto;
      border: 1px solid #ddd;
      border-radius: 8px;
      margin-top: 10px;
      transition: transform 0.3s;
    }

    .field img:hover {
      transform: scale(1.05);
    }

    .map {
      margin-top: 20px;
    }

    .map iframe {
      width: 100%;
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
      background-color: #3498db;
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
      background-color: #2980b9;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }
  </style>
</head>

<body>
  @include('partials.sidebar_admin')
  <div class="container">
    <div class="header">
      <h1>Booking Details</h1>
    </div>

    <div class="field">
      <label for="name">Name:</label>
      <span id="name">{{ $pesanan->user_name }}</span>
    </div>

    <div class="field">
      <label for="email">Email:</label>
      <span id="email">{{ $pesanan->user_email }}</span>
    </div>

    <div class="field">
      <label for="vehicle-image">Vehicle Image:</label>
      <img id="vehicle-image" src="{{ asset('img/kendaraan/' . $pesanan->kendaraan_foto) }}" alt="Vehicle Image">
    </div>

    <div class="field">
      <label for="vehicle-name">Vehicle Name/Brand:</label>
      <span id="vehicle-name">{{ $pesanan->kendaraan_nama }}</span>
    </div>

    <div class="field">
      <label for="price">Price:</label>
      <span id="price">$50/day</span>
    </div>

    <div class="field">
      <label for="start-date">Start Date and Time:</label>
      <span id="start-date">2024-12-20 10:00 AM</span>
    </div>

    <div class="field">
      <label for="end-date">End Date and Time:</label>
      <span id="end-date">2024-12-25 10:00 AM</span>
    </div>

    <div class="field">
      <label for="address">Address:</label>
      <span id="address">123 Main Street, Cityville</span>
    </div>

    <div class="map">
      <label for="map">Location Map:</label>
      <iframe id="map"
        src="https://www.openstreetmap.org/export/embed.html?bbox=106.8283%2C-6.1751%2C106.8293%2C-6.1741&amp;layer=mapnik"
        allowfullscreen>
      </iframe>
    </div>

    <a href="{{ route('pesanan.data') }}" class="btn">Kembali</a>
  </div>
</body>

</html>