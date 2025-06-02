<?php
session_start();
require 'koneksi.php';

$id = $_GET['id'] ?? 0;
$film = $conn->query("SELECT * FROM film WHERE id = $id")->fetch_assoc();

if (!$film) {
    header("Location: index.php");
    exit();
}

// Proses rating
if (isset($_SESSION['user']) && isset($_POST['rating'])) {
    $user_id = $_SESSION['user']['id'];
    $rating = $_POST['rating'];
    
    // Cek apakah user sudah memberikan rating sebelumnya
    $existing_rating = $conn->query("SELECT id FROM user_ratings WHERE user_id = $user_id AND film_id = $id")->fetch_assoc();
    
    if ($existing_rating) {
        // Update rating
        $conn->query("UPDATE user_ratings SET rating = $rating WHERE id = {$existing_rating['id']}");
    } else {
        // Insert rating baru
        $conn->query("INSERT INTO user_ratings (user_id, film_id, rating) VALUES ($user_id, $id, $rating)");
    }
    
    // Hitung ulang rating rata-rata
    $avg_rating = $conn->query("SELECT AVG(rating) as avg FROM user_ratings WHERE film_id = $id")->fetch_assoc()['avg'];
    $conn->query("UPDATE film SET rating = $avg_rating WHERE id = $id");
    
    header("Location: film_detail.php?id=$id");
    exit();
}

// Proses komentar
if (isset($_SESSION['user']) && isset($_POST['comment'])) {
    $user_id = $_SESSION['user']['id'];
    $comment = $conn->real_escape_string($_POST['comment']);
    
    $conn->query("INSERT INTO discussions (film_id, user_id, comment) VALUES ($id, $user_id, '$comment')");
    
    header("Location: film_detail.php?id=$id");
    exit();
}

// Ambil rating user saat ini (jika sudah login)
$user_rating = 0;
if (isset($_SESSION['user'])) {
    $user_id = $_SESSION['user']['id'];
    $rating_result = $conn->query("SELECT rating FROM user_ratings WHERE user_id = $user_id AND film_id = $id");
    if ($rating_result->num_rows > 0) {
        $user_rating = $rating_result->fetch_assoc()['rating'];
    }
}

