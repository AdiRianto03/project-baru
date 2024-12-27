<?php
include 'database.php';

// cek parameter
if (!isset($_GET['id']) || !isset($_GET['user_id'])) {
    die("Parameter tidak lengkap.");
}

$id = (int)$_GET['id'];
$user_id = (int)$_GET['user_id'];

// cek keberadaan data
$stmt_check = $conn->prepare("SELECT id FROM project WHERE id = ?");
$stmt_check->bind_param("i", $id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows === 0) {
    die("Data proyek tidak ditemukan.");
}
$stmt_check->close();

// delete data proyek
$stmt = $conn->prepare("DELETE FROM project WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: detail.php?id=$user_id"); // kembali ke halaman detail
} else {
    echo "<div class='alert alert-danger'>Terjadi kesalahan saat menghapus proyek: " . htmlspecialchars($stmt->error) . "</div>";
}

$stmt->close();
$conn->close();
?>
