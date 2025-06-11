<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pesanan saya</title>
  <link rel="stylesheet" href="{{ asset('css/pesanan.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


</head>

<body>
  @include('partials.navbar')
  @include('partials.sidebar')
  @include('partials.popup_tambahDurasi')

  <div class="container">

    @if($errors->has('datetime'))
    <div style="color: red;">{{ $errors->first('datetime') }}</div>
    @endif


    <div class="pilihan">
      <ul>
        <a href="{{route('pesanan.belumDibayar')}}">
          <li>
            <h2>belum dibayar</h2>
          </li>
        </a>
        <a href="{{route('pesanan.diProses')}}">
          <li>
            <h2>di proses</h2>
          </li>
        </a>
        <a href="{{route('pesanan.diKirim')}}">
          <li>
            <h2>di kirim</h2>
          </li>
        </a>
        <a href="{{route('pesanan.diPakai')}}">
          <li class="disini">
            <h2>di pakai</h2>
          </li>
        </a>
        <a href="{{route('pesanan.riwayat')}}">
          <li>
            <h2>Riwayat</h2>
          </li>
        </a>
      </ul>
    </div>

    <hr>

    @foreach($dataPesanan as $data)

    <div class="card">
      <div class="image-box">
        <img src="{{ asset('img/kendaraan/' . $data->kendaraan->foto) }}">
      </div>

      <div class="text">
        <h2>Merk : {{ $data->kendaraan->nama }}</h2>
        <h3>Biaya : Rp. {{ number_format($data->biaya, 0, ',', '.') }}</h3>
        @if($data->biaya_tambahan == null)

        @else
        <h3>Biaya tambahan : Rp. {{ number_format($data->biaya_tambahan, 0, ',', '.') }}</h3>
        @endif

        <hr class="garis">
        <h3 class="alamat">Berakhir pada tanggal {{ \Carbon\Carbon::parse($data->tanggal_selesai)->format('Y-m-d') }} Jam {{ \Carbon\Carbon::parse($data->waktu_jam)->format('H:i') }} WIB</h3>

      </div>

      <br>

      <div class="tombol">
        <form action=""></form>
        <button class="btn-tambah-durasi"
          data-order-id="{{ $data->id }}"
          data-current-end-date="{{ $data->tanggal_selesai }}"
          data-kendaraan-id="{{ $data->kendaraan_id }}">
          Tambah Durasi
        </button>


      </div>
      <div class="tombol">
        <form action=""></form>
        <button class="btn-selesai done" data-order-id="{{ $data->id }}">Selesai</button>

      </div>

    </div>

    @endforeach

    <div id="modal-tambah-durasi" class="popup">
      <form id="form-tambah-durasi" method="POST">

        <div class="isi-popup">
          <h2>Silahkan pilih <span style="color: #ffcc00;">Tanggal</span> Terbaru <br>
            Biaya tambahan dibayar <span style="color: #ffcc00;">cash</span> <br>
            saat pengembalian
          </h2>
          @csrf
          @method('PUT')
          <input type="hidden" name="order_id" id="order-id">
          <input type="hidden" name="harga_per_hari" id="harga-per-hari">
          @if ($errors->has('tanggal_selesai'))
          <div style="color: red;">{{ $errors->first('tanggal_selesai') }}</div>
          @endif
          <input type="date" name="tanggal_selesai" placeholder="klik disini" id="datetime" class="styled-datepicker" required>


        </div>
        <div class="tombol-popup-wrapper">
          <button type="button" class="tombol-popup batal-popup" id="btn-batal" onclick="closeModal()">Batal</button>
          <button type="submit" class="tombol-popup oke-popup">Simpan</button>
        </div>
      </form>
    </div>

    <!-- popup konfirmasi selesai -->
    <div id="modal-konfirmasi-selesai" class="popup">
      <form id="form-konfirmasi-selesai" method="POST">
        @csrf
        @method('PUT')
        <div class="isi-popup">
          <h2>Apakah Anda Yakin <br>
            <span style="color: #ffcc00;">Pesanan</span> Telah Selesai?
          </h2>
        </div>
        <div class="tombol-popup-wrapper">
          <button type="button" id="btn-batal-selesai" class="tombol-popup batal-popup">Batal</button>
          <button type="submit" id="btn-ya-selesai" class="tombol-popup oke-popup">Selesai</button>
        </div>
      </form>
    </div>

  </div>

</body>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const modalDurasi = document.getElementById("modal-tambah-durasi");
    const datetimeInput = document.getElementById("datetime");
    const formDurasi = document.getElementById("form-tambah-durasi");
    const cancelDurasiBtn = document.getElementById("btn-batal");

    let flatpickrInstance = null;

    function openModalDurasi(orderId, currentEndDate) {
      const kendaraanId = document.querySelector(`.btn-tambah-durasi[data-order-id="${orderId}"]`).getAttribute("data-kendaraan-id");
      const apiUrl = `/pesanan/disabled-dates/${kendaraanId}/${orderId}`;

      datetimeInput.value = "";

      fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
          const disabledDates = data.disabled_dates;
          const maxDate = data.min_conflict_date;

          formDurasi.setAttribute("action", `/pesanan/tambahDurasi/${orderId}`);
          document.getElementById("order-id").value = orderId;

          if (flatpickrInstance) {
            flatpickrInstance.destroy();
          }

          flatpickrInstance = flatpickr(datetimeInput, {
            dateFormat: "Y-m-d",
            minDate: currentEndDate,
            maxDate: maxDate ?? null,
            disable: disabledDates
          });

          modalDurasi.style.display = "block";
        });
    }

    function closeModalDurasi() {
      modalDurasi.style.display = "none";
      datetimeInput.value = "";
      if (flatpickrInstance) {
        flatpickrInstance.destroy();
        flatpickrInstance = null;
      }
    }

    // Tombol Tambah Durasi
    document.querySelectorAll(".btn-tambah-durasi").forEach(button => {
      button.addEventListener("click", function() {
        const orderId = this.getAttribute("data-order-id");
        const currentEndDate = this.getAttribute("data-current-end-date");
        openModalDurasi(orderId, currentEndDate);
      });
    });

    // Tombol Batal popup durasi
    cancelDurasiBtn.addEventListener("click", closeModalDurasi);

    // Klik di luar popup untuk menutup
    window.addEventListener("click", function(event) {
      if (event.target === modalDurasi) {
        closeModalDurasi();
      }
    });

    // Validasi submit form
    formDurasi.addEventListener("submit", function(event) {
      const selectedDate = new Date(datetimeInput.value);
      const minDate = new Date(datetimeInput.min);
      if (selectedDate < minDate) {
        event.preventDefault();
        alert("Tanggal baru harus lebih besar atau sama dengan tanggal sebelumnya.");
      }
    });

    // konfirmasi selesai

    const modalSelesai = document.getElementById("modal-konfirmasi-selesai");
    const formSelesai = document.getElementById("form-konfirmasi-selesai");
    const cancelSelesaiBtn = document.getElementById("btn-batal-selesai");

    document.querySelectorAll(".btn-selesai").forEach(button => {
      button.addEventListener("click", function() {
        const orderId = this.getAttribute("data-order-id");
        formSelesai.setAttribute("action", `/pesanan/selesai/${orderId}`);
        modalSelesai.style.display = "block";
      });
    });

    cancelSelesaiBtn.addEventListener("click", () => {
      modalSelesai.style.display = "none";
    });

    window.addEventListener("click", function(event) {
      if (event.target === modalSelesai) {
        modalSelesai.style.display = "none";
      }
    });
  });
</script>


</html>