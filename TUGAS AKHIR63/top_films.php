<?php
session_start();
require 'koneksi.php';

// Periksa koneksi database
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Query untuk mendapatkan film terbaik
$query = "
    SELECT f.id, f.judul, f.durasi, f.genre, f.gambar, 
           COALESCE(AVG(ur.rating), 0) as avg_rating,
           COUNT(ur.id) as rating_count 
    FROM film f 
    LEFT JOIN user_ratings ur ON f.id = ur.film_id 
    GROUP BY f.id 
    ORDER BY avg_rating DESC, rating_count DESC 
    LIMIT 10
";

$result = $conn->query($query);

if (!$result) {
    // Jika error terjadi, tampilkan pesan error
    die("Error dalam query: " . $conn->error);
}

$top_films = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $top_films[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top 10 Film - NONTONIQ</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            padding-top: 70px !important;
        }
        .top-films-container {
            max-width: 968px;
            margin: 20px auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        
        .top-films-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .top-films-header h1 {
            color: #ff2c1f;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
        
        .top-films-header p {
            color: #ccc;
        }
        
        .top-films-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 20px;
        }
        
        .top-film-item {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s;
            position: relative;
        }
        
        .top-film-item:hover {
            transform: translateY(-10px);
        }
        
        .top-film-poster {
            width: 100%;
            height: 270px;
            overflow: hidden;
        }
        
        .top-film-poster img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .top-film-info {
            padding: 15px;
        }
        
        .top-film-title {
            color: #fff;
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }
        
        .top-film-meta {
            display: flex;
            justify-content: space-between;
            color: #ccc;
            font-size: 0.8rem;
            margin-bottom: 0.5rem;
        }
        
        .top-film-rating {
            display: flex;
            align-items: center;
            color: #ffc107;
        }
        
        .top-film-rating i {
            margin-right: 5px;
        }
        
        .rank-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #ff2c1f;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body>
    <header>
        <a href="index.php" class="logo">
            <i class='bx bx-movie'></i> NONTONIQ
        </a>
        <div class="bx bx-menu" id="menu-icon"></div>

        <!-- Menu -->
        <ul class="navbar">
            <li><a href="index.php#home" class="home-active">Home</a></li>
            <li><a href="index.php#movies">Movies</a></li>
            <li><a href="top_films.php">Top Films</a></li>
            <li><a href="index.php#genre">Genre</a></li>
        </ul>
        
        <?php if (isset($_SESSION['user'])): ?>
            <a href="logout_users.php" class="btn">Logout</a>
        <?php else: ?>
            <a href="login.php" class="btn">Signin</a>
        <?php endif; ?>
    </header>

    <div class="top-films-container">
        <div class="top-films-header">
            <h1>Top 10 Film Terbaik</h1>
            <p>Berdasarkan rating dari pengguna NONTONIQ</p>
        </div>
        
        <?php if (empty($top_films)): ?>
            <div style="color: #fff; text-align: center; padding: 20px;">
                Belum ada data rating film. Jadilah yang pertama memberikan rating!
            </div>
        <?php else: ?>
            <div class="top-films-list">
                <?php foreach ($top_films as $index => $film): ?>
                    <a href="film_detail.php?id=<?php echo $film['id']; ?>" class="top-film-item">
                        <div class="rank-badge"><?php echo $index + 1; ?></div>
                        <div class="top-film-poster">
                            <img src="img/<?php echo $film['gambar']; ?>" alt="<?php echo $film['judul']; ?>">
                        </div>
                        <div class="top-film-info">
                            <h3 class="top-film-title"><?php echo $film['judul']; ?></h3>
                            <div class="top-film-meta">
                                <span><?php echo $film['durasi']; ?></span>
                                <span><?php echo $film['genre']; ?></span>
                            </div>
                            <div class="top-film-rating">
                                <i class="fas fa-star"></i>
                                <span><?php echo number_format($film['avg_rating'], 1); ?> (<?php echo $film['rating_count']; ?>)</span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Footer -->
    <section class="footer">
        <a href="#" class="logo">
            <i class='bx bx-movie'></i> NONTONIQ
        </a>
        <div class="social">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
            <a href="#"><i class="fa-brands fa-instagram"></i></a>
            <a href="#"><i class="fa-brands fa-tiktok"></i></a>
        </div>
    </section>
    
    <!-- Copyright -->
    <div class="copyright">
        <p>&#169; NONTONIQ All Right Reserved</p>
    </div>
    
    <script>
        // Highlight menu item saat di-scroll
        window.addEventListener("scroll", function () {
            const header = document.querySelector("header");
            header.classList.toggle("shadow", window.scrollY > 0);
        });
    </script>
</body>
</html>