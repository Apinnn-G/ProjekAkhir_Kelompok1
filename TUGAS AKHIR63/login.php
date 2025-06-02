<?php
session_start();
require 'koneksi.php';

if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($password === $user['password']) { // Tanpa hashing (tidak aman untuk produksi)
            $_SESSION['user'] = $user;
            header("Location: index.php");
            exit();
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - NONTONIQ</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
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
        
        .register-link {
            text-align: center;
            margin-top: 1rem;
            color: #fff;
        }
        
        .register-link a {
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
        <h2>Login User</h2>
        
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form action="login.php" method="POST">
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
        
        <div class="register-link">
            Belum memiliki akun? <a href="register.php">Buat akun</a>
        </div>
    </div>
</body>
</html>