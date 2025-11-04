<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}
include "../koneksi.php";

// Cek ID dari URL
if (!isset($_GET['id'])) {
    header("Location: senipertunjukan.php");
    exit;
}
$id = intval($_GET['id']);

// Ambil data tarian
$query = mysqli_query($conn, "SELECT * FROM seni_pertunjukan WHERE id = $id");
$data = mysqli_fetch_assoc($query);
if (!$data) {
    echo "Data tidak ditemukan!";
    exit;
}

// Jika form disubmit
if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $link = mysqli_real_escape_string($conn, $_POST['link']);
// ✅ TARO CEK NAMA DI SINI
    $cekNama = mysqli_query($conn, "SELECT * FROM lagu WHERE nama = '$nama' AND id != $id");
    if (mysqli_num_rows($cekNama) > 0) {
        echo "<script>
                alert('Nama \"$nama\" sudah ada, silakan gunakan nama lain!');
                window.location = 'edit_lagu.php?id=$id';
              </script>";
        exit;
    }
    // Update database
    $update = mysqli_query($conn, "UPDATE lagu SET 
        nama = '$nama',
        deskripsi = '$deskripsi',
        link = '$link'
        WHERE id = $id");

    if ($update) {
        echo "<script>
                alert('Data berhasil diubah!');
                window.location.href = 'senipertunjukan.php';
              </script>";
        exit;
    } else {
        echo "Gagal update data!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Tarian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('./img/walll.jpg');
            background-size: cover;
            margin: 0;
            padding: 0;
        }
        .header {
            background: #7B1E1E;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 22px;
        }
        .container {
            background: #f8f8f8;
            max-width: 400px;
            margin: 30px auto;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            border-radius: 10px;
            border: 1px solid #aaa;
            margin-bottom: 15px;
        }
        textarea {
            resize: vertical;
        }
        button {
            background: #7B1E1E;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }
        button:hover {
            background: #5c1313;
        }
    </style>
</head>
<body>
    <div class="header">Edit seni pertunjukan</div>

    <div class="container">
        <form method="POST">
            <label>Nama pertunjukan:</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']); ?>" required>

            <label>Deskripsi:</label>
            <textarea name="deskripsi" rows="4" required><?= htmlspecialchars($data['deskripsi']); ?></textarea>

            <label>Link Video YouTube:</label>
            <input type="text" name="link" value="<?= htmlspecialchars($data['link']); ?>" required>

            <button type="submit" name="update">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
