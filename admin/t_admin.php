<?php
session_start();
include '../koneksi.php';

// Ambil ID admin yang sedang login dari sesi
$admin_id = $_SESSION['admin_id'];

// Batas data per halaman
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Cek koneksi database
if (!$conn) {
  die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil data admin, kecuali yang sedang login
$result = mysqli_query($conn, "SELECT * FROM admin WHERE id != $admin_id LIMIT $start, $limit");
if (!$result) {
  die("Gagal ambil data admin: " . mysqli_error($conn));
}

// Hitung total data (tanpa admin login)
$total_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM admin WHERE id != $admin_id");
if (!$total_result) {
  die("Gagal hitung data: " . mysqli_error($conn));
}
$total_row = mysqli_fetch_assoc($total_result);
$total_data = $total_row['total'];
$total_page = ceil($total_data / $limit);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Admin</title>
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

    /* Card box */
    .card {
      background: #fff;
      border-radius: 15px;
      padding: 20px;
      margin-top: 20px;
      box-shadow: 2px 8px 16px rgba(0,0,0,0.1);
    }

    .btn-add {
      background: #7b1e1e;
      color: white;
      padding: 10px 18px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      display: inline-block;
      margin-bottom: 15px;
    }
    .btn-add:hover {
      background: #5c1414;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      border-radius: 10px;
      overflow: hidden;
    }
    table thead {
      background: #f5f5f5;
      font-weight: bold;
    }
    table th, table td {
      padding: 12px;
      text-align: center;
      border: 1px solid #ddd;
    }

    .btn-aktif {
      color: green;
      border: 2px solid green;
      padding: 5px 12px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
    }
    .btn-aktif:hover {
      background: green;
      color: white;
    }
    .btn-nonaktif {
      color: #b22222;
      border: 2px solid #b22222;
      padding: 5px 12px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
    }
    .btn-nonaktif:hover {
      background: #b22222;
      color: white;
    }

    .pagination {
      margin-top: 20px;
      display: flex;
      justify-content: center;
      gap: 6px;
      list-style: none;
      padding: 0;
    }

    .pagination li {
      display: inline;
    }

    .pagination a {
      text-decoration: none;
      padding: 8px 14px;
      border: 1px solid #ccc;
      border-radius: 6px;
      color: #333;
      font-weight: 500;
      transition: 0.3s;
    }

    .pagination a:hover {
      background: #ddd;
    }

    .pagination .active a {
      background: #7b1e1e;
      color: white;
      border-color: #7b1e1e;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <div class="navbar">
    <i class="fas fa-bars menu-toggle" onclick="toggleSidebar()"></i>
    <h1>Data Admin</h1>
  </div>

  <!-- Sidebar -->
 <div class="sidebar" id="sidebar">
  <div class="profile">
    <!-- Kalau kolom gambar kosong, tampilkan default user.png -->
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
    <div class="card">
      <a href="create.php" class="btn-add"><i class="fas fa-plus"></i> Tambah Admin</a>
      
      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Admin</th>
            <th>Email</th>
            <th>Level</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) :
        ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['username'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['level'] ?></td>
            <td>
              <?php if ($row['level'] == 'on') : ?>
                <a href="toggle.php?id=<?= $row['id'] ?>&level=off" class="btn-nonaktif">Nonaktifkan</a>
              <?php else: ?>
                <a href="toggle.php?id=<?= $row['id'] ?>&level=on" class="btn-aktif">Aktifkan</a>
              <?php endif; ?>
            </td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>

      <!-- Pagination -->
      <nav>
        <ul class="pagination">
          <?php if ($page > 1): ?>
            <li><a href="?page=<?= $page - 1 ?>">&laquo;</a></li>
          <?php endif; ?>

          <?php for ($i = 1; $i <= $total_page; $i++): ?>
            <li class="<?= ($i == $page) ? 'active' : '' ?>">
              <a href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
          <?php endfor; ?>

          <?php if ($page < $total_page): ?>
            <li><a href="?page=<?= $page + 1 ?>">&raquo;</a></li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
  </div>

  <script>
    function toggleSidebar() {
      document.getElementById("sidebar").classList.toggle("active");
    }

    // Hapus admin otomatis yang level-nya kosong (optional & demo only)
    setTimeout(() => {
      fetch('delate_oto.php')
        .then(response => response.text())
        .then(data => {
          console.log("Respon dari delate_oto.php:", data);
          if (data.includes("berhasil")) {
            location.reload();
          }
        })
        .catch(error => console.error("Gagal auto-delete:", error));
    }, 10000);
  </script>
</body>
</html>
