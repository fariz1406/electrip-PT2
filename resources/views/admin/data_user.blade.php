<!DOCTYPE html>
<html lang="en">

<head>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>List Pengguna</title>
  <link rel="stylesheet" href="{{ asset('css/admin/data_user.css')}}">
</head>
<style>
  .header {
    background-color: #121212;
    color: white;
    padding: 20px;
    border-radius: 5px;
    margin: 20px;
  }
</style>

<body>
  @include('partials.sidebar_admin')

  <div class="container">

    <div class="header">
      <h2>List Semua Pengguna</h2>
    </div>

    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Role</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Detail</th>
        </tr>
      </thead>
      @foreach($user as $data)
      <tbody>
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $data->role }}</td>
          <td>{{ $data->name }}</td>
          <td>{{ $data->email }}</td>
          <td class="edit">
            <a href="{{ route('users.detail', $data->id) }}">
              <span class="material-symbols-outlined">edit_square</span>
            </a>
          </td>

        </tr>
      </tbody>
      @endforeach
    </table>
  </div>

  <div class="tombol"><a href="proses_sediakan.php"><img src="../assets/plus.png" alt=""></a></div>

</body>

</html>