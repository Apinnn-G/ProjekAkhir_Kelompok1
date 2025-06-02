<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$id = $_GET['id'] ?? 0;
$film = $conn->query("SELECT * FROM film WHERE id = $id")->fetch_assoc();

if (!$film) {
    header("Location: manage_films.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = $_POST['judul'];
    $durasi = $_POST['durasi'];
    $genre = $_POST['genre'];
    $deskripsi = $_POST['deskripsi'];
    
    // Jika ada gambar baru diupload
    if ($_FILES['gambar']['name']) {
        $target_dir = "img/";
        $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
        move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);
        $gambar = $_FILES["gambar"]["name"];
    } else {
        $gambar = $film['gambar'];
    }
    
    $stmt = $conn->prepare("UPDATE film SET judul = ?, durasi = ?, genre = ?, gambar = ?, deskripsi = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $judul, $durasi, $genre, $gambar, $deskripsi, $id);
    $stmt->execute();
    
    header("Location: manage_films.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Film - NONTONIQ</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <style>
        .edit-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        
        .edit-container h2 {
            color: #fff;
            margin-bottom: 1.5rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            color: #fff;
        }
        
        .form-group input, 
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.9);
        }
        
        .btn-submit {
            padding: 10px 20px;
            background: #ff2c1f;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        
        .current-image {
            margin-top: 1rem;
        }
        
        .current-image img {
            max-width: 200px;
            height: auto;
            border: 2px solid #fff;
        }
    </style>
</head>
<body>
    <header>
        <a href="admin_dashboard.php" class="logo">
            <i class='bx bx-movie'></i> NONTONIQ - Admin
        </a>
        <div class="bx bx-menu" id="menu-icon"></div>
    </header>

    <div class="edit-container">
        <h2>Edit Film: <?php echo $film['judul']; ?></h2>
        
        <form action="edit_film.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="judul">Judul Film</label>
                <input type="text" id="judul" name="judul" value="<?php echo $film['judul']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="durasi">Durasi</label>
                <input type="text" id="durasi" name="durasi" value="<?php echo $film['durasi']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="genre">Genre</label>
                <input type="text" id="genre" name="genre" value="<?php echo $film['genre']; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="gambar">Poster Film Baru (kosongkan jika tidak ingin mengubah)</label>
                <input type="file" id="gambar" name="gambar" accept="image/*">
                
                <div class="current-image">
                    <p>Poster Saat Ini:</p>
                    <img src="img/<?php echo $film['gambar']; ?>" alt="<?php echo $film['judul']; ?>">
                </div>
            </div>
            
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" required><?php echo $film['deskripsi']; ?></textarea>
                <script>
                    CKEDITOR.replace('deskripsi');
                </script>
            </div>
            
            <button type="submit" class="btn-submit">Update Film</button>
        </form>
    </div>
</body>
</html>