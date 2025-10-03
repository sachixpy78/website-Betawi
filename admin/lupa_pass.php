<?php
include '../koneksi.php';

$email_verified = false;
$email = "";
$success = "";
$error = "";

// Step 1: cek email
if (isset($_POST['check_email'])) {
    $email = $_POST['email'];
    $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $email_verified = true;
    } else {
        $error = "Email tidak ditemukan!";
    }
}

// Step 2: simpan password baru
if (isset($_POST['change_password'])) {
    $email = $_POST['email'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password != $confirm_password) {
        $error = "Password dan konfirmasi tidak cocok!";
        $email_verified = true;
    } elseif (strlen($new_password) < 3) {
        $error = "Password minimal 3 karakter!";
        $email_verified = true;
    } else {
        $stmt = $conn->prepare("UPDATE admin SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $new_password, $email);

        if ($stmt->execute()) {
            $success = "Password berhasil diubah. Silakan login kembali.";
        } else {
            $error = "Gagal mengubah password.";
        }
        $email_verified = true; 
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Lupa Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      height: 100vh;
      background-color: #706e6e91;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .forgot-card {
     display: flex;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 6px 20px rgba(0,0,0,0.3);
      width: 700px; /* lebar keseluruhan diperbesar */
      background-color: #f4e3d3; /* cream */
    }

    .forgot-left {
     width: 30%; /* diperlebar sedikit */
      background: url('./img/batikdash.jpg') no-repeat center center;
      background-size: cover;
    }

    .forgot-right {
         width: 70%; /* form lebih panjang */
      padding: 40px;
      text-align: center;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .icon {
    width: 80px;
      height: 80px;
      background-color: #7b1e1e; /* maroon */
      color: white;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 0 auto 20px;
      font-size: 32px;
    }

    h3 {
      font-weight: bold;
      color: #7b1e1e;
      margin-bottom: 15px;
    }

    .form-control {
      border-radius: 8px;
      margin-bottom: 12px;
      padding: 10px;
    }

    .btn-main {
      background-color: #7b1e1e;
      color: white;
      border-radius: 6px;
      width: 100%;
      padding: 10px;
      margin-top: 10px;
    }

    .btn-main:hover {
      background-color: #7b1e1e;
    }

    .btn-secondary {
      background-color: #999;
      color: white;
      border-radius: 6px;
      width: 100%;
      padding: 10px;
      margin-top: 10px;
    }

    .alert {
      margin-bottom: 15px;
    }
  </style>
</head>
<body>
  <div class="forgot-card">
    <!-- kiri -->
    <div class="forgot-left"></div>

    <!-- kanan -->
    <div class="forgot-right">
      <div class="icon"><i class="fas fa-user-lock"></i></div>
      <h3>Lupa Password</h3>

      <?php if (!empty($error)): ?>
        <div class="alert alert-danger text-center"><?= $error ?></div>
      <?php endif; ?>

      <?php if (!empty($success)): ?>
        <div class="alert alert-success text-center"><?= $success ?></div>
        <a href="index.php" class="btn btn-main">Kembali ke Login</a>
      <?php elseif (!$email_verified): ?>
        <form method="POST">
          <input type="email" name="email" class="form-control" placeholder="Masukkan Email" required>
          <button type="submit" name="check_email" class="btn btn-main">Lanjut</button>
          <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
      <?php else: ?>
        <form method="POST">
          <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
          <input type="password" name="new_password" class="form-control" placeholder="Password Baru" required>
          <input type="password" name="confirm_password" class="form-control" placeholder="Konfirmasi Password Baru" required>
          <button type="submit" name="change_password" class="btn btn-main">Simpan Password</button>
          <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>
