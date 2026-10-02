<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Harga</title>
</head>
<body>
    <h2>Form Edit Data Harga</h2>
    <form action="process_edit.php" method="post">
        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
        <label for="tanggal">Tanggal:</label><br>
        <input type="date" id="tanggal" name="tanggal" value="<?php echo $tanggal; ?>"><br>
        
        <label for="Harga">Harga:</label><br>
        <input type="text" id="Harga" name="Harga" value="<?php echo $harga; ?>"><br>
        
        <label for="PT">PT:</label><br>
        <select id="PT" name="PT">
            <option value="PT Maju Jaya" <?php if ($pt == "PT Maju Jaya") echo "selected"; ?>>PT Maju Jaya</option>
            <option value="PT Sentosa Abadi" <?php if ($pt == "PT Sentosa Abadi") echo "selected"; ?>>PT Sentosa Abadi</option>
            <option value="PT Berkah Makmur" <?php if ($pt == "PT Berkah Makmur") echo "selected"; ?>>PT Berkah Makmur</option>
            <option value="PT Sejahtera Bersama" <?php if ($pt == "PT Sejahtera Bersama") echo "selected"; ?>>PT Sejahtera Bersama</option>
            <option value="PT Cahaya Indah" <?php if ($pt == "PT Cahaya Indah") echo "selected"; ?>>PT Cahaya Indah</option>
        </select><br>
        
        <label for="Kode_PT">Kode PT:</label><br>
        <input type="text" id="Kode_PT" name="Kode_PT" value="<?php echo $kode_pt; ?>" readonly><br><br>
        
        <input type="submit" value="Submit">
    </form>

    <script>
        // Mendapatkan elemen select PT dan input Kode PT
        var ptSelect = document.getElementById('PT');
        var kodePtInput = document.getElementById('Kode_PT');

        // Menambahkan event listener untuk memperbarui nilai Kode PT saat opsi PT berubah
        ptSelect.addEventListener('change', function() {
            // Mendapatkan nilai opsi PT yang dipilih
            var selectedOption = ptSelect.options[ptSelect.selectedIndex].value;
            
            // Mendefinisikan objek untuk memetakan nilai Kode PT berdasarkan opsi PT
            var kodePtMap = {
                "PT Maju Jaya": "MJ001",
                "PT Sentosa Abadi": "SA001",
                "PT Berkah Makmur": "BM001",
                "PT Sejahtera Bersama": "SB001",
                "PT Cahaya Indah": "CI001"
            };

            // Mengatur nilai Kode PT sesuai dengan opsi PT yang dipilih
            kodePtInput.value = kodePtMap[selectedOption];
        });
    </script>
     <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>Prediksi Harga Komoditi Pertanian Jagung</h5>
                    <p>Proyek prediksi harga jagung ini bertujuan untuk memberikan informasi mengenai harga jagung di berbagai daerah, membantu petani dan pedagang dalam mengambil keputusan.</p>
                </div>
                <div class="col-md-4">
                    <h5>Kontak Kami</h5>
                    <p>Email: info@prediksihargajagung.com</p>
                    <p>Telepon: +62 123 456 789</p>
                </div>
                <div class="col-md-4">
                    <h5>Ikuti Kami</h5>
                    <ul class="list-unstyled">
                        <li><a href="#"><i class="fab fa-facebook"></i> Facebook</a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i> Twitter</a></li>
                        <li><a href="#"><i class="fab fa-instagram"></i> Instagram</a></li>
                        <li><a href="#"><i class="fab fa-linkedin"></i> LinkedIn</a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <p class="text-center mb-0">&copy; 2024 Prediksi Harga Komoditi Pertanian Jagung. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
