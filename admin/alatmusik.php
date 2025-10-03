<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}
include "../koneksi.php";

$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alat Musik - Admin</title>
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
        
        .sidebar ul li a.active {
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

        /* Card deskripsi Jawa Tengah */
        .card {
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 2px 8px 16px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
        }

        .card img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }

        .card p {
            flex: 1;
            font-size: 15px;
            line-height: 1.5;
            color: #333;
        }

        /* Dropdown kategori */
        .dropdown {
            position: relative;
            margin-top: 25px;
        }

        .dropdown-btn {
            background: #e67330;
            color: white;
            padding: 12px 20px;
            font-size: 16px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 180px;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            top: 50px;
            left: 0;
            background: #fff;
            min-width: 180px;
            border-radius: 8px;
            box-shadow: 2px 8px 16px rgba(0,0,0,0.1);
            overflow: hidden;
            z-index: 100;
        }

        .dropdown-content a {
            display: block;
            padding: 12px;
            text-decoration: none;
            color: #333;
            border-bottom: 1px solid #ddd;
        }

        .dropdown-content a:hover {
            background: #f2f2f2;
        }

        .dropdown.show .dropdown-content {
            display: block;
        }

.alatmusik-controls {
    margin: 15px 0;
    text-align: right;
}

.alatmusik-controls .btn-tambah {
    display: inline-block;
    background-color: #7B1E1E;
    color: #fff;
    padding: 10px 18px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
    font-weight: bold;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.alatmusik-controls .btn-tambah i {
    margin-right: 6px;
}

.alatmusik-controls .btn-tambah:hover {
    background-color: #5c1313;
    transform: scale(1.05);
}

        /* Grid alat musik */
        .alatmusik-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 25px;
        }

        .alatmusik-card {
            background: #fff;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            box-shadow: 2px 6px 12px rgba(0,0,0,0.1);
            transition: transform 0.2s ease;
        }

        .alatmusik-card:hover {
            transform: translateY(-5px);
        }

        .alatmusik-card img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
        }

        .alatmusik-card h3 {
            font-size: 18px;
            font-weight: bold;
            color: #7b1e1e;
            margin-bottom: 15px;
        }

        .card-actions {
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .card-actions a {
            color: #7b1e1e;
            font-size: 18px;
            transition: color 0.3s;
        }

        .card-actions a:hover {
            color: #e67330;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <i class="fas fa-bars menu-toggle" onclick="toggleSidebar()"></i>
        <h1>Alat Musik</h1>
    </div>

    <div class="sidebar" id="sidebar">
        <div class="profile">
            <img src="./img/user.png" alt="User">
        </div>
        <ul>
            <li><a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="t_admin.php"><i class="fas fa-user"></i> Admin</a></li>
            <li><a href="kategori.php"><i class="fas fa-box"></i> Kategori</a></li>
            <li><a href="jawa_tengah.php"><i class="fas fa-landmark"></i> Jawa Tengah</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <!-- Content -->
    <div class="content">

        <div class="card">
                 <img src="./img/logobetawi.jpg" alt="Lambang betawi">
      <p style="text-align: justify;">
   Betawi adalah budaya asli masyarakat Jakarta yang terbentuk dari percampuran berbagai etnis seperti Jawa, Sunda, Arab, Cina, hingga Belanda, sehingga melahirkan identitas khas yang unik dan beragam. Budaya Betawi dikenal melalui ikon keseniannya seperti ondel-ondel yang menjadi simbol pelindung, teater rakyat lenong dengan bahasa Betawi yang jenaka, musik tradisional tanjidor yang menggunakan alat tiup, serta gambang kromong yang memadukan nuansa musik Cina dan Betawi. Dalam kehidupan sosial, masyarakat Betawi menjunjung tinggi nilai kekeluargaan, gotong royong, dan kesederhanaan. Warisan kuliner khasnya pun terkenal luas, seperti kerak telor yang menjadi makanan ikonik, soto Betawi dengan kuah santan gurih, nasi uduk, asinan Betawi, hingga aneka jajanan tradisional seperti kue rangi dan kue ape. Pakaian adat Betawi juga memiliki ciri khas, yaitu baju sadariah dan batik untuk pria serta kebaya kerancang untuk wanita. Sebagai bagian dari identitas Jakarta, budaya Betawi terus dilestarikan melalui beragam acara dan festival, salah satunya Lebaran Betawi yang menampilkan seni, musik, kuliner, hingga tradisi masyarakat Betawi sebagai bentuk kebanggaan dan pelestarian budaya lokal.
  </p>
        </div>

        <div class="dropdown" id="dropdownMenu">
            <button class="dropdown-btn">
                Pilih Kategori <i class="fas fa-chevron-down"></i>
            </button>
            <div class="dropdown-content">
                <a href="kuliner.php">Kuliner</a>
                <a href="alatmusik.php">Alat Musik</a>
                <a href="bajuadat.php">Baju Adat</a>
                <a href="tarian.php">Tarian</a>
                <a href="lagu.php">Lagu</a>
                <a href="senipertunjukan.php">Seni pertunjukan</a>
            </div>
        </div>

        <div class="alatmusik-controls">
            <a href="tambah_alatmusik.php" class="btn-tambah">
                <i class="fas fa-plus"></i> Tambah
            </a>
        </div>

        <!-- Grid alat musik -->
        <div class="alatmusik-grid">
            <?php 
            $query = mysqli_query($conn, "SELECT * FROM alat_musik LIMIT 7"); 
            while ($row = mysqli_fetch_assoc($query)) { 
            ?>
                <div class="alatmusik-card">
                    <img src="<?= $row['gambar']; ?>" alt="<?= $row['nama']; ?>">
                    <h3><?= $row['nama']; ?></h3>
                    <div class="card-actions">
                        <a href="edit_alatmusik.php?id=<?= $row['id']; ?>"><i class="fas fa-edit"></i></a>
                     <a href="hapus_alatmusik.php?tabel=alatmusik&id=<?= $row['id']; ?>" 
   onclick="return confirm('Yakin mau hapus alat musik ini?');">
   <i class="fas fa-trash"></i>
</a>

                    </div>
                </div>
            <?php } ?>
        </div>

    </div>

    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("active");
        }

        // Dropdown toggle
        const dropdown = document.getElementById("dropdownMenu");
        const btn = dropdown.querySelector(".dropdown-btn");
        btn.addEventListener("click", () => {
            dropdown.classList.toggle("show");
        });
    </script>

</body>
</html>
