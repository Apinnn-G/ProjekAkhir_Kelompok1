<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Tambah film baru
if (isset($_POST['add_film'])) {
    $judul = $_POST['judul'];
    $durasi = $_POST['durasi'];
    $genre = $_POST['genre'];
    $deskripsi = $_POST['deskripsi'];
    
    // Upload gambar
    $gambar = '';
    if ($_FILES['gambar']['name']) {
        $target_dir = "img/";
        $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
        move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);
        $gambar = $_FILES["gambar"]["name"];
    }
    
    $stmt = $conn->prepare("INSERT INTO film (judul, durasi, genre, gambar, deskripsi) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $judul, $durasi, $genre, $gambar, $deskripsi);
    $stmt->execute();
}

// Hapus film
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM film WHERE id = $id");
    header("Location: manage_films.php");
    exit();
}

// Ambil semua film
$films = $conn->query("SELECT * FROM film ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Film - NONTONIQ</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <style>
        .manage-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        
        .form-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 2rem;
        }
        
        .form-container h3 {
            color: #fff;
            margin-bottom: 1rem;
        }
        
        .form-group {
            margin-bottom: 1rem;
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
        
        .films-list {
            margin-top: 2rem;
        }
        
        .films-list h3 {
            color: #fff;
            margin-bottom: 1rem;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.1);
        }
        
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
        }
        
        th {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .action-btn {
            padding: 5px 10px;
            margin-right: 5px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        
        .edit-btn {
            background: #4CAF50;
            color: white;
        }
        
        .delete-btn {
            background: #f44336;
            color: white;
        }
        
        .film-image {
            width: 100px;
            height: auto;
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

    <div class="manage-container">
        <div class="form-container">
            <h3>Tambah Film Baru</h3>
            <form action="manage_films.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="judul">Judul Film</label>
                    <input type="text" id="judul" name="judul" required>
                </div>
                
                <div class="form-group">
                    <label for="durasi">Durasi</label>
                    <input type="text" id="durasi" name="durasi" required>
                </div>
                
                <div class="form-group">
                    <label for="genre">Genre</label>
                    <input type="text" id="genre" name="genre" required>
                </div>
                
                <div class="form-group">
                    <label for="gambar">Poster Film</label>
                    <input type="file" id="gambar" name="gambar" accept="image/*" required>
                </div>
                
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" required></textarea>
                    <script>
                        CKEDITOR.replace('deskripsi');
                    </script>
                </div>
                
                <button type="submit" name="add_film" class="btn-submit">Tambah Film</button>
            </form>
        </div>
        
        <div class="films-list">
            <h3>Daftar Film</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Poster</th>
                        <th>Judul</th>
                        <th>Durasi</th>
                        <th>Genre</th>
                        <th>Rating</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($films as $film): ?>
                        <tr>
                            <td><?php echo $film['id']; ?></td>
                            <td><img src="img/<?php echo $film['gambar']; ?>" alt="<?php echo $film['judul']; ?>" class="film-image"></td>
                            <td><?php echo $film['judul']; ?></td>
                            <td><?php echo $film['durasi']; ?></td>
                            <td><?php echo $film['genre']; ?></td>
                            <td><?php echo $film['rating']; ?></td>
                            <td>
                                <a href="edit_film.php?id=<?php echo $film['id']; ?>" class="action-btn edit-btn">Edit</a>
                                <a href="manage_films.php?delete=<?php echo $film['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>