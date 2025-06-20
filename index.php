<?php
session_start();
$db = new SQLite3('db/jamuku.sqlite');

// Ambil semua bahan
$bahan = $db->query("SELECT * FROM bahan");

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

// Proses tambah ke keranjang
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_bahan'])) {
    $id = $_POST['id_bahan'];
    $jumlah = intval($_POST['jumlah'] ?? 1);

    if (isset($_SESSION['keranjang'][$id])) {
        $_SESSION['keranjang'][$id] += $jumlah;
    } else {
        $_SESSION['keranjang'][$id] = $jumlah;
    }

    header("Location: keranjang.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Jamuku - Pilih Bahan</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Jamuku - Racik Sendiri</h1>
    <table border="1">
        <tr>
            <th>Nama</th>
            <th>Jenis</th>
            <th>Deskripsi</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $bahan->fetchArray(SQLITE3_ASSOC)) : ?>
        <tr>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td><?= $row['jenis'] ?></td>
            <td><?= $row['deskripsi'] ?></td>
            <td>Rp<?= number_format($row['harga']) ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="id_bahan" value="<?= $row['id'] ?>">
                    <input type="number" name="jumlah" value="1" min="1" required>
            </td>
            <td>
                    <button type="submit">Tambah</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <p><a href="keranjang.php">Lihat Keranjang</a></p>
</body>
</html>
