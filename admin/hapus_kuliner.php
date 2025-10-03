<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}
include "../koneksi.php";

// Cek apakah ada id yang dikirim
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Ambil data dulu biar tahu file gambar
    $query = mysqli_query($conn, "SELECT * FROM kuliner WHERE id = $id");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        // Hapus file gambar di folder (opsional, kalau perlu)
        if (file_exists($data['gambar']) && is_file($data['gambar'])) {
            unlink($data['gambar']);
        }

        // Hapus data dari database
        mysqli_query($conn, "DELETE FROM kuliner WHERE id = $id");
    }
}

header("Location: kuliner.php");
exit;
?>
