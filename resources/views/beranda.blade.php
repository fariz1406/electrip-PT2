<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Beranda</title>
  <link rel="stylesheet" href="{{ asset('css/beranda.css') }}" />
</head>
<style>
  .kelompokAuth {
    display: flex;
    gap: 60px;
  }

  .buttonLogin {
    padding: 9px 38px;
    text-align: center;
    transition: 0.4s ease;
    border-radius: 28px;
    border: solid 1px #ffcc00;
  }

  .buttonLogin:hover {
    background-color: #ffcc00;
    padding: 9px 38px;
    text-align: center;
  }

  .buttonLogin:hover h3 {
    color: white;
  }

  .buttonLogin h3 {
    color: white;
    font-size: 35px;
    font-weight: 500;
  }

  .buttonRegister {
    padding: 9px 38px;
    text-align: center;
    transition: 0.4s ease;
    border-radius: 28px;
    border: solid 1px #ffcc00;
  }

  .buttonRegister:hover {
    background-color: #ffcc00;
    padding: 9px 38px;
    text-align: center;
  }

  .buttonRegister:hover h3 {
    color: white;
  }

  .buttonRegister h3 {
    color: white;
    font-size: 35px;
    font-weight: 500;
  }



  .popup {
    position: fixed;
    color: white;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #262626;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0px 0px 10px black;
    z-index: 9999999999999999999999;
  }

  .isi-popup {
    margin-bottom: 20px;
    text-align: center;
  }

  /* button */
  .tombol-popup-wrapper {
    margin-top: 18px;
    display: flex;
    justify-content: end;
    align-items: end;
  }

  .tombol-popup {
    border: none;
    padding: 12px 24px;
    border-radius: 24px;
    font-size: 12px;
    font-size: 0.8rem;
    letter-spacing: 2px;
    cursor: pointer;
  }

  .batal-popup {
    background: transparent;
    color: #ffcc00;
    border: 1px solid #ffcc00;
    transition: all 0.3s ease;
  }

  .batal-popup:hover {
    transform: scale(1.125);
    color: red;
    border-color: red;
    transition: all 0.3s ease;
  }

  .oke-popup {
    background: #ffcc00;
    color: rgba(255, 255, 255, 0.95);
    filter: drop-shadow(0);
    font-weight: bold;
    transition: all 0.3s ease;
    margin-left: 10px;
  }

  .oke-popup:hover {
    transform: scale(1.125);
    border-color: rgba(255, 255, 255, 0.9);
    filter: drop-shadow(0 10px 5px rgba(0, 0, 0, 0.125));
    transition: all 0.3s ease;
    background-color: green;
  }

  /* batas button */
</style>

