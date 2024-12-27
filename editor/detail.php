<?php
include 'database.php';

// get ID user dari parameter URL
$id = $_GET['id'];

// query buat get data user berdasarkan ID
$sql_user = "SELECT * FROM users WHERE id = '$id'";
$result_user = $conn->query($sql_user);

// cek data user jika tidak ditemukan, tampilkan pesan
if ($result_user->num_rows == 0) {
    echo "<div class='alert alert-warning'>Data pengguna tidak ditemukan</div>";
    exit;
}
$user = $result_user->fetch_assoc();

// query buat get data riwayat_pendidikan user
$sql_riwayat = "SELECT * FROM riwayat_pendidikan WHERE user_id = '$id'";
$result_riwayat = $conn->query($sql_riwayat);

// query buat get data proyek user
$sql_project = "SELECT * FROM project WHERE user_id = '$id'";
$result_project = $conn->query($sql_project);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Detail Identitas</h1>

        <!-- Informasi Pengguna -->
        <div class="card mb-4">
            <div class="card-header">Informasi Pengguna</div>
            <div class="card-body">
                <p><strong>Nama:</strong> <?= htmlspecialchars($user['nama']) ?></p>
                <p><strong>Jenis Kelamin:</strong> <?= htmlspecialchars($user['jenis_kelamin']) ?></p>
                <p><strong>Alamat:</strong> <?= htmlspecialchars($user['alamat']) ?></p>
                <p><strong>Deskripsi:</strong> <?= htmlspecialchars($user['deskripsi']) ?></p>
                <p>
                    <strong>Foto:</strong><br>
                    <img src="assets/images/<?= htmlspecialchars($user['foto']) ?>" alt="Foto Pengguna" width="150">
                </p>
            </div>
        </div>

        <!-- Riwayat Pendidikan -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Riwayat Pendidikan</span>
                <a href="create_riwayat.php?id=<?= htmlspecialchars($user['id']) ?>" class="btn btn-success btn-sm">Tambah Riwayat Pendidikan</a>
            </div>
            <div class="card-body">
                <?php if ($result_riwayat->num_rows > 0): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pendidikan</th>
                            <th>Tahun</th>
                            <th>Nama Sekolah/Kampus</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; while ($riwayat = $result_riwayat->fetch_assoc()): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($riwayat['pendidikan']) ?></td>
                            <td><?= htmlspecialchars($riwayat['tahun']) ?></td>
                            <td><?= htmlspecialchars($riwayat['nama_sekolah']) ?></td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="edit_riwayat.php?id=<?= $riwayat['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="delete_riwayat.php?id=<?= $riwayat['id'] ?>&user_id=<?= htmlspecialchars($user['id']) ?>" class="btn btn-danger btn-sm">Hapus</a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p>Riwayat pendidikan tidak tersedia.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Project -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Project</span>
                <a href="create_project.php?user_id=<?= htmlspecialchars($user['id']) ?>" class="btn btn-success btn-sm">Tambah Project</a>
            </div>
            <div class="card-body">
                <?php if ($result_project->num_rows > 0): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Project</th>
                            <th>Keterangan</th>
                            <th>Gambar</th>
                            <th>Link Project</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; while ($project = $result_project->fetch_assoc()): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($project['project']) ?></td>
                            <td><?= htmlspecialchars($project['keterangan']) ?></td>
                            <td>
                                <img src="assets/images/<?= htmlspecialchars($project['image']) ?>" alt="Gambar Project" width="100">
                            </td>
                            <td>
                                <a href="<?= htmlspecialchars($project['link_project']) ?>" target="_blank"><?= htmlspecialchars($project['link_project']) ?></a>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                <a href="edit_project.php?id=<?= $project['id'] ?>&user_id=<?= $user['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="delete_project.php?id=<?= $project['id'] ?>&user_id=<?= htmlspecialchars($user['id']) ?>" class="btn btn-danger btn-sm">Hapus</a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p>Project tidak tersedia.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Tombol Kembali -->
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </div>
</body>
</html>

<?php $conn->close(); ?>
