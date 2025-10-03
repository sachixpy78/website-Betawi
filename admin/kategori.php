<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}
include "../koneksi.php"; // pastikan ini sesuai path
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kategori Budaya Betawi</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: #f7f2ec;
    }

    /* Navbar */
    .navbar {
      height: 60px;
      background: #7b1e1e;
      display: flex;
      align-items: center;
      padding: 0 20px;
      color: #fff;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
    }

    .navbar .menu-toggle {
      font-size: 24px;
      cursor: pointer;
      margin-right: 20px;
    }

    .navbar h1 {
      font-size: 20px;
      margin: 0;
    }

    /* Sidebar */
    .sidebar {
      position: fixed;
      top: 0;
      left: -240px;
      width: 240px;
      height: 100%;
      background: url('./img/klu.jpg') no-repeat center center;
      background-size: cover;
      color: white;
      transition: left 0.3s ease;
      z-index: 999;
      padding-top: 70px;
    }

    .sidebar.active {
      left: 0;
    }

    .sidebar .profile {
      text-align: center;
      margin-bottom: 20px;
    }

    .sidebar .profile img {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background: #701B1F;
      padding: 8px;
    }

    .sidebar ul {
      list-style: none;
      padding: 0;
      margin: 20px 0;
    }

    .sidebar ul li {
      margin: 8px 0;
    }

    .sidebar ul li a {
      display: block;
      padding: 12px 18px;
      color: white;
      text-decoration: none;
      background: rgba(0,0,0,0.55);
      border-radius: 5px;
      margin: 0 15px;
      font-weight: bold;
      transition: background 0.3s;
    }

    .sidebar ul li a:hover {
      background: rgba(0,0,0,0.8);
    }

    /* Content */
    .content {
      margin-top: 70px;
      padding: 20px;
      transition: margin-left 0.3s ease;
    }

    .sidebar.active ~ .content {
      margin-left: 240px;
    }

    /* Header dalam content */
    .page-header {
      background: #7b1e1e;
      padding: 15px;
      color: white;
      font-size: 22px;
      font-weight: bold;
      border-radius: 12px;
      text-align: center;
      margin-bottom: 20px;
    }

    /* Categories */
    .categories {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 35px;
      margin-top: 20px;
      padding: 20px;
      justify-items: center;
    }

    .category {
      background: white;
      border-radius: 16px;
      padding: 30px 20px;
      text-align: center;
      box-shadow: 2px 8px 14px rgba(0,0,0,0.12);
      transition: transform 0.25s;
      width: 100%;
      max-width: 320px;
    }

    .category:hover {
      transform: translateY(-8px);
    }

    .category img {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 20px;
    }

    .category h3 {
      font-size: 20px;
      margin: 0;
      color: #222;
    }

  </style>
</head>
<body>

  <!-- Navbar -->
  <div class="navbar">
    <i class="fas fa-bars menu-toggle" onclick="toggleSidebar()"></i>
    <h1>Kategori Budaya Betawi</h1>
  </div>

<!-- Sidebar -->
  <div class="sidebar" id="sidebar">
        <div class="profile">
            <img src="./img/user.png" alt="User">
        </div>
        <ul>
            <li><a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="t_admin.php"><i class="fas fa-user"></i> Admin</a></li>
            <li><a href="kategori.php"><i class="fas fa-box"></i> Kategori</a></li>
            <li><a href="Betawi.php"><i class="fas fa-landmark"></i>Betawi</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

  <!-- Content -->
  <div class="content">
     <div class="categories">
  <?php 
  $query = mysqli_query($conn, "SELECT * FROM kategori limit 6"); // ambil semua data kategori
  while ($row = mysqli_fetch_assoc($query)) { // mulai looping data kategori
  ?>
    <div class="category"> <!-- isi looping -->
      <img src="<?= $row['gambar']; ?>" alt="<?= $row['nama']; ?>"> <!-- gambar kategori -->
      <h3><?= $row['nama']; ?></h3> <!-- nama kategori -->
    </div>
  <?php } // tutup looping while ?>
</div>



  <script>
    function toggleSidebar() {
      document.getElementById("sidebar").classList.toggle("active");
    }
  </script>

</body>
</html>
