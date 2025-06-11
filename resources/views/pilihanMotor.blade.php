<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pilihan Mobil</title>
  <link rel="stylesheet" href="{{ asset('css/pilihanKendaraan.css') }}" />
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

</head>

<body>
  @include('partials.navbar')

  <div id="popup" class="popup-tanggal hidden">
    <div class="isi-popup-tanggal">
      <h2>Sebelum Melakukan Penyewaan <br> Pilih
        <span style="color: #ffcc00;">Tanggal</span> Terlebih Dahulu
      </h2>
    </div>
    <div class="tombol-popup-wrapper-tanggal">
      <button class="tombol-popup-tanggal oke-popup-tanggal" onclick="tutupPopup()">Oke</button>
    </div>
  </div>

  <div class="pemberitahuan">
    <p>Sebelum memesan, masukkan tanggal mulai dan tanggal selesai sewa terlebih dahulu</p>
  </div>

  <form action="{{ route('pilihanMotor') }}" method="get">
    <div class="pencarian">
      <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}" required>
      <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}" required>
      <button type="submit"><span class="material-symbols-outlined">search</span></button>
    </div>
  </form>

  <div class="wrap">
    <ul>
      <li><a href="pilihan">Mobil</a></li>
      <li class="aktif-sekarang"><a href="pilihanMotor">Motor</a></li>
    </ul>
  </div>

  <hr />

  <div class="container">
    @foreach($kendaraan as $data)
    <div class="card">
      <div class="image-box">
        <img src="{{ asset('img/kendaraan/' . $data->foto) }}" />
      </div>
      <div class="teks">
        <h3>{{ $data->nama }}</h3>
        <p>Rp {{ number_format($data->harga, 0, ',', '.') }} per 24 jam</p>
      </div>
      <div class="button-wrapper">
        <button class="btn detail" data-nama="{{ $data->nama }}" data-foto="{{ $data->foto }}"
          data-deskripsi="{{ $data->deskripsi }}" data-harga="{{ $data->harga }}"
          data-tahun="{{ $data->tahun }}" data-stnk="{{ $data->stnk }}">DETAIL</button>
        <!-- <a href="{{ route('pesanan.checkout', $data->id)}}" class="text-decoration"> -->
        <button onclick="cekTanggalDanLanjut('{{ route('pesanan.checkout', $data->id) }}')" class="btn beli">PESAN</button>
      </div>
    </div>
    @endforeach
  </div>

  <!-- Popup -->
  <div id="popup-detail" class="popup hidden">
    <span class="close-btn">×</span>
    <img id="popup-foto" src="" alt="Foto Kendaraan" width="100" />
    <h3 id="popup-nama"></h3>
    <p><strong>Harga:</strong> RP <span id="popup-harga"></span> Per 24 jam</p>
    <p><strong>Tahun:</strong> <span id="popup-tahun"></span></p>
    <p><strong>Deskripsi:</strong> <span id="popup-deskripsi"></span></p>
  </div>
  <div id="overlay" class="overlay hidden"></div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const popup = document.getElementById("popup-detail");
      const overlay = document.getElementById("overlay");
      const closeBtn = document.querySelector(".close-btn");

      // Fungsi untuk menampilkan popup
      function showPopup(data) {
        document.getElementById("popup-nama").textContent = data.nama;
        document.getElementById("popup-foto").src = `/img/kendaraan/${data.foto}`;
        document.getElementById("popup-deskripsi").textContent = data.deskripsi || "Tidak ada deskripsi.";
        document.getElementById("popup-harga").textContent = data.harga;
        document.getElementById("popup-tahun").textContent = data.tahun || "Tidak tersedia";

        // Tampilkan popup dan overlay
        popup.classList.remove("hidden");
        overlay.classList.remove("hidden");
      }

      // Tutup popup saat tombol close diklik
      closeBtn.addEventListener("click", () => {
        popup.classList.add("hidden");
        overlay.classList.add("hidden");
      });

      // Event listener untuk tombol detail
      const detailButtons = document.querySelectorAll(".btn.detail");
      detailButtons.forEach((button) => {
        button.addEventListener("click", (event) => {
          event.preventDefault();
          const data = {
            nama: button.dataset.nama,
            foto: button.dataset.foto,
            deskripsi: button.dataset.deskripsi,
            harga: button.dataset.harga,
            tahun: button.dataset.tahun,
          };
          showPopup(data);
        });
      });

      // Tutup popup jika overlay diklik
      overlay.addEventListener("click", () => {
        popup.classList.add("hidden");
        overlay.classList.add("hidden");
      });
    });
  </script>

  <script>
    function getQueryParam(param) {
      const urlParams = new URLSearchParams(window.location.search);
      return urlParams.get(param);
    }

    function cekTanggalDanLanjut(baseUrl) {
      const mulai = getQueryParam('tanggal_mulai');
      const selesai = getQueryParam('tanggal_selesai');

      if (!mulai || !selesai) {
        document.getElementById('popup').classList.add('show');
      } else {
        window.location.href = `${baseUrl}?tanggal_mulai=${mulai}&tanggal_selesai=${selesai}`;
      }
    }


    function tutupPopup() {
      document.getElementById('popup').classList.remove('show');
    }
  </script>
</body>

</html>