<?php
include 'database.php';

// cek parameter URL
if (!isset($_GET['id']) || !isset($_GET['user_id'])) {
    die("Parameter tidak lengkap.");
}

$id = $_GET['id'];        // ID riwaya_pendidikan yg akan dihapus
$user_id = $_GET['user_id']; // ID user buat kembali ke halaman detail

// query untuk delete data riwayat_pendidikan
$sql_delete = "DELETE FROM riwayat_pendidikan WHERE id = '$id'";

if ($conn->query($sql_delete) === TRUE) {
    header("Location: detail.php?id=$user_id"); // kembali ke halaman detail
    exit();
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
