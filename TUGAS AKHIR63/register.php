<?php
session_start();
require 'koneksi.php';

if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "Semua field harus diisi!";
    } elseif ($password !== $confirm_password) {
        $error = "Password tidak cocok!";
    } elseif (strlen($password) < 6) {
        $error = "Password minimal 6 karakter!";
    } else {
        // Cek apakah email sudah terdaftar
        $stmt = $conn->prepare("SELECT id FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $error = "Email sudah terdaftar!";
        } else {
            // Simpan password tanpa di-hash (TIDAK DISARANKAN untuk produksi)
            $plain_password = $password;
            
            // Insert user baru
            $stmt = $conn->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $plain_password);
            
            if ($stmt->execute()) {
                $success = "Registrasi berhasil! Silakan login.";
            } else {
                $error = "Terjadi kesalahan. Silakan coba lagi.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi User - NONTONIQ</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .register-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        }
        
        .register-container h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #fff;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #fff;
        }
        
        .form-group input {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.9);
        }
        
        .btn-register {
            width: 100%;
            padding: 10px;
            background: #ff2c1f;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.3s;
        }
        
        .btn-register:hover {
            background: #e60000;
        }
        
        .login-link {
            text-align: center;
            margin-top: 1rem;
            color: #fff;
        }
        
        .login-link a {
            color: #ff2c1f;
            text-decoration: none;
        }
        
        .error {
            color: #ff2c1f;
            text-align: center;
            margin-bottom: 1rem;
        }
        
        .success {
            color: #4BB543;
            text-align: center;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <header>
        <a href="index.php" class="logo">
            <i class='bx bx-movie'></i> NONTONIQ
        </a>
    </header>

    <div class="register-container">
        <h2>Registrasi User</h2>
        
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Konfirmasi Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <button type="submit" class="btn-register">Daftar</button>
        </form>
        
        <div class="login-link">
            Sudah memiliki akun? <a href="login.php">Login disini</a>
        </div>
    </div>
</body>
</html>