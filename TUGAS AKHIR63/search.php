<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "film"; 
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil keyword dari URL
$keyword = $_GET['keyword'] ?? '';
$keyword = $conn->real_escape_string($keyword);

// Query cari film berdasarkan judul
$sql = "SELECT * FROM film WHERE judul LIKE '%$keyword%'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <title>Hasil Pencarian - NONTONIQ</title>
    <link rel="stylesheet" href="style.css">
    <style>
     .no-results {
        text-align: center;
        color: rgba(255, 255, 255, 0.5);
        font-size: 1.2rem;
        grid-column: 1 / -1;
        padding: 0px;
    }
        /* CSS yang disederhanakan */
    .search-results {
        display: flex;
        flex-direction: column;
        align-items: center; /* Untuk posisi tengah */
        padding: 0px;
    }
    
    .search-item {
        text-align: center;
        margin-bottom: 20px;
        max-width: 200px;
    }
    
    .search-poster {
        width: 100%;
        border-radius: 8px;
    }
    
    .heading {
        text-align: center;
        margin-bottom: 30px;
        font-size: 1.8rem;
        color: white;
        position: relative;
        padding-bottom: 10px;
    }
    
    .heading:after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: #e50914;
    }
    </style>
</head>
<body>
    <header>
        <a href="index.php" class="logo"><i class='bx bx-movie'></i> NONTONIQ</a>
    </header>

    <section class="movies" id="search-results">
        <h2 class="heading">Hasil Pencarian: "<?php echo htmlspecialchars($keyword); ?>"</h2>
        <div class="search-results-container">
            <div class="search-results">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="search-item" onclick="window.location.href='film_detail.php?id=<?php echo $row['id']; ?>'">
                            <img src="img/<?php echo $row['gambar']; ?>" alt="<?php echo $row['judul']; ?>" class="search-poster">
                            <div class="search-info">
                                <h3 class="search-film-title"><?php echo $row['judul']; ?></h3>
                                <p class="search-film-meta"><?php echo $row['durasi']; ?> | <?php echo $row['genre']; ?></p>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="no-results">Tidak ditemukan film yang cocok.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <div class="copyright">
        <p>&#169; NONTONIQ All Right Reserved</p>
    </div>
    <script>
    document.querySelectorAll('.search-item').forEach(item => {
        item.addEventListener('click', function() {
            window.location.href = this.getAttribute('onclick').match(/href='(.*?)'/)[1];
        });
    });
    </script>
</body>
</html>