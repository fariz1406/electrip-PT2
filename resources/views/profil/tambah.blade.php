<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Buat Profil</title>
  <link rel="stylesheet" href="{{ asset('css/profil/profil_input.css') }}" />
</head>

<body>

  @include('partials.navbar')
  @include('partials.sidebar')

  <div class="container">
    <h2>Profil</h2>
    <form action="{{ route('profil.submit') }}" method="post" enctype="multipart/form-data">
    @csrf

      <div class="wrapper-img">
        <div class="image-box">
          <img src="{{ asset('img/Profile_user.png') }}" />
          <input type="file" name="foto_profil">
        </div>
      </div>

      <div class="input1">
      <input type="text" placeholder="nama pengguna" value="{{ Auth::user()->name }}" readonly />
      </div>

      <div class="input2">
        <input type="text" name="telepon" placeholder="nomor telepon" required />
      </div>

      <div class="input3">
        <textarea id="deskripsi" name="deskripsi" cols="40" rows="6" placeholder="Deskripsi"></textarea>
      </div>

      <div class="Button">
        <button class="batal">Batal</button>
        <button type="submit" class="simpan" name="simpan">Simpan</button>
      </div>
    </form>
  </div>

</body>

</html>