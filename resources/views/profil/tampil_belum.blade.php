<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Profil</title>
    <link rel="stylesheet" href="{{ asset('css/profil/profil.css') }}" />
</head>

<body>

  @include('partials.navbar')
  @include('partials.sidebar')

  <div class="profile-container">

    <div class="profile-header">
      <img src="{{ asset('img/Profile_user.png') }}" alt="Foto Profil" class="profile-photo"/>
      <h1 class="profile-name">{{ $user->name }}</h1>
      <p class="profile-role">{{ $user->email }}</p>
    </div>
    <div class="profile-info">
    <h1 class="profile-name" style="text-align: center;">Profil Kosong</h1>

    </div>
    <div class="profile-actions">
      <a href="{{route('profil.tambah')}}"><button class="btn-edit">Buat Profil</button></a>
    </div>

  </div>
</body>

</html>