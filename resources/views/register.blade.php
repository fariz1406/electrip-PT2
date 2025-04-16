<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register ElecTrip</title>
  <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>
    <img src="{{ ('img/ElecTrip fix.png') }}" alt="">
  <div class="container">
    <h1>Daftar</h1>

    <form action="{{ route('submitRegister') }}" method="POST">
      @csrf
      <div class="input1">
        <label>Nama Lengkap</label>
        <input type="text" name="nama" required>
      </div>
      <div class="input2">
        <label>Email</label>
        <input type="email" name="email" required>
      </div>
      <div class="input3">
        <label>Kata Sandi</label>
        <input type="password" name="password" required>
      </div>
      <div class="input4">
        <label>Konfirmasi Kata Sandi</label>
        <input type="password">
      </div>
      <button type="submit" name="register.submit">Daftar</button>
      <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk disini</a></p>
    </form>
  </div>

  </body>

</html>