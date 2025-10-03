<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}
include "../koneksi.php";

// Cek ID dari URL
if (!isset($_GET['id'])) {
    header("Location: kuliner.php");
    exit;
}
$id = intval($_GET['id']);

// Ambil data kuliner
$query = mysqli_query($conn, "SELECT * FROM kuliner WHERE id = $id");
$data = mysqli_fetch_assoc($query);
if (!$data) {
    echo "Data tidak ditemukan!";
    exit;
}



// Jika form disubmit
if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $gambar = $data['gambar']; // default pakai gambar lama
  // ✅ TARO CEK NAMA DI SINI
    $cekNama = mysqli_query($conn, "SELECT * FROM kuliner WHERE nama = '$nama' AND id != $id");
    if (mysqli_num_rows($cekNama) > 0) {
        echo "<script>
                alert('Nama \"$nama\" sudah ada, silakan gunakan nama lain!');
                window.location = 'edit_kuliner.php?id=$id';
              </script>";
        exit;
    }
    // Upload gambar jika ada file baru
    if ($_FILES['gambar']['name'] != '') {
        $target_dir = "./img/";
        $file_name = time() . "_" . basename($_FILES["gambar"]["name"]);
        $target_file = $target_dir . $file_name;

        if ($_FILES["gambar"]["size"] <= 10485760) { // max 10 MB
            move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);
            $gambar = "./img/" . $file_name;
        } else {
            echo "<script>alert('Ukuran file maksimal 10 MB!');</script>";
        }
    }

    // Update database
    $update = mysqli_query($conn, "UPDATE kuliner SET 
        nama = '$nama',
        deskripsi = '$deskripsi',
        gambar = '$gambar'
        WHERE id = $id");

    if ($update) {
        echo "<script>
                alert('Data berhasil diubah!');
                window.location.href = 'kuliner.php';
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
    <title>Edit Kuliner</title>
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
        .upload {
            border: 2px dashed #ccc;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
        }
        .upload img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 10px;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            border-radius: 10px;
            border: 1px solid #aaa;
            margin-bottom: 15px;
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
    <div class="header">Edit Kuliner</div>

    <div class="container">
        <form method="POST" enctype="multipart/form-data">
            <div class="upload">
                <img src="<?= $data['gambar']; ?>" alt="Foto">
                <br>
                <input type="file" name="gambar" accept="image/*">
                <p><small>Upload max 10MB</small></p>
            </div>

            <label>Nama Makanan:</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']); ?>" required>

            <label>Deskripsi Makanan:</label>
            <textarea name="deskripsi" rows="4" required><?= htmlspecialchars($data['deskripsi']); ?></textarea>

            <button type="submit" name="update">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
