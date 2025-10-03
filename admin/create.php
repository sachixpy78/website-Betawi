<?php
session_start();
include '../koneksi.php';

$message = ""; // Untuk menampung pesan kesalahan atau sukses

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Cek apakah email sudah terdaftar
    $cek = mysqli_query($conn, "SELECT * FROM admin WHERE email = '$email'");
    if (mysqli_num_rows($cek) > 0) {
        $message = "<div class='alert alert-danger mt-3'>Email <strong>$email</strong> sudah terdaftar. Silakan gunakan email lain.</div>";
    } else {
     $password = $_POST['password'];


        $query = "INSERT INTO admin (email, username, password, level) 
                  VALUES ('$email', '$username', '$password', 'off')";

        if (mysqli_query($conn, $query)) {
            header("Location: t_admin.php?msg=sukses");
            exit();
        } else {
            $message = "<div class='alert alert-danger mt-3'>Gagal menambahkan admin. Silakan coba lagi.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: url('../assets/img/batik-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Header Bar */
        .header-bar {
  background: #7b1e1e;
  padding: 33px;
  color: white;
  font-size: 24px;
  font-weight: bold;
  text-align: center;
  margin-left: -2rem;   /* nutup padding dari .content */
  margin-right: -2rem;  /* nutup padding dari .content */
  margin-top: -2rem;    /* nutup padding atas .content */
  border-radius: 0;     /* full kotak, tanpa lengkung */
}

        .header-bar h4 {
            margin: 0;
            font-weight: 600;
        }

        .header-bar .back-btn {
            position: absolute;
            left: 15px;
            font-size: 20px;
            color: white;
            text-decoration: none;
        }

        .header-bar .send-icon {
            position: absolute;
            right: 15px;
            font-size: 20px;
            color: white;
        }

        /* Card Form */
        .form-container {
            background-color: #f9f3f3; /* soft cream/pink */
            max-width: 500px;
            margin: 40px auto;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: #333;
        }

        .form-control {
            border-radius: 8px;
        }

        .btn-primary {
            background-color: #7b1e1e;
            border: none;
            border-radius: 8px;
        }

        .btn-primary:hover {
            background-color: #5c1515;
        }

        .btn-secondary {
            border-radius: 8px;
        }
    </style>
</head>
<body>

    <!-- Header Bar -->
    <div class="header-bar">
        <h4>Tambah Admin</h4>
     
    </div>

    <!-- Form -->
    <div class="form-container">
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary me-md-2">Submit</button>
                <a href="t_admin.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>

</body>
</html>
