
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}
include "../koneksi.php";

// Hitung total admin
$qAdmin = mysqli_query($conn, "SELECT COUNT(*) as total FROM admin");
$totalAdmin = mysqli_fetch_assoc($qAdmin)['total'];


$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Admin</title>
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

    .sidebar.active { left: 0; }

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

    .sidebar ul li { margin: 8px 0; }

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

    .sidebar ul li a:hover { background: rgba(0,0,0,0.8); }

    /* Content */
    .content {
      margin-top: 70px;
      padding: 20px;
      transition: margin-left 0.3s ease;
    }
    .sidebar.active ~ .content { margin-left: 240px; }

    /* Welcome Box */
    .welcome-box {
      background: #fff;
      padding: 20px 30px;
      border-radius: 15px;
      margin-bottom: 25px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 30px;
    }

    /* Card Total Admin */
    .welcome-left {
      background: #fff;
      padding: 20px;
      border-radius: 15px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      text-align: center;
      min-width: 180px;
    }
    .welcome-left h3 {
      margin: 0 0 10px;
      color: #7b1e1e;
      font-weight: bold;
    }
    .welcome-left p {
      font-size: 28px;
      font-weight: bold;
      color: #333;
      margin: 0;
    }

    /* Teks Welcome */
    .welcome-right {
      flex: 1;
      text-align: center;
    }
    .welcome-right h3 {
      margin: 0;
      font-size: 20px;
      color: #7b1e1e;
      font-weight: bold;
    }
    .welcome-right h1 {
      margin: 5px 0 0;
      font-size: 28px;
      font-weight: bold;
      color: #333;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .welcome-box {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <div class="navbar">
    <i class="fas fa-bars menu-toggle" onclick="toggleSidebar()"></i>
    <h1>Dashboard Admin</h1>
  </div>

  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <div class="profile">
      <img src="<?php echo !empty($data['gambar']) ? './img/'.$data['gambar'] : './img/user.png'; ?>" alt="User">
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
    <div class="welcome-box">
      <!-- Kotak Total Admin -->
      <div class="welcome-left">
        <h3>Total Admin</h3>
        <p><?= $totalAdmin ?></p>
      </div>

      <!-- Tulisan Welcome -->
      <div class="welcome-right">
        <h3>Selamat Datang 
          <a href="profil_admin.php?username=<?= urlencode($username) ?>" style="text-decoration:none;">
            <?= htmlspecialchars($username) ?>
          </a>
        </h3>
        <h1>SMKN 71 JAKARTA</h1>
      </div>
    </div>
  </div>

  <script>
    function toggleSidebar() {
      document.getElementById("sidebar").classList.toggle("active");
    }
  </script>

</body>
</html>