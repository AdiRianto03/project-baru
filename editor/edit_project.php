<?php
include 'database.php';

// validasi parameter URL
if (!isset($_GET['id']) || !isset($_GET['user_id'])) {
    die("Parameter tidak lengkap.");
}

$id = $_GET['id'];           // ID proyek yg ingin diubah
$user_id = $_GET['user_id']; // ID user buat kembali ke halaman detail

// query buat mendapatin data proyek berdasarkan ID
$sql_project = "SELECT * FROM project WHERE id = '$id'";
$result_project = $conn->query($sql_project);

if ($result_project->num_rows == 0) {
    die("Data proyek tidak ditemukan.");
}

$project = $result_project->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $project_name = $_POST['project'];
    $keterangan = $_POST['keterangan'];
    $link_project = $_POST['link_project'];
    $image = $_FILES['image']['name'];
    $target_file = "assets/images/" . basename($image);

    if ($image) {
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
    } else {
        $image = $project['image']; // pakai gambar yang ada jika tidak ada gambar baru
    }

    // query buat uodate data proyek
    $sql_update = "UPDATE project SET project = '$project_name', keterangan = '$keterangan', image = '$image', link_project = '$link_project' WHERE id = '$id'";

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
    <title>Edit Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Project</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="project" class="form-label">Nama Project</label>
                <input type="text" class="form-control" id="project" name="project" value="<?= htmlspecialchars($project['project']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control" id="keterangan" name="keterangan" required><?= htmlspecialchars($project['keterangan']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Gambar</label>
                <input type="file" class="form-control" id="image" name="image">
                <img src="assets/images/<?= htmlspecialchars($project['image']) ?>" alt="Gambar Project" width="100">
            </div>
            <div class="mb-3">
                <label for="link_project" class="form-label">Link Project</label>
                <input type="url" class="form-control" id="link_project" name="link_project" value="<?= htmlspecialchars($project['link_project']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="detail.php?id=<?= htmlspecialchars($user_id) ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>
