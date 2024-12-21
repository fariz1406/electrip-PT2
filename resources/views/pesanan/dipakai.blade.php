<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pesanan saya</title>
  <link rel="stylesheet" href="{{ asset('css/pesanan.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
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

        <hr class="garis">
        <h3 class="alamat">Berakhir pada tanggal {{ \Carbon\Carbon::parse($data->tanggal_selesai)->format('Y-m-d') }} Jam {{ \Carbon\Carbon::parse($data->tanggal_selesai)->format('H:i') }} WIB</h3>

      </div>

      <br>

      <div class="tombol">
        <form action=""></form>
        <button class="btn-tambah-durasi" data-order-id="{{ $data->id }}" data-current-end-date="{{ $data->tanggal_selesai }}">
          Tambah Durasi
        </button>

      </div>
      <div class="tombol">
        <form action=""></form>
        <button class="btn-selesai done" data-order-id="{{ $data->id }}">Selesai</button>

      </div>

    </div>

    <div id="modal-tambah-durasi" class="popup">
      <form action="{{ route('pesanan.tambahDurasi', $data->id) }}" id="form-tambah-durasi" method="POST">
        <div class="isi-popup">
          <h2>Silahkan pilih <br>
            <span style="color: #ffcc00;">Tanggal dan Waktu</span> Terbaru
          </h2>
          @csrf
          @method('PUT')
          <input type="hidden" name="order_id" id="order-id">
          <input type="hidden" name="harga_per_hari" id="harga-per-hari" value="{{ $data->kendaraan->harga }}"> <!-- Harga per hari -->
          <input type="datetime-local" name="tanggal_selesai" id="datetime" required>
          <input type="hidden" name="order_id" id="order-id">

        </div>
        <div class="tombol-popup-wrapper">
          <button type="button" class="tombol-popup batal-popup" id="btn-batal" onclick="closeModal()">Batal</button>
          <button type="submit" class="tombol-popup oke-popup">Simpan</button>
        </div>
      </form>
    </div>

    <!-- pop up fungsi selesai -->

    <div id="modal-konfirmasi-selesai" class="popup">
    <!-- <form action="{{ route('pesanan.selesai', $data->id) }}" method="POST"> -->
      <div class="isi-popup">
        <h2>Apakah Anda Yakin <br>
          <span style="color: #ffcc00;">Pesanan</span> Telah Selesai?
        </h2>
      </div>
      <div class="tombol-popup-wrapper">
        <button id="btn-batal-selesai" class="tombol-popup batal-popup" >Batal</button>
        <button id="btn-ya-selesai" class="tombol-popup oke-popup">Selesai</button>
      </div>
    <!-- </form> -->
    </div>

    @endforeach

  </div>

</body>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const modal = document.getElementById("modal-tambah-durasi");
    const datetimeInput = document.getElementById("datetime");
    const form = document.getElementById("form-tambah-durasi");

    // Tombol Batal
    const cancelButton = document.getElementById("btn-batal");

    // Fungsi untuk menutup modal
    function closeModal() {
      modal.style.display = "none"; // Sembunyikan modal
      datetimeInput.value = ""; // Reset input datetime
    }

    // Event listener untuk tombol Tambah Durasi
    document.querySelectorAll(".btn-tambah-durasi").forEach(button => {
      button.addEventListener("click", function() {
        const orderId = this.getAttribute("data-order-id");
        const currentEndDate = this.getAttribute("data-current-end-date"); // Ambil tanggal_selesai dari atribut
        document.getElementById("order-id").value = orderId;
        datetimeInput.min = currentEndDate; // Set tanggal minimum

        modal.style.display = "block"; // Tampilkan modal
      });
    });

    // Validasi saat submit form
    form.addEventListener("submit", function(event) {
      const selectedDate = new Date(datetimeInput.value);
      const minDate = new Date(datetimeInput.min);

      if (selectedDate < minDate) {
        event.preventDefault();
        alert("Tanggal baru harus lebih besar atau sama dengan tanggal sebelumnya.");
      }
    });

    // Event listener untuk tombol "Batal"
    cancelButton.addEventListener("click", function() {
      closeModal(); // Panggil fungsi untuk menutup modal
    });

    // Menutup modal ketika klik di luar modal (opsional)
    window.addEventListener("click", function(event) {
      if (event.target === modal) {
        closeModal(); // Panggil fungsi untuk menutup modal
      }
    });
  });
</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("modal-konfirmasi-selesai");
  const overlay = document.getElementById("modal-overlay");
  let selectedOrderId = null; // Menyimpan ID pesanan yang dipilih

  // Event listener untuk tombol "Selesai"
  document.querySelectorAll(".btn-selesai").forEach(button => {
    button.addEventListener("click", function () {
      selectedOrderId = this.getAttribute("data-order-id"); // Ambil ID pesanan
      modal.style.display = "block";
      overlay.style.display = "block";
    });
  });

  // Event listener untuk tombol "Ya" di modal
  document.getElementById("btn-ya-selesai").addEventListener("click", function () {
    if (selectedOrderId) {
      // Kirim permintaan update status menggunakan fetch
      fetch(`/pesanan/selesai/${selectedOrderId}`, {
        method: "PUT",
        headers: {
          "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
          "Content-Type": "application/json"
        },
      })

    }
    // Tutup modal
    modal.style.display = "none";
    overlay.style.display = "none";
  });

  // Event listener untuk tombol "Batal" di modal
  document.getElementById("btn-batal-selesai").addEventListener("click", function () {
    modal.style.display = "none";
    overlay.style.display = "none";
  });

  // Tutup modal jika overlay diklik
  overlay.addEventListener("click", function () {
    modal.style.display = "none";
    overlay.style.display = "none";
  });
});
</script>

</html>