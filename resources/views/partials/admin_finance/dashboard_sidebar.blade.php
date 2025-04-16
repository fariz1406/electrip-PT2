<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Verifikasi</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

  <style>
    @import url("https://fonts.googleapis.com/css2?family=Montserrat+Alternates:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

    /* sidebar */
    * {
      text-decoration: none;
      margin: 0px;
      padding: 0px;
      font-family: "Poppins", Impact, Haettenschweiler, "Arial Narrow Bold", sans-serif;
    }

    body {
      margin: 0px;
      padding: 0px;
    }

    .sidebar {
      width: 25%;
      height: 100%;
      background-color: #2b2b2b;
      position: fixed;
      top: 0;
      left: 0;
    }

    .kotak {
      width: 289px;
      height: 155px;
      background-color: #ffcc00;
      border-radius: 8px;
      position: absolute;
    }

    .kotak1 {
      width: 230px;
      height: 69px;
      background-color: #2b2b2b;
      position: absolute;
      top: 50px;
      left: 10px;
      border-radius: 11px;
      z-index: 999;
      display: flex;
      text-align: center;
      justify-content: center;
      align-items: center;
    }


    .fotoprofil-box {
      width: 45px;
      height: 45px;
      margin-left: 10px;
      margin-top: 10px;
      position: sticky;
    }

    .fotoprofil-box img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      object-position: center;
      border-radius: 50%;
    }

    .row ul {
      display: flex;
      flex-direction: column;
      list-style-type: none;
      margin: 5px 0;
      color: #ffffff;
      margin-top: 170px;
      z-index: 999;
      position: absolute;
      left: 15px;
      font-size: 18px;
      gap: 40px;
    }

    .row ul li a {
      color: #ffffff;
    }

    .row ul li a:hover {
      color: #b1b1af;
    }

    .row ul li {
      display: flex;
      align-items: center;
    }

    .row ul li span:first-child {
      flex-grow: 1;
    }

    .row .settings {
      margin-top: -10px;
      margin-bottom: 5px;
      font-size: 17px;
      opacity: 0.5;
    }

    #logout a {
      color: #ffcc00;
    }

    #logout a:hover {
      color: #c09b08;
    }

    .kotak1 p {
      font-size: 5vh;
      color: #ffffff;

    }

    .row .settings2 {
      margin-top: 10px;
      margin-bottom: 2px;
      font-size: 17px;
      opacity: 0.5;
    }

    .row .logout {
      color: #ffcc00;
    }

    .row ul li a span:hover {
      color: #ffcc00;
    }

    .row ul li a .keluar:hover {
      color: red;
    }


    .text-button-sidebar {

      background: none;
      border: none;
      color: inherit;
      font: inherit;
      cursor: pointer;
      padding: 0;
      color: red;
    }


    /* batas sidebar */
  </style>
</head>

<body>
  <!-- sidebar -->
  <div class="sidebar">
    <div class="row">
      <ul>
        <li class="settings">Menu</li>
        <li>
          <a href="{{ route('finance.dashboard') }}"><span>Dashboard</span> </a>
        </li>
        <li>
          <a href="{{ route('finance.dataPesanan') }}"><span>Data Transaksi</span> </a>
        </li> 
          <a href="bantuandukungan.html"><span></span></a>
        </li>
        <li id="logout">
          <form action="{{ route('logout') }}" method="post">
            @csrf
            <button class="text-button-sidebar">Keluar</button>
          </form>
        </li>
      </ul>
    </div>
    <div class="kotak">
      <div class="kotak1">
        <p>Finance</p>
      </div>

    </div>
  </div>
  <!-- batas sidebar -->
</body>

</html>