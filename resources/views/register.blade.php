<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register ElecTrip</title>
  <link rel="stylesheet" href="{{ asset('css/register.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
</head>

<body>
  <img src="{{ asset('img/ElecTrip fix.png') }}" alt="">
  <div class="container">
    <h1>Daftar</h1>

    <form action="{{ route('submitRegister') }}" method="POST" onsubmit="return validatePasswords()">
      @csrf
      <div class="input1">
        <label>Nama Lengkap</label>
        <input type="text" name="nama" style="padding-right: 30px;" required>
      </div>

      <div class="input2">
        <!-- <label for="email">Email</label> -->
        <input type="email" name="email" placeholder="Email" style="padding-right: 30px;" required>
      </div>

      <div class="input3">
        <div style="position: relative;">
        <input type="password" name="password" id="password" placeholder="Kata Sandi" style="padding-right: 30px;" required>
        <i class="fa-solid fa-eye" id="togglePassword" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
        </div>
      </div>

      <div class="input3">
        <div style="position: relative;">
        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi Kata Sandi" style="padding-right: 30px;" required>
        <i class="fa-solid fa-eye" id="togglePasswordConfirmation" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer;"></i>
      </div>

      <button type="submit" name="register.submit">Daftar</button>
      <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk disini</a></p>
    </form>
  </div>

  <script>
    function validatePasswords() {
      const pw = document.getElementById('password').value;
      const pwConf = document.getElementById('password_confirmation').value;
      if (pw !== pwConf) {
        alert('Kata sandi dan konfirmasi tidak cocok.');
        return false;
      }
      return true;
    }
  </script>

  <script>
    function validatePasswords() {
      const pw = document.getElementById('password').value;
      const pwConf = document.getElementById('password_confirmation').value;
      if (pw !== pwConf) {
        alert('Kata sandi dan konfirmasi tidak cocok.');
        return false;
      }
      return true;
    }

    document.getElementById('togglePassword').addEventListener('click', function() {
      const password = document.getElementById('password');
      const type = password.type === 'password' ? 'text' : 'password';
      password.type = type;
      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
    });

    document.getElementById('togglePasswordConfirmation').addEventListener('click', function() {
      const passwordConf = document.getElementById('password_confirmation');
      const type = passwordConf.type === 'password' ? 'text' : 'password';
      passwordConf.type = type;
      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
    });
  </script>


</body>

</html>