# Program Simulasi Transaksi Toko Online
# Nama: [Fakhri afif]
# NIM: [312310632]
<?php
// Data Produk
$produk = [
    "P001" => ["nama" => "Kemeja", "harga" => 150000, "stok" => 10],
    "P002" => ["nama" => "Celana", "harga" => 200000, "stok" => 5],
    "P003" => ["nama" => "Sepatu", "harga" => 500000, "stok" => 7],
];

function hitung_diskon($total) {
    if ($total > 500000) {
        return $total * 0.10;
    } elseif ($total > 250000) {
        return $total * 0.05;
    }
    return 0;
}

function tampilkan_struk($nama_produk, $jumlah, $total, $diskon, $pajak, $total_bayar) {
    echo "<h2>STRUK TRANSAKSI</h2>";
    echo "Nama Produk: $nama_produk<br>";
    echo "Jumlah: $jumlah<br>";
    echo "Total Harga: Rp$total<br>";
    echo "Diskon: Rp$diskon<br>";
    echo "Pajak: Rp$pajak<br>";
    echo "Total yang Harus Dibayar: Rp$total_bayar<br>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_produk = strtoupper($_POST['id_produk']);
    $jumlah = (int)$_POST['jumlah'];

    if (!isset($produk[$id_produk])) {
        echo "Produk tidak ditemukan.<br>";
        exit;
    }

    if ($jumlah > $produk[$id_produk]['stok']) {
        echo "Maaf, stok untuk {$produk[$id_produk]['nama']} tidak mencukupi.<br>";
        exit;
    }

    // Hitung Total Harga
    $total_harga = $produk[$id_produk]['harga'] * $jumlah;

    // Terapkan Diskon
    $diskon = hitung_diskon($total_harga);
    $total_setelah_diskon = $total_harga - $diskon;

    // Hitung Pajak
    $pajak = $total_setelah_diskon * 0.10;
    $total_bayar = $total_setelah_diskon + $pajak;

    // Kurangi Stok
    $produk[$id_produk]['stok'] -= $jumlah;

    // Tampilkan Struk
    tampilkan_struk($produk[$id_produk]['nama'], $jumlah, $total_harga, $diskon, $pajak, $total_bayar);
} else {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Simulasi Transaksi</title>
    </head>
    <body>
        <h1>Selamat Datang di Toko Online!</h1>
        <form method="POST">
            <label for="id_produk">Masukkan ID Produk:</label><br>
            <input type="text" name="id_produk" id="id_produk" required><br><br>
            <label for="jumlah">Masukkan Jumlah:</label><br>
            <input type="number" name="jumlah" id="jumlah" required><br><br>
            <button type="submit">Proses</button>
        </form>
    </body>
    </html>
    <?php
}
?>
