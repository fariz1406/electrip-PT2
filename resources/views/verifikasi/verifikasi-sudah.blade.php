<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<style>
    /* Background umum dan kontainer utama */
    body {
        font-family: Arial, sans-serif;
        background-color: #121212;
        color: white;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .container {
        background: #FFFFFF;
        width: 100%;
        max-width: 500px;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        border-left: 5px solid #FFC107;
        /* Highlight border kiri */
    }

    /* Judul Halaman */
    .container h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #343A40;
        /* Warna hitam sidebar */
        font-size: 24px;
        font-weight: bold;
    }

    /* Input Form */
    .input-text-design {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }

    /* Label */
    label {
        display: block;
        margin-top: 10px;
        font-size: 14px;
        color: #343A40;
    }

    /* Tombol Submit */
    .btn {
        display: block;
        width: 100%;
        padding: 10px;
        margin-top: 15px;
        background-color: #FFC107;
        color: #FFFFFF;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        text-align: center;
        font-weight: bold;
    }

    .btn:hover {
        background-color: #E0A800;
        /* Warna kuning lebih gelap */
    }

    /* Notifikasi */
    .alert {
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 5px;
        font-size: 14px;
        font-weight: bold;
    }

    .verif {
        margin-left: 320px;

    }

    .alert-success {
        background-color: #D4EDDA;
        color: #155724;
        border: 1px solid #C3E6CB;
    }

    .alert-error {
        background-color: #F8D7DA;
        color: #721C24;
        border: 1px solid #F5C6CB;
    }


    /* Sidebar */

    /* Warna tulisan di sidebar */
</style>

<body>
    @include('partials.navbar')
    @include('partials.sidebar')

@if($dataAda && $dataAda->validasi == 'setuju')
    <p class="verif">Akun anda sudah terverifikasi</p>
@elseif($dataAda)
    <p class="verif">Anda sudah melakukan verifikasi. Mohon menunggu Admin untuk menyetujui</p>
@else
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

        <div class="input7">
            <label for="foto_sim">Foto SIM</label>
            <input type="file" name="foto_sim" required>
        </div>

        <button type="submit" class="btn btn-primary">Kirim Verifikasi</button>
    </form>
@endif
</body>

</html>