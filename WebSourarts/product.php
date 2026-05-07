<?php
session_start();
include 'koneksi.php';

// Cek status login untuk navbar
$sudah_login = isset($_SESSION['id_user']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
     <header class="navbar">
        <div class="logo">SourArts</div>
        
        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <nav>
            <ul class="nav-links" id="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="product.php">Product</a></li>
                <li><a href="album.php">Album</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="artist.php">Artist</a></li>
                <li><a href="<?= $sudah_login ? 'profile.php' : 'login.php'; ?>">Profile</a>
            <?php if($sudah_login): ?></li>
                <a href="logout.php" style="color: red;">Logout</a>
            <?php endif; ?>
            </ul>
        </nav>
    </header>


</body>
</html>