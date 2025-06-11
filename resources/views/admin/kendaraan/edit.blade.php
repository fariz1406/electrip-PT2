<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kendaraan</title>
    <link rel="stylesheet" href="{{ asset('css/admin/input_kendaraan.css') }}">

</head>

<body>

    @include('partials.sidebar_admin')

    <div class="container">

        <form action="{{ route('kendaraan.update', $kendaraan->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @if($kendaraan->kategori_id == '1')
            <div class="categories">
                <div class="category active">
                    <span class="icon">🚗</span>
                    <div class="text">
                        <h3>Mobil</h3>
                    </div>
                </div>
                <div class="category">
                    <span class="icon">🏍</span>
                    <div class="text">
                        <h3>Sepeda Motor</h3>
                    </div>
                </div>
            </div>
            @else
            <div class="categories">
                <div class="category">
                    <span class="icon">🚗</span>
                    <div class="text">
                        <h3>Mobil</h3>
                    </div>
                </div>
                <div class="category active">
                    <span class="icon">🏍</span>
                    <div class="text">
                        <h3>Sepeda Motor</h3>
                    </div>
                </div>
            </div>
            @endif

            <!-- Product Detail Form -->
            <div class="form-section">
                <h2>Detail Kendaraan</h2>
                <!-- Hidden Input for Category -->
                <input type="hidden" name="kategori" value="{{ $kendaraan->kategori_id }}">

                <div class="form-group">
                    <label for="foto">Foto Kendaraan</label>
                    <input type="file" name="foto" id="foto">
                </div>

                <div class="form-group">
                    <label for="nama">Nama Kendaraan</label>
                    <input type="text" name="nama" value="{{ $kendaraan->nama }}" class="input-desain" placeholder="{{ $kendaraan->nama }}"><br>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" cols="161" rows="4" placeholder="Deskripsi / Spesifikasi">{{ $kendaraan->deskripsi }}</textarea>
                </div>

                <div class="form-group">
                    <label for="harga">Harga Sewa (per hari)</label>
                    <input type="number" name="harga" value="{{ $kendaraan->harga }}" placeholder="Rp " class="harga">
                </div>

                <div class="form-group">
                    <label for="tahun">Tahun Kendaraan</label>
                    <input type="number" name="tahun" id="tahun" placeholder="Tahun kendaraan">
                </div>

                <div class="form-group">
                    <label for="status_kendaraan">Status Kendaraan:</label>
                    <select name="status" id="status">
                        <option value="tersedia">Tersedia</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>


                <button class="simpan" name="simpan">Edit</button>
            </div>
        </form>
    </div>

</body>
<script>
    function selectCategory(categoryElement) {
        const categories = document.querySelectorAll('.category');
        categories.forEach(category => {
            category.classList.remove('active');
        });
        categoryElement.classList.add('active');
        const selectedValue = categoryElement.getAttribute('data-value');
        document.getElementById('selected_category').value = selectedValue; // Set nilai kategori_id
    }
</script>

</html>