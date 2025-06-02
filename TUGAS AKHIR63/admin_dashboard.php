<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$user_count = $conn->query("SELECT COUNT(*) as total FROM user")->fetch_assoc()['total'];

$film_count = $conn->query("SELECT COUNT(*) as total FROM film")->fetch_assoc()['total'];

$top_films = $conn->query("
    SELECT f.judul, COALESCE(AVG(ur.rating), 0) as avg_rating 
    FROM film f
    LEFT JOIN user_ratings ur ON f.id = ur.film_id
    GROUP BY f.id
    ORDER BY avg_rating DESC 
    LIMIT 5
")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - NONTONIQ</title>
    <link rel="stylesheet" href="style.css">
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
        
        .dashboard-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }
        
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .dashboard-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--light-color);
            margin: 0;
        }
        
        .logout-btn {
            padding: 10px 20px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            background: #e60000;
            transform: translateY(-2px);
        }
        
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 3rem;
        }
        
        .stat-card {
            background: rgba(255, 255, 255, 0.05);
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        
        .stat-card h3 {
            margin-bottom: 10px;
            font-size: 1.1rem;
            font-weight: 500;
            color: rgba(255,255,255,0.7);
        }
        
        .stat-card p {
            font-size: 2.5rem;
            font-weight: 600;
            margin: 0;
            color: var(--primary-color);
        }
        
        .admin-nav {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 3rem;
        }
        
        .admin-nav a {
            padding: 12px 25px;
            background: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .admin-nav a:hover {
            background: #e60000;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        
        .top-films {
            background: rgba(255, 255, 255, 0.05);
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 2rem;
        }
        
        .section-title {
            color: var(--light-color);
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
            font-weight: 600;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .film-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 20px;
        }
        
        .film-item {
            background: rgba(0, 0, 0, 0.3);
            padding: 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .film-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }
        
        .film-item h4 {
            color: var(--light-color);
            margin: 0 0 8px 0;
            font-size: 1.1rem;
            font-weight: 500;
        }
        
        .film-item .rating {
            color: #ffc107;
            font-weight: 600;
        }
        
        .film-item .rating-value {
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <header>
        <a href="admin_dashboard.php" class="logo">
            <i class='bx bx-movie'></i> NONTONIQ - Admin
        </a>
    </header>

    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1 class="dashboard-title">Dashboard Admin</h1>
            <form action="logout_admin.php" method="post">
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
        
        <div class="admin-nav">
            <a href="manage_films.php">Kelola Film</a>
            <a href="manage_users.php">Kelola User</a>
        </div>
        
        <div class="stats-container">
            <div class="stat-card">
                <h3>Total User</h3>
                <p><?php echo $user_count; ?></p>
            </div>
            <div class="stat-card">
                <h3>Total Film</h3>
                <p><?php echo $film_count; ?></p>
            </div>
            <div class="stat-card">
                <h3>Admin</h3>
                <p><?php echo $_SESSION['admin']['username']; ?></p>
            </div>
        </div>
        
        <div class="top-films">
            <h3 class="section-title">Film dengan Rating Tertinggi</h3>
            <div class="film-list">
                <?php foreach ($top_films as $film): ?>
                    <div class="film-item">
                        <h4><?php echo $film['judul']; ?></h4>
                        <div class="rating">
                            <span class="rating-value"><?php echo number_format($film['avg_rating'], 1); ?></span>/5
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>