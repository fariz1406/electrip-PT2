<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Verifikasi</title>
    <link rel="stylesheet" href="{{ asset('css/admin/verifikasi_detail1.css') }}" />
</head>

<body>
@include('partials.sidebar_admin')
    <div class="container">
    <form action="{{ route('validasi.verifikasi.update', $verifikasi->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

        <h1>Verifikasi Pengguna</h1>

        <div class="card">
            <!-- Bagian Gambar -->
            <div class="image-section">
                <div class="image-container">
                    <img src="{{ asset($verifikasi->foto_ktp) }}" alt="Foto KTP" class="document-img">
                    <p>KTP</p>
                </div>
                <div class="image-container">
                    <img src="{{ asset($verifikasi->foto_sim) }}" alt="Foto SIM" class="document-img">
                    <p>SIM</p>
                </div>
            </div>

            <!-- Bagian Detail Data -->
            <div class="details">
                <p><span>Nama Lengkap:</span> {{ $verifikasi->nama_lengkap }}</p>
                <p><span>NIK:</span> {{ $verifikasi->nik }}</p>
                <p><span>Jenis Kelamin:</span> {{ $verifikasi->kelamin }}</p>
                <p><span>Alamat:</span> {{ $verifikasi->alamat }}</p>
            </div>

            <!-- Bagian Tombol Aksi -->
            <div class="actions">
                <button type="submit" name="status" value="tidak" class="btn reject" id="tidak">✖ Tolak</button>
                <button type="submit" name="status" value="setuju" class="btn approve" id="setuju">✔ Setujui</button>
            </div>
        </div>
    </form>
    </div>
</body>

</html>
