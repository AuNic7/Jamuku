<?php
session_start();
$db = new SQLite3('db/jamuku.sqlite');

$keranjang = $_SESSION['keranjang'] ?? [];
$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Keranjang - Jamuku</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Keranjang Racikan Jamu</h1>
    <?php if (empty($keranjang)) : ?>
        <p>Keranjang kosong.</p>
    <?php else : ?>
        <table border="1">
            <tr>
                <th>Nama</th>
                <th>Harga Satuan</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>
            <?php foreach ($keranjang as $id => $jumlah) :
                $bahan = $db->querySingle("SELECT * FROM bahan WHERE id = $id", true);
                $subtotal = $bahan['harga'] * $jumlah;
                $total += $subtotal;
            ?>
            <tr>
                <td><?= htmlspecialchars($bahan['nama']) ?></td>
                <td>Rp<?= number_format($bahan['harga']) ?></td>
                <td><?= $jumlah ?></td>
                <td>Rp<?= number_format($subtotal) ?></td>
                <td>
                    <a href="tambah.php?id=<?= $id ?>&aksi=tambah">+</a>
                    <a href="tambah.php?id=<?= $id ?>&aksi=kurang">-</a>
                    <a href="hapus.php?id=<?= $id ?>" onclick="return confirm('Hapus bahan ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <h3>Total Belanja: Rp<?= number_format($total) ?></h3>
        <p><a href="index.php">Kembali Pilih Bahan</a></p>
    <?php endif; ?>
</body>
</html>
