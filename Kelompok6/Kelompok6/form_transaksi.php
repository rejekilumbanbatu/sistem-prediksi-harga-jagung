<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi</title>
</head>
<body>
    <div class="container">
        <h2>Data Transaksi</h2>

        <!-- Form to add a new transaction -->
        <div id="addForm">
            <h3>Tambah Transaksi Baru</h3>
            <form id="transactionForm">
                <!-- Nomor Transaksi -->
                <input type="text" name="nomor_transaksi" id="nomor_transaksi" placeholder="Nomor Transaksi" required readonly><br>
                <!-- Tanggal Pembelian -->
                <input type="date" name="tanggal_pembelian" id="tanggal_pembelian" placeholder="Tanggal Pembelian" required><br>
                <!-- Alamat -->
                <input type="text" name="alamat" placeholder="Alamat" required><br>
                <!-- Nama Barang -->
                <input type="text" name="nama_barang" placeholder="Nama Barang" required><br>
                <!-- Kuantitas -->
                <input type="number" name="kuantitas" placeholder="Kuantitas" required><br>
                <!-- Harga Satuan -->
                <input type="number" step="0.01" name="harga_satuan" placeholder="Harga Satuan" required><br>
                <!-- Total Harga -->
                <input type="number" step="0.01" name="total_harga" placeholder="Total Harga" required><br>
                <!-- Basah/Kering -->
                <select name="basah_kering" required>
                    <option value="Basah">Basah</option>
                    <option value="Kering">Kering</option>
                </select><br>
                <!-- Keterangan -->
                <input type="text" name="keterangan" placeholder="Keterangan" required><br>
                <!-- Penjual -->
                <input type="text" name="penjual" placeholder="Penjual" required><br>
                <!-- Tombol Tambah Transaksi -->
                <input type="submit" value="Tambah Transaksi">
            </form>
        </div>

        <!-- JavaScript -->
        <script>
            // Set Nomor Transaksi secara otomatis
            window.addEventListener('DOMContentLoaded', function() {
                var nomorTransaksiField = document.getElementById('nomor_transaksi');
                var today = new Date();
                var year = today.getFullYear();
                var month = today.getMonth() + 1;
                var day = today.getDate();
                var formattedDate = year + '-' + (month < 10 ? '0' + month : month) + '-' + (day < 10 ? '0' + day : day);
                nomorTransaksiField.value = 'TRX' + formattedDate.replace(/-/g, '') + '-';
            });

            // Set Tanggal Pembelian dengan tanggal saat ini
            window.addEventListener('DOMContentLoaded', function() {
                var tanggalPembelianField = document.getElementById('tanggal_pembelian');
                var today = new Date();
                var year = today.getFullYear();
                var month = today.getMonth() + 1;
                var day = today.getDate();
                var formattedDate = year + '-' + (month < 10 ? '0' + month : month) + '-' + (day < 10 ? '0' + day : day);
                tanggalPembelianField.value = formattedDate;
            });
        </script>
    </div>
</body>
</html>
