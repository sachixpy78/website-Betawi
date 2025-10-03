<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}
include "../koneksi.php";

// Simpan data
if (isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $link = mysqli_real_escape_string($conn, $_POST['link']);

     // 🔎 Cek apakah nama sudah ada
    $cekNama = mysqli_query($conn, "SELECT * FROM tarian WHERE nama = '$nama'");
    if (mysqli_num_rows($cekNama) > 0) {
        echo "<script>
                alert('Nama\"$nama\" sudah ada, silakan gunakan nama lain!');
                window.location = 'tambah_tarian.php';
              </script>";
        exit;
    }
    $query = "INSERT INTO tarian (nama, deskripsi, link) VALUES ('$nama', '$deskripsi', '$link')";
    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('Data berhasil ditambahkan!');
                window.location = 'tarian.php';
              </script>";
        exit;
    } else {
        echo "Gagal menambahkan data: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Tarian</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: url('./img/walll.jpg');
      background-size: cover;
    }
    .header {
      background: #7b0e15;
      color: #fff;
      padding: 15px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
      font-weight: bold;
      position: relative;
    }
    .header a {
      position: absolute;
      left: 15px;
      top: 15px;
      text-decoration: none;
      color: white;
      font-size: 22px;
    }
    .card {
      max-width: 500px;
      background: #fff;
      margin: 40px auto;
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0px 4px 8px rgba(0,0,0,0.2);
    }
    .upload-icon {
      display: flex;
      justify-content: center;
      margin-bottom: 15px;
    }
    .upload-icon div {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background: #7b0e15;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      font-size: 40px;
    }
    label {
      display: block;
      margin: 10px 0 5px;
      font-weight: bold;
    }
    input[type="text"], textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 10px;
      margin-bottom: 15px;
    }
    button {
      background: #7b0e15;
      color: #fff;
      padding: 10px 20px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      font-size: 16px;
      width: 100%;
    }
    button:hover {
      background: #a0121c;
    }
  </style>
</head>
<body>
  <div class="header">
    <a href="tarian.php">⭠</a>
    Tambah Tarian
  </div>
  <div class="card">
    <div class="upload-icon">
      <div>🎶</div>
    </div>
    <form action="" method="post">
      <label>Nama Tarian:</label>
      <input type="text" name="nama" placeholder="Masukan nama tarian" required>

      <label>Deskripsi:</label>
      <textarea name="deskripsi" placeholder="Masukan deskripsi tarian" required></textarea>

      <label>Link Video YouTube:</label>
      <input type="text" name="link" placeholder="Masukan link video" required>

      <button type="submit" name="simpan">Simpan</button>
    </form>
  </div>
</body>
</html>
