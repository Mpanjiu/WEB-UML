<?php
include 'koneksi.php';

// Query untuk mengambil semua karya dan nama seniman yang mengunggahnya
// Kita menggabungkan tabel seniman (s) dengan tabel users (u) berdasarkan id_user
$query_album = mysqli_query($conn, "SELECT s.*, u.fullname 
                                    FROM seniman s 
                                    JOIN users u ON s.id_user = u.id 
                                    ORDER BY s.id DESC");
?>

<?php
session_start();
include 'koneksi.php';

// Cek status login untuk navbar
$sudah_login = isset($_SESSION['id_user']);
?>



<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Album Galeri - SourArts</title>
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
                <li><a href="#about">About</a></li>
                <li><a href="artist.php">Artist</a></li>
                 <li><a href="<?= $sudah_login ? 'profile.php' : 'login.php'; ?>">Profile</a>
            <?php if($sudah_login): ?></li>
                <a href="logout.php" style="color: red;">Logout</a>
            <?php endif; ?>
            </ul>
        </nav>
    </header>

    <div class="selection-footer-line">
        <div class="nav-line-long"></div>
    </div>

    <section class="gallery-section">
        <h2 style="text-align: center; margin-top: 30px;">Public Gallery</h2>
        <div class="grid-container">
            
            <?php 
            if (mysqli_num_rows($query_album) > 0) {
                while ($row = mysqli_fetch_assoc($query_album)) { 
            ?>
                <article class="art-card">
                    <img src="uploads/<?= $row['foto_karya']; ?>" alt="Artwork">
                    
                    <div class="art-info">
                        <span class="art-style-tag"><?= htmlspecialchars($row['artstyle']); ?></span>
                        <span class="art-artist">@<?= htmlspecialchars($row['fullname']); ?></span>
                        
                        <span class="art-title">Karya #<?= $row['id']; ?></span>
                        <p class="art-desc"><?= nl2br(htmlspecialchars($row['deskripsi'])); ?></p>
                    </div>
                </article>
            <?php 
                }
            } else {
                echo "<p style='text-align:center; grid-column: 1/-1;'>Belum ada karya di dalam album.</p>";
            }
            ?>

        </div>
    </section>

    <script>
        const hamburger = document.getElementById('hamburger');
        const navLinks = document.getElementById('nav-links');
        hamburger.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });
    </script>
</body>
</html>