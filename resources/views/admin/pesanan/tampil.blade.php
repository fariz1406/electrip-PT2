</html>

<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>List Verifikasi</title>
  <link rel="stylesheet" href="{{ asset('css/admin/data_pesanan.css') }}">
</head>

<style>
  
  .header {
    background-color: #121212;
    color: white;
    padding: 20px;
    border-radius: 5px;
    margin : 20px;
  }
  
</style>

<body>
  @include('partials.sidebar_admin')

  <div class="container">

    <div class="header">
      <h2>List Pesanan</h2>
    </div>

    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Penyewa</th>
          <th>Kendaraan</th>
          <th>Biaya</th>
          <th>Tanggal Pakai</th>
          <th>Tanggal Selesai</th>
          <th>Status</th>
          <th class="text-align">Detail</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($dataPesanan as $data)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $data->name }}</td>
          <td>{{ $data->nama }}</td>
          <td>Rp. {{ number_format($data->biaya, 0, ',', '.') }}</td>
          <td>{{ $data->tanggal_mulai }}</td>
          <td>{{ $data->tanggal_selesai }}</td>
          <form action="{{ route('pesanan.updateStatus', $data->id) }}" method="POST" id="form-{{ $data->id }}">
            @csrf
            @method('PUT')
            <td>
              <select name="status" class="status-dropdown form-control" data-order-id="{{ $data->id }}" id="status-{{ $data->id }}">
                <option value="" disabled selected>{{ $data->status }}</option>
                <option value="belum_dibayar" {{ $data->status == 'belum_dibayar' ? 'selected' : '' }}>belum dibayar</option>
                <option value="diproses" {{ $data->status == 'diproses' ? 'selected' : '' }}>di proses</option>
                <option value="dikirim" {{ $data->status == 'dikirim' ? 'selected' : '' }}>di kirim</option>
                <option value="dipakai" {{ $data->status == 'dipakai' ? 'selected' : '' }}>di pakai</option>
                <option value="selesai" {{ $data->status == 'selesai' ? 'selected' : '' }}>selesai</option>
              </select>
              <button type="submit" style="display: none;">Update Status</button>
            </td>
            <td class="edit">
              <a href="{{ route('pesanan.detail', $data->id) }}">
                <span class="material-symbols-outlined">edit_square</span>
              </a>
            </td>

            <!-- Modal konfirmasi -->
            <div id="confirmationModal-{{ $data->id }}" class="confirmationModal" style="display:none; position: fixed; top: 40%; left: 50%; transform: translate(-50%, -50%); background: rgba(0, 0, 0, 0.9); padding: 20px; color: white; z-index: 999;">
              <p>Anda yakin ingin mengubah status pesanan menjadi <span id="newStatus-{{ $data->id }}"></span>?</p>
              <button onclick="confirmUpdate({{ $data->id }})">Setuju</button>
              <button onclick="cancelUpdate({{ $data->id }})">Tidak</button>
            </div>
          </form>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</body>
<script>
  document.querySelectorAll('.status-dropdown').forEach(function(selectElement) {
    selectElement.addEventListener('change', function() {
      const status = this.value;
      const statusText = this.options[this.selectedIndex].text;
      const orderId = this.getAttribute('data-order-id'); // Mendapatkan ID order dari dropdown

      // Tampilkan modal konfirmasi untuk pesanan yang sesuai
      document.getElementById('newStatus-' + orderId).innerText = statusText;
      document.getElementById('confirmationModal-' + orderId).style.display = 'block';

      // Menangani tombol "Ya"
      window.confirmUpdate = function(orderId) {
        const form = document.getElementById('form-' + orderId);
        if (form) {
          form.submit(); // Kirimkan form yang terhubung dengan dropdown ini
        }
      };

      // Menangani tombol "Tidak"
      window.cancelUpdate = function(orderId) {
        document.getElementById('confirmationModal-' + orderId).style.display = 'none'; // Sembunyikan modal
        selectElement.value = ''; // Reset dropdown jika dibatalkan
      };
    });
  });
</script>

</html>