<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_POST['update_featured'])) {
    // Reset semua featured status
    $conn->query("UPDATE film SET featured = 0");
    
    // Set featured untuk film yang dipilih
    if (!empty($_POST['featured_films'])) {
        $featured_ids = implode(",", $_POST['featured_films']);
        $conn->query("UPDATE film SET featured = 1 WHERE id IN ($featured_ids)");
    }
    
    header("Location: manage_featured.php?success=1");
    exit();
}

$films = $conn->query("SELECT * FROM film ORDER BY judul")->fetch_all(MYSQLI_ASSOC);
$featured_films = $conn->query("SELECT id FROM film WHERE featured = 1")->fetch_all(MYSQLI_ASSOC);
$featured_ids = array_column($featured_films, 'id');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Film Featured</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="admin-container">
        <h1>Kelola Film Featured</h1>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="alert success">Film featured berhasil diperbarui!</div>
        <?php endif; ?>
        
        <form method="post">
            <div class="film-grid">
                <?php foreach ($films as $film): ?>
                    <div class="film-item">
                        <label>
                            <input type="checkbox" name="featured_films[]" value="<?= $film['id'] ?>" 
                                <?= in_array($film['id'], $featured_ids) ? 'checked' : '' ?>>
                            <?= $film['judul'] ?> (<?= $film['genre'] ?>)
                        </label>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="submit" name="update_featured" class="btn">Update Featured Films</button>
        </form>
    </div>
</body>
</html>