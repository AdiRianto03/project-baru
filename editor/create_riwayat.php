<?php
include 'database.php';

// cek ID user diambil dari URL
if (!isset($_GET['id'])) {
    die("ID pengguna tidak ditemukan.");
}

$user_id = $_GET['id']; // get ID user dari parameter URL

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pendidikan = $_POST['pendidikan'];
    $tahun = $_POST['tahun'];
    $nama_sekolah = $_POST['nama_sekolah'];

    // query buat create data riwayat_pendidikan
    $sql = "INSERT INTO riwayat_pendidikan (user_id, pendidikan, tahun, nama_sekolah) 
            VALUES ('$user_id', '$pendidikan', '$tahun', '$nama_sekolah')";

    if ($conn->query($sql) === TRUE) {
        header("Location: detail.php?id=" . $user_id); // kembali ke halaman detail dengan ID user
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Riwayat Pendidikan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Tambah Riwayat Pendidikan</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="pendidikan" class="form-label">Pendidikan</label>
                <input type="text" class="form-control" id="pendidikan" name="pendidikan" required>
            </div>
            <div class="mb-3">
                <label for="tahun" class="form-label">Tahun</label>
                <input type="number" class="form-control" id="tahun" name="tahun" required>
            </div>
            <div class="mb-3">
                <label for="nama_sekolah" class="form-label">Nama Sekolah/Kampus</label>
                <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="detail.php?id=<?= $user_id ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>
