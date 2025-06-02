<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Hapus user
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM user WHERE id = $id");
    header("Location: manage_users.php");
    exit();
}

// Ambil semua user
$users = $conn->query("SELECT * FROM user ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User - NONTONIQ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #ff2c1f;
            --dark-color: #020307;
            --light-color: #ffffff;
            --gray-color: #f5f5f5;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--dark-color);
            color: var(--light-color);
            margin: 0;
            padding: 0;
        }
        
        header {
            padding: 20px;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            color: var(--light-color);
            font-size: 1.5rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .manage-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }
        
        .page-title {
            color: var(--light-color);
            font-size: 2rem;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .users-table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .users-table th {
            background-color: var(--primary-color);
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 500;
        }
        
        .users-table td {
            padding: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .users-table tr:last-child td {
            border-bottom: none;
        }
        
        .users-table tr:hover {
            background: rgba(255, 255, 255, 0.03);
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        
        .edit-btn, .delete-btn {
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .edit-btn {
            background-color: #4CAF50;
            color: white;
        }
        
        .delete-btn {
            background-color: #f44336;
            color: white;
        }
        
        .edit-btn:hover, .delete-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        
        .empty-message {
            text-align: center;
            padding: 30px;
            color: rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body>
    <header>
        <a href="admin_dashboard.php" class="logo">
            <i class="fas fa-film"></i> NONTONIQ - Admin
        </a>
    </header>

    <div class="manage-container">
        <h1 class="page-title">Daftar User</h1>
        
        <table class="users-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Tanggal Daftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($users) > 0): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <?php 
                                if (isset($user['created_at']) && !empty($user['created_at'])) {
                                    echo date('d M Y', strtotime($user['created_at']));
                                } else {
                                    echo '-';
                                }
                                ?>
                            </td>
                            <td class="action-buttons">
                                <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="edit-btn">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="manage_users.php?delete=<?php echo $user['id']; ?>" class="delete-btn" onclick="return confirm('Yakin ingin menghapus user ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="empty-message">Tidak ada data user</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>