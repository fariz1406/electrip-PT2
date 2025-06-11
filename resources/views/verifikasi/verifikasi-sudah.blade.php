<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html,
    body {
        height: 100%;
        font-family: sans-serif;
        background-color: #121212;
        color: #f0f0f0;
    }

    body {
        display: flex;
        overflow: hidden;
    }

    .container {
        margin-left: 25%;
        margin-top: 50px;
        padding: 10px;
        width: 75%;
        height: calc(100vh - 50px);
        overflow-y: auto;
    }

    h2 {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .input1,
    .input2,
    .input3,
    .input4,
    .input6,
    .jenisK,
    .radio,
    .Button {
        margin-bottom: 10px;
    }

    input[type="text"],
    input[type="date"],
    input[type="file"],
    textarea {
        width: 100%;
        padding: 6px;
        font-size: 12px;
        background-color: #1e1e1e;
        border: 1px solid #444;
        color: #fff;
        border-radius: 3px;
    }

    .input-text-design {
        width: 100%;
        padding: 6px;
        font-size: 12px;
        background-color: #1e1e1e;
        border: 1px solid #444;
        color: #fff;
        border-radius: 3px;
    }

    textarea {
        resize: vertical;
    }

    label {
        font-size: 13px;
        margin-bottom: 4px;
        display: inline-block;
    }

    .simpan {
        margin-top: 20px;
        padding: 6px 12px;
        font-size: 13px;
        background-color: #ffcc00;
        border: none;
        color: black;
        border-radius: 3px;
        cursor: pointer;
    }

    .simpan:hover {
        background-color: rgb(128, 104, 12);
    }

    .verifikasi-box {
        padding: 12px 16px;
        margin: 10px 0;
        border-radius: 6px;
        font-size: 14px;
        line-height: 1.5;
        color: #ffffff;
    }

    .verifikasi-menunggu {
        background-color:rgb(51, 54, 64);
        /* biru gelap */
        border-left: 5px solidrgb(57, 59, 66);
    }

    .verifikasi-selesai {
        background-color: #ffcc00;
        color: black;
        /* hijau tua */
        border-left: 5pxrgb(145, 116, 0);
    }
</style>

<body>
    @include('partials.navbar')
    @include('partials.sidebar')

    <div class="container">
        @if($dataAda && $dataAda->validasi == 'setuju')
        <div class="verifikasi-box verifikasi-selesai">
            <strong>Anda sudah melakukan verifikasi.</strong>
        </div>
        @elseif($dataAda)
        <div class="verifikasi-box verifikasi-menunggu">
            <strong>Anda sudah melakukan verifikasi.</strong><br>
            Mohon menunggu Admin untuk menyetujui.
        </div>
        @else
        <form action="{{ route('verifikasi.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="input1">
                <input class="input-text-design" name="nama_lengkap" type="text" required placeholder="Nama Lengkap" value="{{ old('nama_lengkap', Auth::user()->nama) }}" />
            </div>

            <div class="input2">
                <input class="input-text-design" name="nik" type="text" required placeholder="NIK" value="{{ old('nik') }}" />
            </div>

            <div class="input3">
                <textarea name="alamat" cols="40" rows="6" placeholder="Alamat" value="{{ old('alamat') }}"></textarea>
            </div>

            <div class="input4">
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
    </div>
</body>

</html>