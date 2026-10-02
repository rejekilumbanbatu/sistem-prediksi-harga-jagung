<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Tambah Data Harga</title>
    <!-- CSS Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-4">Form Tambah Data Harga</h2>
        <form action="process_tambah.php" method="POST">
            <div class="form-group">
                <label for="tanggal">Tanggal:</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="form-group">
                <label for="Harga">Harga:</label>
                <input type="text" class="form-control" id="Harga" name="Harga" required>
            </div>
            <div class="form-group">
                <label for="PT">PT:</label>
                <select class="form-control" id="PT" name="PT" required>
                    <option value="PT Maju Jaya">PT Maju Jaya</option>
                    <option value="PT Sentosa Abadi">PT Sentosa Abadi</option>
                    <option value="PT Berkah Makmur">PT Berkah Makmur</option>
                    <option value="PT Sejahtera Bersama">PT Sejahtera Bersama</option>
                    <option value="PT Cahaya Indah">PT Cahaya Indah</option>
                </select>
            </div>
            <div class="form-group">
                <label for="Kode_PT">Kode PT:</label>
                <input type="text" class="form-control" id="Kode_PT" name="Kode_PT" readonly required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <!-- Script -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
</body>
</html>
