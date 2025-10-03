<?php
session_start();
include "../koneksi.php"; // Pastikan file koneksi ke database tersedia

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Cek user di database
    $query = "SELECT * FROM admin WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('email atau password salah!'); window.location.href='index.php';</script>";
    }
}
?> 

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      height: 100vh;
      background-color: #706e6e91; /* abu gelap */
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .login-card {
      display: flex;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 6px 20px rgba(0,0,0,0.3);
      width: 700px; /* lebar keseluruhan diperbesar */
      background-color: #f4e3d3; /* cream */
    }

    /* Sisi kiri gambar batik */
    .login-left {
      width: 30%; /* diperlebar sedikit */
      background: url('./img/batikdash.jpg') no-repeat center center;
      background-size: cover;
    }

    /* Sisi kanan form */
    .login-right {
      width: 70%; /* form lebih panjang */
      padding: 40px;
      text-align: center;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .login-right .icon {
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

    .login-right h3 {
      font-weight: bold;
      color: #7b1e1e;
      margin-bottom: 10px;
    }

    .login-right .forgot {
      color: red;
      font-size: 14px;
      margin-bottom: 20px;
      display: block;
    }

    .form-control {
      border-radius: 8px;
      margin-bottom: 15px;
      width: 100%;
      padding: 12px;
    }

    .btn-login {
      background-color: #7b1e1e;
      color: white;
      border-radius: 8px;
      width: 100%;
      padding: 12px;
      font-size: 16px;
      font-weight: bold;
    }

    .btn-login:hover {
      background-color: #5c1515;
    }
  </style>
</head>
<body>

<div class="login-card">
  <!-- kiri -->
  <div class="login-left"></div>

  <!-- kanan -->
  <div class="login-right">
    <div class="icon">
      <i class="fas fa-user"></i>
    </div>
    <h3>Login Admin</h3>
  <a href="lupa_pass.php" class="forgot">Lupa Password</a>


    <form method="POST" action="">
      <input type="email" name="email" class="form-control" placeholder="Email" required>
      <input type="password" name="password" class="form-control" placeholder="Password" required>
      <button type="submit" class="btn btn-login">Login</button>
    </form>
  </div>
</div>

</body>
</html>
