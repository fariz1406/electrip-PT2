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

        <form action="{{ route('kendaraan.submit') }}" method="post" enctype="multipart/form-data">
            @csrf
        <!-- Categories Section -->
        <div class="categories">
            <div class="category" data-value="1" onclick="selectCategory(this)">
                <span class="icon">🚗</span>
                <div class="text">
                    <h3>Mobil</h3>
                </div>
            </div>
            <div class="category active" data-value="2" onclick="selectCategory(this)">
                <span class="icon">🏍</span>
                <div class="text">
                    <h3>Sepeda Motor</h3>
                </div>
            </div>
        </div>

            <!-- Product Detail Form -->
            <div class="form-section">
                <h2>Detail Kendaraan</h2>
                <!-- Hidden Input for Category -->
                <input type="hidden" name="kategori_id" id="selected_category" value="1">

                <div class="form-group">
                    <label for="foto">Foto Kendaraan</label>
                    <input type="file" name="foto" id="foto">
                </div>

                <div class="form-group">
                    <label for="nama">Nama Kendaraan</label>
                    <input type="text" name="nama" id="nama" placeholder="Nama kendaraan" required>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" cols="161" rows="4" placeholder="Deskripsi / Spesifikasi"></textarea>
                </div>

                <div class="form-group">
                    <label for="harga">Harga Sewa (per hari)</label>
                    <input type="number" name="harga" id="harga" placeholder="Rp." required>
                </div>

                <div class="form-group">
                    <label for="tahun">Tahun Kendaraan</label>
                    <input type="number" name="tahun" id="tahun" placeholder="Tahun kendaraan">
                </div>

                <div class="form-group">
                    <label for="stnk">Nomor STNK</label>
                    <input type="file" name="stnk" id="stnk">
                </div>


                <button type="submit" name="simpan">Tambah Kendaraan</button>
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