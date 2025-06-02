<?php
session_start();
require 'koneksi.php';

if (isset($_SESSION['admin'])) {
    header("Location: admin_dashboard.php");
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $email = trim($conn->real_escape_string($email));
    $password = trim($conn->real_escape_string($password));

    $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        
        if ($password === trim($admin['password'])) {
            $_SESSION['admin'] = $admin;
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email admin tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - NONTONIQ</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        }
        
        .login-container h2 {
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
        
        .btn-login {
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
        
        .btn-login:hover {
            background: #e60000;
        }
        
        .back-link {
            text-align: center;
            margin-top: 1rem;
            color: #fff;
        }
        
        .back-link a {
            color: #ff2c1f;
            text-decoration: none;
        }
        
        .error {
            color: #ff2c1f;
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

    <div class="login-container">
        <h2>Login Admin</h2>
        
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form action="admin_login.php" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn-login">Login</button>
        </form>
        
        <div class="back-link">
            <a href="index.php">Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>