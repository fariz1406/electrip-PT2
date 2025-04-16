<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profil</title>
  <link rel="stylesheet" href="{{ asset('css/profil.css') }}" />
</head>

<body>

  @include('partials.navbar')
  @include('partials.sidebar')

  <div class="wrapper2"></div>
  <div class="profile-container">

    <div class="profile-header">
      <img src="{{ asset('img/profil/'. $profil->foto_profil) }}" alt="Foto Profil" class="profile-photo"/>
      <h1 class="profile-name">{{ $user->name }}</h1>
      <p class="profile-role">Pengguna</p>
    </div>
    <div class="profile-info">
      <h2>Informasi Akun</h2>
      <p><strong>Email:</strong> {{ $user->email }}</p>
      <p><strong>Telepon:</strong> {{ $profil->telepon }}</p>
      <p class="profile-description">"{{ $profil->deskripsi }}"</p>
    </div>
    <div class="profile-actions">
      <a href="{{ route('profil.edit', $profil->id) }}"><button class="btn-edit">Edit Profil</button></a>
    </div>

  </div>
</body>

</html>