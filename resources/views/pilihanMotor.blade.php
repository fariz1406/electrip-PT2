<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pilihan Mobil</title>

  <link rel="stylesheet" href="{{ asset('css/pilihanKendaraan.css') }}" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <style>
    /* Tambahkan CSS untuk popup */
    .popup {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
      z-index: 1000;
    }

    .popup.hidden {
      display: none;
    }

    .popup .close-btn {
      position: absolute;
      top: 10px;
      right: 10px;
      cursor: pointer;
      font-size: 20px;
      font-weight: bold;
    }

    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 999;
    }

    .overlay.hidden {
      display: none;
    }
  </style>
</head>

<body>

  @include('partials.navbar')

  <form action="{{ route('pilihanMotor') }}" method="get">
    <div class="pencarian">
      <input type="text" name="search" placeholder="Cari Disini...." value="{{ $request->get('search') }}">
      <button><span class="material-symbols-outlined">search</span></button>
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
          data-tahun="{{ $data->tahun }}" ">DETAIL</button>
        <a href="{{ route('pesanan.checkout', $data->id) }}" class="text-decoration">
          <button class="btn beli">PESAN</button>
        </a>
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
    document.addEventListener("DOMContentLoaded", function () {
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
</body>

</html>
