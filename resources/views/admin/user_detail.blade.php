<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Detail Pengguna</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #0d1117;
            color: #e6edf3;
            font-family: 'Segoe UI', sans-serif;
        }

        .main-wrapper {
            display: flex;
        }

        /* Sidebar di-handle oleh partials.sidebar_admin */
        .content {
            margin-left: 25%;
            width: 75%;
            padding: 40px 30px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
        }

        .profile-pic {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #30363d;
            margin-bottom: 15px;
        }

        .card {
            background-color: #161b22;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
        }

        .details p {
            font-size: 16px;
            margin: 10px 0;
        }

        .details span {
            font-weight: bold;
            color: #8b949e;
            display: inline-block;
            width: 160px;
        }

        .document-section {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 30px;
        }

        .document-img {
            width: 324px;
            height: 204px;
            object-fit: cover;
            border: 2px solid #30363d;
            border-radius: 8px;
        }

        .doc-title {
            text-align: center;
            margin-top: 8px;
            color: #c9d1d9;
            font-size: 14px;
        }

        .not-verified {
            background-color: #2c2f33;
            color: #f87171;
            /* merah lembut */
            padding: 30px;
            border-radius: 10px;
            border-left: 6px solid #dc2626;
            text-align: center;
            margin-bottom: 30px;
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.1);
        }

        .not-verified .icon {
            font-size: 50px;
            color: #dc2626;
            margin-bottom: 10px;
        }

        .not-verified h3 {
            margin: 0;
            font-size: 24px;
            color: #f87171;
        }

        .not-verified p {
            color: #d1d5db;
            font-size: 14px;
        }


        @media (max-width: 1024px) {
            .content {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .document-img {
                width: 100%;
                height: auto;
            }

            .details span {
                width: 100%;
                display: block;
                margin-bottom: 5px;
            }
        }
    </style>
</head>

<body>

    <div class="main-wrapper">
        @include('partials.sidebar_admin')

        <div class="content">
            <div class="container">
                <div class="header">
                    @if($data->foto_profil == null)
                    <img src="{{ asset('img/Profile_user.png') }}" alt="Foto Profil" class="profile-pic" />
                    @else
                    <img src="{{ asset('img/profil/' . $data->foto_profil) }}" alt="Foto Profil" class="profile-pic">
                    @endif
                    <h2>{{ $data->name }}</h2>
                    <p>{{ $data->email }}</p>
                    <p>{{ $data->telepon }}</p>
                </div>

                <div class="card">
                    <div class="details">
                        @if($data->validasi == "setuju")
                        <p><span>Nama Lengkap:</span> {{ $data->nama_lengkap }}</p>
                        <p><span>NIK:</span> {{ $data->nik }}</p>
                        <p><span>Jenis Kelamin:</span> {{ $data->kelamin }}</p>
                        <p><span>Tanggal Lahir:</span> {{ $data->tanggal_lahir }}</p>
                        <p><span>Alamat:</span> {{ $data->alamat }}</p>
                    </div>
                    <div class="document-section">
                        <div>
                            <img src="{{ asset($data->foto_ktp) }}" alt="Foto KTP" class="document-img">
                            <div class="doc-title">Foto KTP</div>
                        </div>
                        <div>
                            <img src="{{ asset($data->foto_sim) }}" alt="Foto SIM" class="document-img">
                            <div class="doc-title">Foto SIM</div>
                        </div>
                    </div>
                    @else
                    <div class="not-verified">
                        <div class="icon">✖</div>
                        <h3>Belum Terverifikasi</h3>
                        <p>Pengguna ini belum melakukan verifikasi dokumen atau belum disetujui oleh admin.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</body>

</html>