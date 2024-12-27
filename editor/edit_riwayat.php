<?php
include 'database.php';

// cek parameter ID ada di URL
if (!isset($_GET['id'])) {
    die("Parameter ID tidak ditemukan.");
}

$id = $_GET['id'];

// query buat dapatin data riwayat_pendidikan berdasarkan ID
$sql_riwayat = "SELECT * FROM riwayat_pendidikan WHERE id = '$id'";
$result_riwayat = $conn->query($sql_riwayat);

if ($result_riwayat->num_rows == 0) {
    die("Data riwayat pendidikan tidak ditemukan.");
}

$riwayat = $result_riwayat->fetch_assoc();

// proses update data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pendidikan = $_POST['pendidikan'];
    $tahun = $_POST['tahun'];
    $nama_sekolah = $_POST['nama_sekolah'];
    $user_id = $riwayat['user_id']; // ambil user_id dari data riwayat

    // query memperbarui data riwayat_pendidikan
    $sql_update = "UPDATE riwayat_pendidikan 
                   SET pendidikan = '$pendidikan', tahun = '$tahun', nama_sekolah = '$nama_sekolah' 
                   WHERE id = '$id'";

    if ($conn->query($sql_update) === TRUE) {
        header("Location: detail.php?id=$user_id"); // kembali ke halaman detail
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Riwayat Pendidikan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Riwayat Pendidikan</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="pendidikan" class="form-label">Pendidikan</label>
                <input type="text" class="form-control" id="pendidikan" name="pendidikan" value="<?= $riwayat['pendidikan'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="tahun" class="form-label">Tahun</label>
                <input type="text" class="form-control" id="tahun" name="tahun" value="<?= $riwayat['tahun'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="nama_sekolah" class="form-label">Nama Sekolah/Kampus</label>
                <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah" value="<?= $riwayat['nama_sekolah'] ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="detail.php?id=<?= $riwayat['user_id'] ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>
