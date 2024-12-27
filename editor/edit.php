<?php
    include 'database.php';

    $id = $_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama = $_POST['nama'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $alamat = $_POST['alamat'];
        $deskripsi = $_POST['deskripsi'];

        // Cek jika ada foto baru yang diupload
        if ($_FILES['foto']['name'] != '') {
            $foto = $_FILES['foto']['name'];
            $target_dir = "assets/images/";
            $target_file = $target_dir . basename($foto);
            move_uploaded_file($_FILES['foto']['tmp_name'], $target_file);
        } else {
            // Jika foto tidak diubah, biarkan foto lama
            $sql = "SELECT foto FROM users WHERE id = '$id'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $foto = $row['foto'];
        }

        $sql = "UPDATE users SET nama='$nama', jenis_kelamin='$jenis_kelamin', alamat='$alamat', 
            deskripsi='$deskripsi', foto='$foto' WHERE id='$id'";

        if ($conn->query($sql) === TRUE) {
            header('Location: index.php');
        } else {
            echo "Error: " . $conn->error;
        }
    }

    // Ambil data untuk diedit
    $sql = "SELECT * FROM users WHERE id = '$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Identitas Diri</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
            rel="stylesheet">
    </head>
    <body>
        <div class="container mt-5">
            <h1 class="mb-4">Edit Identitas Diri</h1>
            <form action="edit.php?id=<?= $row['id'] ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?= $row['nama'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="Laki-laki" <?= $row['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="Perempuan" <?= $row['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" required><?= $row['alamat']?></textarea>
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi Diri</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi"><?= $row['deskripsi']?></textarea>
                </div>
                <div class="mb-3">
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" class="form-control" id="foto" name="foto">
                    <img src="assets/images/<?= $row['foto'] ?>" width="100" class="mt-2">
                </div>
                <button type="submit" class="btn btn-warning">Update</button>
            </form>
            <a href="index.php" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </body>
</html>

<?php $conn->close(); ?>
