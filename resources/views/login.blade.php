<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login ElecTrip</title>
  <link rel="stylesheet" href="{{ asset('css/login.css') }}" />
</head>

<body>
  <img src="{{ ('img/ElecTrip fix.png') }}" alt="" />
  <div class="container">
    <h1>Masuk</h1>
    @if(session('gagal'))
    <p style="color: red;">{{ session('gagal') }}</p>
    @endif
    <form action="{{ route('submitLogin') }}" method="POST">
      @csrf

      <div class="input1">
        <label for="email">Email</label>
        <input type="text" name="email" required />
      </div>
      <div class="input2">
        <label for="password">Kata Sandi</label>
        <input type="password" name="password" required />
      </div>
      <a class="" href="#">Lupa Sandi</a>
      <button type="submit" name="masuk">masuk</button>
      <p>Belum punya akun? <a href="register">Daftar disini</a></p>
    </form>
  </div>
</body>

</html>