<?php
include 'database.php';

// cek parameter URL
if (!isset($_GET['user_id'])) {
    die("Parameter user_id tidak ditemukan.");
}

$user_id = $_GET['user_id']; // get user_id dari parameter URL

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $project = $_POST['project'];
    $keterangan = $_POST['keterangan'];
    $link_project = $_POST['link_project'];
    $image = $_FILES['image']['name'];
    $target_file = "assets/images/" . basename($image);

    // pindahkn file gambar ke folder yang sesuai
    move_uploaded_file($_FILES['image']['tmp_name'], $target_file);

    // query buat create data proyek
    $sql = "INSERT INTO project (user_id, project, keterangan, image, link_project) 
            VALUES ('$user_id', '$project', '$keterangan', '$image', '$link_project')";

    if ($conn->query($sql) === TRUE) {
        header("Location: detail.php?id=$user_id"); // kembali ke halaman detail dengan user_id
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Tambah Project</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="project" class="form-label">Nama Project</label>
                <input type="text" class="form-control" id="project" name="project" required>
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" required></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Gambar</label>
                <input type="file" class="form-control" id="image" name="image" required>
            </div>
            <div class="mb-3">
                <label for="link_project" class="form-label">Link Project</label>
                <input type="url" class="form-control" id="link_project" name="link_project" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="detail.php?id=<?= $user_id ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>