<body>

  @include('partials.navbar')


  @if (Auth::id() == "")

  @else

  @if(session('first_login_done') && !$dataAda)

  <div id="popup" class="popup">
    <div class="isi-popup">
      <h2>Sebelum Melakukan Penyewaan <br>
        <span style="color: #ffcc00;">Verifikasi</span> Terlebih Dahulu
      </h2>
    </div>
    <div class="tombol-popup-wrapper">
      <a href="{{ route('verifikasi.index') }}">
        <button class="tombol-popup oke-popup">Oke</button></a>
    </div>
  </div>
  @elseif(isset($dataAda) && $dataAda->validasi == 'belum')
  <div id="popup" class="popup">
    <div class="isi-popup">
      <h2>Verifikasi anda sudah terkirim <br>tunggu
        <span style="color: #ffcc00;">Admin</span> menyetujui
      </h2>
    </div>
    <div class="tombol-popup-wrapper">
      <a href="{{ route('verifikasi.index') }}">
        <button class="tombol-popup oke-popup">Oke</button></a>
    </div>
  </div>
  @elseif(isset($dataAda) && $dataAda->validasi == 'tidak')
  <div id="popup" class="popup">
    <div class="isi-popup">
      <h2>Verifikasi Anda ditolak! <br> harap
        <span style="color: #ffcc00;">Verifikasi</span> ulang
      </h2>
    </div>
    <div class="tombol-popup-wrapper">
      <a href="{{ route('verifikasi.edit', $user_id) }}">
        <button class="tombol-popup oke-popup">Oke</button></a>
    </div>
  </div>
  @endif
  @endif
  <div class="wrapper1">
    <section id="Home" class="overlay">
      <div class="overlay-content">
        <h1 class="headerText">
          Jelajahi Dunia Luar <br />
          <span>Tanpa Polusi</span>
        </h1>

        @if (Auth::id() == "")
        <div class="kelompokAuth">
          <a class="buttonLogin" href="{{ route('login') }}">
            <h3>Login</h3>
          </a>
          <a class="buttonRegister" href="{{ route('register') }}">
            <h3>Register</h3>
          </a>
        </div>
        @else
        
          <button type="submit" name="pesan">Pesan Sekarang</button>
        
        @endif
      </div>

    </section>
  </div>
  <div class="wrapper2">
    <div class="gmbr1">
      <img src="{{ asset('img/baterai.png') }}" alt="" />
      <p>Recharge</p>
    </div>
    <div class="gmbr2">
      <img src="{{ asset('img/uang.png') }}" alt="" />
      <p>Ekonomis</p>
    </div>
    <div class="gmbr3">
      <img src="{{ asset('img/udara.png') }}" alt="" />
      <p>Ramah Lingkungan</p>
    </div>
  </div>
  <div class="wrapper3">
    <p>
      <span>Tentang Electrip</span> <br />
      Electrip adalah platform penyewaan kendaraan berbasis online yang dirancang<br />
      untuk memberikan pengalaman sewa kendaraan yang mudah, cepat,<br />
      dan terpercaya. Dengan pilihan kendaraan yang beragam, mulai<br />
      dari mobil hingga motor, Electrip hadir untuk memenuhi kebutuhan<br />
      perjalanan Anda, baik untuk keperluan harian, liburan, maupun lainnya.<br />
      Kami mengutamakan kenyamanan dan keamanan pengguna melalui sistem<br />
      verifikasi yang ketat, metode pembayaran yang aman, serta layanan <br />
      pelanggan yang responsif. Electrip adalah solusi modern untuk mobilitas<br />
      Anda, di mana saja dan kapan saja.
    </p>

    <!-- <a href="lainnya_Penyedia.php"><button>Klik Disini</button></a> -->
  </div>
<footer>
<hr />
  <div class="indukFooter">
    <div class="dalemFooter">
      <div class="kiriFooter">
        <img src="{{ asset('img/ElecTrip teks.png') }}" width="150px" height="auto" />
        <h4>demi masa depan yang keren</h4>
      </div>
      <div class="kananFooter">
        <div class="menuCol">
          <h5>Menu</h5>
          <ul>
            <li>Home</li>
            <li>Feature</li>
            <li>About us</li>
            <li>Contact</li>
          </ul>
        </div>
        <div class="menuCol">
          <h5>Support</h5>
          <ul>
            <li>Help Center</li>
            <li>Terms</li>
            <li>Privacy</li>
            <li>FAQ</li>
          </ul>
        </div>
      </div>
    </div>
    <hr />
    <div class="bawahFooter">
      Copyright ElecTrip 2024
    </div>
  </div>
</footer>

<style>
  .indukFooter {
    display: flex;
    flex-direction: column;
    padding: 40px;
    color: white;
    background-color: #000;
  }

  .indukFooter hr {
    border: none;
    border-top: 1px solid #555;
    margin: 20px 0;
  }

  .dalemFooter {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 40px;
  }

  .kiriFooter {
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-width: 300px;
  }

  .kiriFooter h4 {
    color: #ccc;
    font-size: 18px;
  }

  .kananFooter {
    display: flex;
    gap: 60px;
    flex-wrap: wrap;
    margin-right: 60px;
  }

  .menuCol {
    display: flex;
    flex-direction: column;
    min-width: 120px;
  }

  .menuCol h5 {
    margin-bottom: 10px;
    color: white;
    font-size: 16px;
  }

  .menuCol ul {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .menuCol li {
    color: #ccc;
    margin-bottom: 8px;
    cursor: pointer;
    transition: color 0.3s;
  }

  .menuCol li:hover {
    color: #fff;
  }

  .bawahFooter {
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    color: #888;
    font-size: 14px;
  }

  /* Optional: Responsive behavior */
  @media (max-width: 768px) {
    .dalemFooter {
      flex-direction: column;
      align-items: flex-start;
    }

    .kananFooter {
      flex-direction: column;
      gap: 20px;
      margin-top: 20px;
    }
  }
</style>


</body>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const popup = document.getElementById('popup');
    const closeBtn = popup.querySelector('button');

    closeBtn.addEventListener('click', function() {
      popup.style.display = 'none';
    });
  });
</script>

</html>