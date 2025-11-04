<?php
include "../koneksi.php"; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Budaya Betawi</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: #f9f9f9;
      color: #222;
    }

    /* HEADER TOP */
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
      display: flex;
      justify-content: center;
      gap: 30px;
      padding: 14px 0;
      border-bottom: 2px solid #eee;
      position: sticky;
      top: 0;
      left: 0;
      width: 100%;
      z-index: 100;
    }
    .navbar a {
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
      background: rgba(0,0,0,0.5);
    }
    .hero span {
      position: relative;
      z-index: 2;
    }

    /* KONTEN */
    .content {
      padding: 40px 20px;
      max-width: 1100px;
      margin: auto;
    }
    .content h3 {
      margin-bottom: 15px;
      color: #333;
    }

    /* SCROLL INFO POPULER */
    .info-populer {
      display: flex;
      overflow-x: auto;
      gap: 15px;
      padding: 10px 0 20px;
      scroll-snap-type: x mandatory;
      -webkit-overflow-scrolling: touch;
    }
    .info-populer::-webkit-scrollbar {
      display: none;
    }
    .info-populer img {
      flex: 0 0 auto;
      width: 220px;
      height: 350px;
      object-fit: cover;
      border-radius: 12px;
      scroll-snap-align: start;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .info-populer img:hover {
      transform: scale(1.05);
      box-shadow: 0 5px 15px rgba(0,0,0,0.25);
    }

    /* ARTIKEL */
    .artikel {
      display: flex;
      align-items: flex-start;
      margin-bottom: 35px;
      background: white;
      border-radius: 10px;
      padding: 18px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }
    .artikel img {
      width: 260px;
      height: auto;
      border-radius: 8px;
      margin-right: 20px;
      transition: 0.3s;
    }
    .artikel img:hover {
      transform: scale(1.04);
    }
    .artikel.right {
      flex-direction: row-reverse;
    }
    .artikel.right img {
      margin-right: 0;
      margin-left: 20px;
    }
    .artikel h2 {
      margin-top: 0;
      margin-bottom: 10px;
      color: #111;
    }
    .artikel p {
      text-align: justify;
      line-height: 1.6;
    }

    /* FOOTER */
    footer {
      background: #ccc;
      color: #000000ff;
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
      color: #020202ff;
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
      color: #060606ff;
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
      color: #080808ff;
    }
  </style>
</head>
<body>

<!-- HEADER TOP -->
<div class="header-top">
  <div class="logo">Betawi</div>
  <a href="../admin/index.php" class="login-btn">LOGIN</a>
</div>

<!-- NAVBAR -->
<div class="navbar">
  <a href="index.php" class="active">Beranda</a>
  <a href="tarian.php">Tarian</a>
  <a href="lagu.php">Lagu</a>
  <a href="alatmusik.php">Alat Musik</a>
  <a href="kuliner.php">Kuliner</a>
  <a href="bajuadat.php">Pakaian</a>
  <a href="seni_pertunjukan.php">Seni Pertunjukan</a>
</div>

<!-- HERO -->
<div class="hero"><span>Budaya Betawi</span></div>

<!-- KONTEN -->
<div class="content">
  <h3>Info Terpopuler:</h3>
  <div class="info-populer">
    <img src="./img/info1.jpg" alt="info1">
    <img src="./img/info2.jpg" alt="info2">
    <img src="./img/info3.jpg" alt="info3">
    <img src="./img/info4.jpg" alt="info4">
    <img src="./img/info5.jpg" alt="info5">
    <img src="./img/info6.jpg" alt="info6">
    <img src="./img/info7.jpg" alt="info7">
    <img src="./img/info8.jpg" alt="info8">
    <img src="./img/info9.jpg" alt="info9">
    <img src="./img/info10.jpg" alt="info10">
  </div>

  <!-- Artikel 1 -->
  <div class="artikel right">
    <img src="./img/daya.jpg" alt="artikel1">
    <div>
      <h2>Kebudayaan Suku Jawa Tengah di Indonesia</h2>
      <p>Suku Betawi merupakan suku asli yang mendiami Jakarta dan sekitarnya, terbentuk dari percampuran berbagai etnis seperti Jawa, Sunda, Arab, Tionghoa, dan Portugis. Masyarakat Betawi dikenal ramah, terbuka, serta menjunjung tinggi nilai kekeluargaan dan gotong royong. Mayoritas suku Betawi bermata pencaharian di bidang perdagangan, seni pertunjukan, dan jasa. Budaya Betawi masih kental terlihat dalam tradisi Palang Pintu, Lenong, Ondel-ondel, hingga kuliner khas seperti kerak telor dan soto Betawi.</p>
    </div>
  </div>

  <!-- Artikel 2 -->
  <div class="artikel">
    <img src="./img/ke.jpg" alt="artikel2">
    <div>
      <h2>Perkembangan dan Keanekaragaman Kebudayaan Jawa Tengah</h2>
      <p>Kebudayaan Betawi lahir dari percampuran berbagai etnis seperti Jawa, Sunda, Arab, Tionghoa, India, hingga Portugis yang menetap di Batavia. Perpaduan ini melahirkan kesenian, tradisi, dan bahasa khas Betawi yang berkembang di kawasan Jakarta, terutama Condet dan Setu Babakan. Budaya Betawi terlihat dalam seni Lenong, Gambang Kromong, Ondel-ondel, serta tradisi Palang Pintu. Kuliner khasnya seperti kerak telor, soto Betawi, dan bir pletok juga menjadi bagian penting yang terus dilestarikan hingga kini.</p>
    </div>
  </div>
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
        <li><a href="seni_pertunjukan.php">Seni Pertunjukan</a></li>
        <li><a href="lagu.php">lagu adat</a></li>
        <li><a href="kuliner.php">Makanan</a></li>
      </ul>
    </div>
    <div class="footer-col">
      <h4>Tentang Kami</h4>
      <p>
        Email: smkn71jkt@gmail.com <br>
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
