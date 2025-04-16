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

    <form action="{{ route('verifikasi.update', $verifikasi->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="input1">
        <input class="input-text-design" name="nama_lengkap" type="text" required placeholder="Nama Lengkap" value="{{ old('nama_lengkap', $verifikasi->nama_lengkap) }}" />
        @error('nama_lengkap')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="input2">
        <input class="input-text-design" name="nik" type="text" required placeholder="NIK" value="{{ old('nik', $verifikasi->nik) }}" />
        @error('nik')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="input2">
        <input class="input-text-design" name="alamat" type="text" required placeholder="Alamat" value="{{ old('alamat', $verifikasi->alamat) }}" />
        @error('alamat')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="input5">
        <label for="tanggal_lahir">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" required value="{{ old('tanggal_lahir', $verifikasi->tanggal_lahir) }}" />
        @error('tanggal_lahir')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="jenisK">
        <label class="Jenisk"><b>Jenis Kelamin</b></label><br />
        <input type="radio" name="kelamin" value="pria" {{ old('kelamin', $verifikasi->kelamin) == 'pria' ? 'checked' : '' }} required /> Pria<br />
        <input type="radio" name="kelamin" value="wanita" {{ old('kelamin', $verifikasi->kelamin) == 'wanita' ? 'checked' : '' }} required /> Wanita<br />
        @error('kelamin')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="input6">
        <label for="foto_ktp">Foto KTP</label>
        <input type="file" name="foto_ktp">
        @error('foto_ktp')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="input6">
        <label for="foto_sim">Foto SIM</label>
        <input type="file" name="foto_sim">
        @error('foto_sim')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="radio">
        <input type="radio" name="agreement" value="agree" required /> saya telah menyetujui peraturan dan ketentuan yang berlaku<br />
        @error('agreement')
        <div class="error">{{ $message }}</div>
        @enderror
    </div>

    <div class="Button">
        <button type="submit" class="simpan">Kirim Verifikasi</button>
    </div>
</form>
  </div>
</body>

</html>