<?php
session_start(); // Memulai sesi untuk mengelola data pengguna yang sedang login
if (!isset($_SESSION['admin_id'])) { // Memeriksa apakah admin_id ada dalam sesi
    header('Location: index.php'); // Jika tidak ada, redirect ke halaman login
    exit(); // Menghentikan eksekusi script lebih lanjut
}

include '../koneksi.php'; // Mengimpor file koneksi ke database

$admin_id = (int) $_SESSION['admin_id']; // Mengambil admin_id dari sesi dan mengkonversinya ke integer
$success = ''; // Variabel untuk menyimpan pesan sukses
$error = ''; // Variabel untuk menyimpan pesan kesalahan

// Ambil data awal admin dari database
$stmt = $conn->prepare("SELECT email, username, password, level FROM admin WHERE id = ?"); // Menyiapkan query untuk mengambil data admin
$stmt->bind_param('i', $admin_id); // Mengikat parameter admin_id ke query
$stmt->execute(); // Menjalankan query
$stmt->bind_result($email, $username, $password_db, $level); // Mengikat hasil query ke variabel
$stmt->fetch(); // Mengambil hasil query
$stmt->close(); // Menutup statement

// Proses pembaruan data jika ada permintaan POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Memeriksa apakah metode permintaan adalah POST
    $new_email = $_POST['email'] ?? ''; // Mengambil email baru dari input form
    $new_username = $_POST['username'] ?? ''; // Mengambil username baru dari input form
    $new_password = $_POST['password'] ?? ''; // Mengambil password baru dari input form

    // Validasi input
    if ($new_email === '' || $new_username === '') { // Memeriksa apakah email atau username kosong
        $error = "Email dan Username tidak boleh kosong!"; // Menyimpan pesan kesalahan
    } else {
        // Cek apakah email baru sudah ada di database
        $check_email_stmt = $conn->prepare("SELECT COUNT(*) FROM admin WHERE email = ? AND id != ?"); // Menyiapkan query untuk memeriksa keberadaan email
        $check_email_stmt->bind_param('si', $new_email, $admin_id); // Mengikat parameter email dan admin_id
        $check_email_stmt->execute(); // Menjalankan query
        $check_email_stmt->bind_result($email_count); // Mengikat hasil query ke variabel
        $check_email_stmt->fetch(); // Mengambil hasil query
        $check_email_stmt->close(); // Menutup statement

        // Memeriksa apakah email sudah ada
        if ($email_count > 0) { // Jika ada email yang sama
            $error = "Email sudah digunakan oleh admin lain!"; // Menyimpan pesan kesalahan
        } else {
            // Menyiapkan query untuk memperbarui data admin
            if ($new_password === '') { // Jika password baru tidak diisi
                $up = $conn->prepare("UPDATE admin SET email = ?, username = ? WHERE id = ?"); // Query untuk memperbarui email dan username
                $up->bind_param('ssi', $new_email, $new_username, $admin_id); // Mengikat parameter
            } else { // Jika password baru diisi
                $up = $conn->prepare("UPDATE admin SET email = ?, username = ?, password = ? WHERE id = ?"); // Query untuk memperbarui email, username, dan password
                $up->bind_param('sssi', $new_email, $new_username, $new_password, $admin_id); // Mengikat parameter
            }

            // Menjalankan query pembaruan
            if ($up->execute()) { // Jika eksekusi berhasil
                $success = "Profil berhasil diperbarui."; // Menyimpan pesan sukses
                $_SESSION['username'] = $new_username; // Memperbarui username di sesi
                $email = $new_email; // Memperbarui variabel email
                $username = $new_username; // Memperbarui variabel username
                $password_db = $new_password; // Memperbarui variabel password
            } else {
                $error = "Gagal memperbarui profil. " . $conn->error; // Menyimpan pesan kesalahan jika gagal
            }

            $up->close(); // Menutup statement pembaruan
        }
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Profil Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
body {
  min-height: 100vh;
  display: flex;
   background: linear-gradient(135deg, #7b1e1ed6 0%, #c0545496 100%);
  align-items: center;
  justify-content: center;
  padding: 24px;
  font-family: 'Segoe UI', sans-serif;
}

.profile-card {
  width: 100%;
  max-width: 820px;
  border-radius: 18px;
  overflow: hidden;
  box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.profile-cover {
  background: linear-gradient(135deg, #7b1e1e 0%, #a83232 100%);
  height: 140px;
}

.avatar {
  width: 110px;
  height: 110px;
  border-radius: 50%;
  background: #fff;
  margin-top: -55px;
  display: grid;
  place-items: center;
  font-size: 42px;
  font-weight: 700;
  color: #7b1e1e;
  box-shadow: 0 12px 24px rgba(0,0,0,0.15);
  border: 5px solid #8a0707ff; /* aksen emas */
}

.level-badge {
  font-size: .8rem;
  border-radius: 12px;
  padding: 4px 10px;
}

.form-control:focus {
  box-shadow: 0 0 0 2px rgba(123, 30, 30, 0.25);
  border-color: #7b1e1e;
}

.btn-primary {
  background: #7b1e1e;
  border-color: #7b1e1e;
}
.btn-primary:hover {
  background: #5c1515;
  border-color: #5c1515;
}
.btn-outline-secondary {
  color: #7b1e1e;
  border-color: #7b1e1e;
}
.btn-outline-secondary:hover {
  background: #7b1e1e;
  color: white;
}
  </style>
</head>
<body>

<div class="card profile-card">
  <div class="profile-cover"></div>
  <div class="card-body">
    <div class="text-center">
      <div class="avatar" aria-label="Avatar">
        <?php
          $inisial = strtoupper(substr($username, 0, 1));
          echo htmlspecialchars($inisial);
        ?>
      </div>
      <div class="mt-3">
        <h3 class="mb-0">
          <?= htmlspecialchars($username) ?>
          <?php if (!empty($level)): ?>
            <span class="badge bg-<?= $level == 'on' ? 'success' : 'secondary' ?> level-badge">
              Level: <?= htmlspecialchars($level) ?>
            </span>
          <?php endif; ?>
        </h3>
        <div class="text-muted">ID: <?= $admin_id ?></div>
      </div>
    </div>

    <hr>

    <?php if ($success): ?>
      <div class="alert alert-success mt-4" role="alert"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
      <div class="alert alert-danger mt-4" role="alert"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form class="mt-4" method="POST">
      <div class="row g-3">
        <div class="col-md-6">
          <label for="email" class="form-label">Email</label>
          <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>" required>
        </div>
        <div class="col-md-6">
          <label for="username" class="form-label">Username</label>
          <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($username) ?>" required>
        </div>
        <div class="col-md-12">
          <label for="password" class="form-label">Password Baru (opsional)</label>
          <div class="input-group">
            <input type="password" name="password" class="form-control" id="password" placeholder="Kosongkan jika tidak ingin mengganti">
            <button class="btn btn-outline-secondary" type="button" id="togglePass">👁</button>
          </div>
          <div class="form-text">Biarkan kosong jika tidak ingin mengubah password.</div>
        </div>
      </div>

      <div class="d-flex gap-2 mt-4">
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="dashboard.php" class="btn btn-outline-secondary">Kembali ke Dashboard</a>
      </div>
    </form>
  </div>
</div>

<script>
const toggleBtn = document.getElementById('togglePass');
const passInput = document.getElementById('password');
toggleBtn.addEventListener('click', () => {
  const type = passInput.type === 'password' ? 'text' : 'password';
  passInput.type = type;
  toggleBtn.textContent = type === 'password' ? '👁' : '🙈';
});
</script>

</body>
</html>
