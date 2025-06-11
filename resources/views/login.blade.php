<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login ElecTrip</title>
  <link rel="stylesheet" href="{{ asset('css/login.css') }}" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
        <input type="email" name="email" placeholder="Email" required style="padding-right: 30px;" />
      </div>

      <div class="input2">
        <div style="position: relative;">
          <input type="password" name="password" placeholder="Kata Sandi" id="password" required style="padding-right: 30px;" />
          <i class="fa-solid fa-eye" id="togglePassword" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
        </div>
      </div>

      <button type="submit" name="masuk">masuk</button>
      <p>Belum punya akun? <a href="register">Daftar disini</a></p>
    </form>
  </div>

  <script>
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    togglePassword.addEventListener('click', function() {
      // Toggle the type attribute
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);

      // Toggle the icon
      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
    });
  </script>

</body>

</html>