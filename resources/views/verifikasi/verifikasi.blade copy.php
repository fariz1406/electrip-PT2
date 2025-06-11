<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verifikasi</title>
  <link rel="stylesheet" href="{{ asset('css/verifikasi.css') }}" />
</head>


<body>
  
  @include('includes.pesan_peringatan')
  @include('partials.navbar')
  @include('partials.sidebar')

  <div class="container">

    @if(session('error'))
    <div class="pesan-peringatan" style="background-color: red;">
      <strong>{{ session('error') }}</strong>
    </div>
    @endif

    @if(session('success'))
    <div class="pesan-peringatan" style="background-color: #008e37;">
      <strong>{{ session('success') }}</strong>
    </div>
    @endif
    <h2>Verifikasi</h2>



    <form action="{{ route('verifikasi.store') }}" method="post" enctype="multipart/form-data">
      @csrf

      <div class="input1">
        <input class="input-text-design" name="nama_lengkap" type="text" required placeholder="Nama Lengkap" value="{{ old('nama_lengkap', Auth::user()->nama) }}" />
      </div>

      <div class="input2">
        <input class="input-text-design" name="nik" type="text" required placeholder="NIK" value="{{ old('nik') }}" />
      </div>

      <div class="input2">
        <input class="input-text-design" name="alamat" type="text" required placeholder="Alamat" value="{{ old('alamat') }}" />
      </div>

      <div class="input5">
        <label for="tanggal_lahir">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" required value="{{ old('tanggal_lahir') }}" />
      </div>

      <div class="jenisK">
        <label class="Jenisk"><b>Jenis Kelamin</b></label><br />
        <input type="radio" name="kelamin" value="pria" required /> Pria<br />
        <input type="radio" name="kelamin" value="wanita" required /> Wanita<br />
      </div>

      <div class="input6">
        <label for="foto_ktp">Foto KTP</label>
        <input type="file" name="foto_ktp" required>
      </div>

      <div class="input6">
        <label for="foto_sim">Foto SIM</label>
        <input type="file" name="foto_sim" required>
      </div>

      <div class="radio">
        <input type="radio" name="agreement" value="agree" require /> saya
        telah menyetujui peraturan dan ketentuan yang berlaku<br />
      </div>

      <!-- Tombol Submit -->
      <div class="Button">
        <button type="simpan" class="simpan">Kirim Verifikasi</button>
      </div>
    </form>
  </div>
</body>

</html>