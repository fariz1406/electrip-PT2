<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>

  <style>
    @import url("https://fonts.googleapis.com/css2?family=Montserrat+Alternates:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

    * {
      font-family: "Poppins", Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif;
      margin: 0;
      padding: 0;
    }

    .navbar {
      top: 0px;
      margin: 0;
      padding: 0;
      width: 100%;
      align-items: center;
      height: 55px;
      background-color: #848484;
      display: flex;
      justify-content: space-between;
      position: fixed;
      z-index: 9999999;
    }

    .logo img {
      width: 150px;
      margin-top: 5px;
      height: auto;
      margin-left: 35px;
    }

    .menu-navbar {
      display: flex;
      align-items: center;
      margin-right: 10px;
    }

    .navbar ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
      display: flex;
      align-items: center;
    }

    .navbar ul li {
      margin: 0 20px;
    }

    .navbar ul .foto-navbar {
      margin-left: -10px;
    }

    .navbar ul li a {
      color: #ffffff;
      font-size: 22px;
      text-decoration: none;
    }

    .text-button-navbar {
      background: none;
      border: none;
      color: white;
      cursor: pointer;
      font: inherit;
      font-size: 22px;
      padding: 0;
    }

    .navbar ul li a:hover,
    .text-button-navbar:hover {
      color: #ffcc00;
      text-decoration: underline;
      transition: 0.5s;
    }

    .foto-navbar {
      height: 40px;
      width: 40px;
      border: 1px solid black;
      border-radius: 50%;
      overflow: hidden;
    }

    .foto-navbar img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: center;
      border-radius: 50%;
    }
  </style>
</head>

<body>

  <!-- navbar -->
  <div class="navbar">

    <div class="logo"><img src="{{ asset('img/ElecTrip teks.png') }}" alt="" /></div>

    <div class="menu-navbar">
      <ul>
        <li><a href="{{ route('beranda') }}">BERANDA</a></li>
        @if(isset($dataAda) && $dataAda->validasi == 'setuju')
        <li><a href="{{ route('pilihan') }}">PESAN SEKARANG</a></li>
        @else
        <li><a href="">PESAN SEKARANG</a></li>
        @endif
        @if (Auth::id() == "")  
        <!-- konten guest -->
        @else
          @if ($profil)
          <li><a href="{{ route('profil.tampil') }}">PROFIL</a></li>
          <div class="foto-navbar">
          <img src="{{ asset('img/profil/'. optional(Auth::user()->profil)->foto_profil) }} " />
          </div>
          @else
          <li><a href="{{ route('profil.tampil') }}">PROFIL</a></li>
          <div class="foto-navbar">
          <img src="{{ asset('img/Profile_user.png') }} " />
          </div>
          @endif
        @endif

        </li>
      </ul>
    </div>

  </div>

  <!-- batas navbar -->
</body>

</html>