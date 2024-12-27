<?php
    include 'database.php';

    $id = $_GET['id'];

    // Hapus foto jika ada
    $sql = "SELECT foto FROM users WHERE id = '$id'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $foto = $row['foto'];
    unlink("assets/images/$foto");

    // Hapus data dari database
    $sql = "DELETE FROM users WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        header('Location: index.php');
    } else {
        echo "Error: " . $conn->error;
    }
    
    $conn->close();
?>