// Ambil semua komentar
$comments = $conn->query("
    SELECT d.*, u.username 
    FROM discussions d 
    JOIN user u ON d.user_id = u.id 
    WHERE d.film_id = $id 
    ORDER BY d.created_at DESC
")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $film['judul']; ?> - NONTONIQ</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* body {
            padding-top: 70px !important;
        } */
        .film-detail-container {
            max-width: 968px;
            margin: 20px auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        
        .film-header {
            display: flex;
            gap: 30px;
            margin-bottom: 2rem;
        }
        
        .film-poster {
            flex: 0 0 300px;
        }
        
        .film-poster img {
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        }
        
        .film-info {
            flex: 1;
            color: #fff;
        }
        
        .film-title {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            color: #ff2c1f;
        }
        
        .film-meta {
            display: flex;
            gap: 20px;
            margin-bottom: 1rem;
            color: #ccc;
        }
        
        .film-rating {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .stars {
            color: #ffc107;
            font-size: 1.5rem;
            margin-right: 10px;
        }
        
        .rating-text {
            font-size: 1.2rem;
        }
        
        .film-description {
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .rating-section, .comments-section {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .section-title {
            color: #fff;
            margin-bottom: 1.5rem;
            font-size: 1.5rem;
        }
        
        .rating-form {
            margin-bottom: 2rem;
        }
        
        .star-rating {
            direction: rtl;
            display: inline-block;
        }
        
        .star-rating input[type="radio"] {
            display: none;
        }
        
        .star-rating label {
            color: #ccc;
            font-size: 2rem;
            padding: 0 5px;
            cursor: pointer;
        }
        
        .star-rating input[type="radio"]:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #ffc107;
        }
        
        .comment-form textarea {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.9);
            margin-bottom: 1rem;
            min-height: 100px;
        }
        
        .comment-form button {
            padding: 10px 20px;
            background: #ff2c1f;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        
        .comments-list {
            margin-top: 2rem;
        }
        
        .comment {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 1rem;
        }
        
        .comment-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            color: #ff2c1f;
        }
        
        .comment-user {
            font-weight: bold;
        }
        
        .comment-date {
            color: #ccc;
            font-size: 0.8rem;
        }
        
        .comment-text {
            color: #fff;
            line-height: 1.5;
        }
        
        .login-prompt {
            color: #fff;
            margin-bottom: 1rem;
            padding: 10px;
            background: rgba(255, 44, 31, 0.2);
            border-radius: 5px;
        }
        
        .login-prompt a {
            color: #ff2c1f;
            text-decoration: none;
            font-weight: bold;
        }

        
    body {
        padding-top: 70px !important;
        font-family: 'Poppins', sans-serif;
        color: #fff;
        background: #0f0f1a;
    }
    
    .film-title {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        color: #ff2c1f;
        font-weight: 700;
    }
    
    .film-meta {
        display: flex;
        gap: 20px;
        margin-bottom: 1rem;
        color: #ccc;
        font-weight: 500;
    }
    
    .section-title {
        color: #fff;
        margin-bottom: 1.5rem;
        font-size: 1.5rem;
        font-weight: 600;
    }
    
    .film-description {
        margin-bottom: 2rem;
        line-height: 1.6;
        font-weight: 400;
    }
    
    .comment-user {
        font-weight: 600;
    }
    
    .comment-text {
        color: #fff;
        line-height: 1.5;
        font-weight: 400;
    }
    
    
    .rating-form button, .comment-form button {
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
    }

    /* Gaya tombol Kirim Rating */
    .rating-form button {
        padding: 10px 20px;
        background: #ff2c1f; 
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        font-weight: 500;
        font-size: 1rem;
        transition: all 0.3s ease;
        margin-top: 10px;
    }
    
    .rating-form button:hover {
        background: #e0261a; /* Warna lebih gelap saat hover */
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    
    .rating-form button:active {
        transform: translateY(0);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
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
            <li><a href="index.php#genre">Genre</a></li>
        </ul>
        
        <?php if (isset($_SESSION['user'])): ?>
            <a href="logout_users.php" class="btn">Logout</a>
        <?php else: ?>
            <a href="login.php" class="btn">Sign In</a>
        <?php endif; ?>
    </header>

    <div class="film-detail-container">
        <div class="film-header">
            <div class="film-poster">
                <img src="img/<?php echo $film['gambar']; ?>" alt="<?php echo $film['judul']; ?>">
            </div>
            
            <div class="film-info">
                <h1 class="film-title"><?php echo $film['judul']; ?></h1>
                
                <div class="film-meta">
                    <span><?php echo $film['durasi']; ?></span>
                    <span><?php echo $film['genre']; ?></span>
                    <span>Rating: <?php echo number_format($film['rating'], 1); ?>/5</span>
                </div>
                
                <div class="film-rating">
                    <div class="stars">
                        <?php
                        $full_stars = floor($film['rating']);
                        $half_star = ($film['rating'] - $full_stars) >= 0.5;
                        $empty_stars = 5 - $full_stars - ($half_star ? 1 : 0);
                        
                        for ($i = 0; $i < $full_stars; $i++) {
                            echo '<i class="fas fa-star"></i>';
                        }
                        
                        if ($half_star) {
                            echo '<i class="fas fa-star-half-alt"></i>';
                        }
                        
                        for ($i = 0; $i < $empty_stars; $i++) {
                            echo '<i class="far fa-star"></i>';
                        }
                        ?>
                    </div>
                    <div class="rating-text">
                        <?php echo number_format($film['rating'], 1); ?> dari 5 (berdasarkan <?php 
                        $rating_count = $conn->query("SELECT COUNT(*) as total FROM user_ratings WHERE film_id = $id")->fetch_assoc()['total'];
                        echo $rating_count;
                        ?> rating)
                    </div>
                </div>
                
                <div class="film-description">
                    <?php echo nl2br($film['deskripsi'] ?? 'Deskripsi tidak tersedia.'); ?>
                </div>
            </div>
        </div>
        
        <div class="rating-section">
            <h2 class="section-title">Berikan Rating</h2>
            
            <?php if (isset($_SESSION['user'])): ?>
                <form class="rating-form" method="post">
                    <div class="star-rating">
                        <input type="radio" id="star5" name="rating" value="5" <?php echo $user_rating == 5 ? 'checked' : ''; ?>>
                        <label for="star5" title="5 stars"><i class="fas fa-star"></i></label>
                        
                        <input type="radio" id="star4" name="rating" value="4" <?php echo $user_rating == 4 ? 'checked' : ''; ?>>
                        <label for="star4" title="4 stars"><i class="fas fa-star"></i></label>
                        
                        <input type="radio" id="star3" name="rating" value="3" <?php echo $user_rating == 3 ? 'checked' : ''; ?>>
                        <label for="star3" title="3 stars"><i class="fas fa-star"></i></label>
                        
                        <input type="radio" id="star2" name="rating" value="2" <?php echo $user_rating == 2 ? 'checked' : ''; ?>>
                        <label for="star2" title="2 stars"><i class="fas fa-star"></i></label>
                        
                        <input type="radio" id="star1" name="rating" value="1" <?php echo $user_rating == 1 ? 'checked' : ''; ?>>
                        <label for="star1" title="1 star"><i class="fas fa-star"></i></label>
                    </div>
                    
                    <button type="submit">Kirim Rating</button>
                </form>
            <?php else: ?>
                <div class="login-prompt">
                    Silakan <a href="login.php">login</a> untuk memberikan rating.
                </div>
            <?php endif; ?>
        </div>
        
        <div class="comments-section">
            <h2 class="section-title">Diskusi Film</h2>
            
            <?php if (isset($_SESSION['user'])): ?>
                <form class="comment-form" method="post">
                    <textarea name="comment" placeholder="Tulis komentar Anda..." required></textarea>
                    <button type="submit">Kirim Komentar</button>
                </form>
            <?php else: ?>
                <div class="login-prompt">
                    Silakan <a href="login.php">login</a> untuk berpartisipasi dalam diskusi.
                </div>
            <?php endif; ?>
            
            <div class="comments-list">
                <?php foreach ($comments as $comment): ?>
                    <div class="comment">
                        <div class="comment-header">
                            <span class="comment-user"><?php echo $comment['username']; ?></span>
                            <span class="comment-date"><?php echo date('d M Y H:i', strtotime($comment['created_at'])); ?></span>
                        </div>
                        <div class="comment-text">
                            <?php echo nl2br(htmlspecialchars($comment['comment'])); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <?php if (empty($comments)): ?>
                    <div style="color: #fff; text-align: center;">Belum ada komentar. Jadilah yang pertama berkomentar!</div>
                <?php endif; ?>
            </div>
        </div>
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