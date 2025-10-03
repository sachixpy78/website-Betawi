<?php
include "../koneksi.php"; 
// Ambil data dari tabel tarian
$query = mysqli_query($conn, "SELECT * FROM tarian ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Budaya Betawi - Tarian</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: #f9f9f9;
      color: #222;
    }

 /* HEADER */
.header-top {
  background: #fff;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 40px;
  border-bottom: 2px solid #ccc;
}
.header-top .logo {
  font-size: 28px;
  font-weight: bold;
  color: red;
  letter-spacing: 1px;
}

   .login-btn {
      border: 1px solid #000;
      padding: 6px 16px;
      border-radius: 20px;
      font-weight: bold;
      text-decoration: none;
      color: #000;
      transition: 0.3s;
    }
    .login-btn:hover {
      background: #7a0000ff;
      color: #fff;
      border-color: red;
    }


/* NAVBAR */
.navbar {
  background: #f5f5f5;
  text-align: center;
  padding: 12px 20px;
  border-bottom: 2px solid #eee;
  position: sticky;
  top: 0;
  z-index: 100;
}
.navbar a {
  margin: 0 18px;
  color: #000;
  text-decoration: none;
  font-weight: 500;
  transition: 0.3s;
}
.navbar a.active,
.navbar a:hover {
  color: red;
  font-weight: bold;
}

/* HERO */
.hero {
  background: url('./img/batikdash.jpg') no-repeat center/cover;
  color: white;
  text-align: center;
  padding: 50px 20px;
  font-size: 44px;
  font-family: "Georgia", serif;
  font-weight: bold;
  position: relative;
}
.hero::after {
  content: "";
  position: absolute;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.45);
}
.hero span {
  position: relative;
  z-index: 2;
  text-shadow: 2px 2px 8px rgba(0,0,0,0.6);
}


    /* KONTEN */
    .content {
      padding: 40px 20px;
      max-width: 1100px;
      margin: auto;
    }
    .tarian-item {
      display: flex;
      align-items: flex-start;
      margin-bottom: 35px;
      background: white;
      border-radius: 10px;
      padding: 18px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }
    .tarian-item .info {
      flex: 2;
      padding-right: 20px;
    }
    .tarian-item .info h2 {
      margin: 0 0 10px;
      color: #111;
    }
    .tarian-item .info p {
      text-align: justify;
      line-height: 1.6;
    }
    .tarian-item iframe {
      flex: 1;
      min-width: 260px;
      height: 150px;
      border: none;
      border-radius: 8px;
    }

    /* FOOTER */
    footer {
      background:  #ccc;
      color: #080808ff;
      padding: 40px 20px 20px;
      margin-top: 50px;
    }
    .footer-container {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
      max-width: 1100px;
      margin: auto;
    }
    .footer-col {
      flex: 1;
      margin: 10px 20px;
      min-width: 220px;
    }
    .footer-col h4 {
      color: #000000ff;
      margin-bottom: 10px;
    }
    .footer-col ul {
      list-style: none;
      padding: 0;
    }
    .footer-col ul li {
      margin: 6px 0;
    }
    .footer-col ul li a {
      color: #070707ff;
      text-decoration: none;
      transition: 0.3s;
    }
    .footer-col ul li a:hover {
      color: red;
    }
    .brand {
      font-size: 28px;
      font-weight: bold;
      color: red;
      margin-bottom: 10px;
    }
    .footer-bottom {
      text-align: center;
      margin-top: 25px;
      border-top: 1px solid #444;
      padding-top: 12px;
      color: #000000ff;
    }
  </style>
</head>
<body>

<!-- HEADER -->
<div class="header-top">
  <div class="logo">BETAWI</div>
  <a href="../admin/index.php" class="login-btn">LOGIN</a>
</div>

<!-- NAVBAR -->
<div class="navbar">
 <a href="index.php">Beranda</a>
  <a href="tarian.php">Tarian</a>
  <a href="lagu.php" class="active">Lagu</a>
  <a href="alatmusik.php">Alat Musik</a>
  <a href="kuliner.php">Kuliner</a>
  <a href="bajuadat.php">Pakaian</a>
 <a href="seni_pertunjukan.php">Seni Pertunjukan</a>
</div>

<!-- HERO -->
<div class="hero"><span>Budaya Betawi</span></div>

<!-- KONTEN -->
<div class="content">
  <?php while ($row = mysqli_fetch_assoc($query)) { ?>
    <div class="tarian-item">
      <div class="info">
        <h2><?= $row['nama']; ?></h2>
        <p><?= $row['deskripsi']; ?></p>
      </div>
      <iframe src="<?= $row['link']; ?>" allowfullscreen></iframe>
    </div>
  <?php } ?>
</div>

<!-- FOOTER -->
<footer>
  <div class="footer-container">
    <div class="footer-col">
      <h2 class="brand">BETAWI</h2>
      <p>Website edukasi budaya Betawi</p>
    </div>
    <div class="footer-col">
      <h4>Kategori</h4>
      <ul>
        <li><a href="index.php">Berita</a></li>
        <li><a href="seni_pertunjukan.php">pertunjukan</a></li>
        <li><a href="lagu.php">lagu adat</a></li>
        <li><a href="kuliner.php">Makanan</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Tentang Kami</h4>
      <p>
        Email: smkn1jkt@gmail.com <br>
      Website:<a href="https://smkn71jakarta.sch.id" target="_blank">smkn71jakarta.sch.id</a><br>
        Jl. Dr. KRT Radjiman Widyodiningrat <br>
        Jatinegara, Jakarta Timur
      </p>
    </div>
  </div>
  <div class="footer-bottom">
    <small>Kelompok 2 | Hak Cipta XI RPL 1 2025</small>
  </div>
</footer>

</body>
</html>
