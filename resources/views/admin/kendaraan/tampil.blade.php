<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>List Kendaraan</title>
  <link rel="stylesheet" href="{{ asset('css/admin/data_kendaraan.css') }}">
</head>
<style>
  
  .header {
    background-color: #121212;
    color: white;
    padding: 20px;
    border-radius: 5px;
    margin : 10px 20px;
  }
  
</style>
<body>
  @include('partials.sidebar_admin')
  <div class="container">

  <div class="header">
      <h2>List Kendaraan</h2>
    </div>

    <a href="{{route('testing')}}"><button class="button-9" role="button">Tambah Kendaraan</button></a>
    <table style="margin-bottom: 30px;">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama / Merk</th>
          <th>Kategori</th>
          <th>Harga</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>



      @foreach($kendaraan as $data)
      <tbody>
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $data->nama }}</td>
          @if($data->kategori_id == '1')
          <td>Mobil</td>
          @else
          <td>Motor</td>
          @endif
          <td>{{ $data->harga }}</td>
          <td>{{ $data->status }}</td>
          <td>
            <a href="{{ route('kendaraan.edit', $data->id) }}">Edit</a>
            <form action="{{ route('kendaraan.delete', $data->id) }}" method="POST" onsubmit="return confirmDelete()">
              @csrf
              <button type="submit" style="background-color: #ffc107; color: black; padding: 5px; border-radius: 20%;">Hapus</button>
            </form>
          </td>
        </tr>
      </tbody>
      @endforeach
    </table>
  </div>

  <script>
    function confirmDelete() {
      return confirm('Apakah Anda yakin ingin menghapus kendaraan ini?');
    }
  </script>
</body>

</html>
