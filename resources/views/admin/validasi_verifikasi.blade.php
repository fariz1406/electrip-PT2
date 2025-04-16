<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Verifikasi</title>
    <link rel="stylesheet" href="{{ asset('css/admin/validasi_verifikasi.css') }}">
</head>
<body>
    @include('partials.sidebar_admin')

    <div class="container">


        <hr>

        <h1>List Pengguna Yang Ingin Verifikasi</h1>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID pengguna</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Status</th>
                    <th class="text-align">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($verifikasiList as $index => $verifikasi)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $verifikasi->user_id }}</td>
                        <td>{{ $verifikasi->nama_lengkap }}</td>
                        <td>{{ $verifikasi->kelamin }}</td>
                        <td>{{ $verifikasi->validasi }}</td>
                        <td class="edit">
                            @if($verifikasi->validasi == 'setuju')
                            @else
                            <a href="{{ route('validasi.verifikasi.detail', $verifikasi->id) }}">
                                <span class="material-symbols-outlined">edit_square</span>
                            </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;">Data Verifikasi tidak tersedia</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
