<?php
session_start();
include 'koneksi.php';

// Cek status login untuk navbar
$sudah_login = isset($_SESSION['id_user']);

// Query untuk mengambil Seniman, Foto Profilnya, dan Style terakhir yang mereka upload
// Kita ambil data unik per user agar satu seniman tidak muncul berulang kali
$query_artist = mysqli_query($conn, "SELECT u.fullname, u.foto_profil, s.artstyle 
                                     FROM users u 
                                     JOIN seniman s ON u.id = s.id_user 
                                     WHERE u.role = 1 
                                     GROUP BY u.id 
                                     ORDER BY s.id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Artists - SourArts</title>
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

    <section class="bagian-tim">
        <div class="kontainer-utama">
            <div class="header-tim">
                <div class="sisi-kiri">
                    <h2 class="judul-utama">Talented Artists <br> Behind SourArts</h2>
                </div>
                <div class="sisi-kanan">
                    <p class="deskripsi-tim">
                        Kenali para seniman berbakat kami. Mereka adalah visioner yang mendedikasikan diri untuk mengekspresikan emosi melalui karya seni yang luar biasa.
                    </p>
                </div>
            </div>

            <div class="grid-anggota">
                <?php 
                if (mysqli_num_rows($query_artist) > 0) {
                    while ($row = mysqli_fetch_assoc($query_artist)) { 
                        // Tentukan path foto profil
                        $foto = $row['foto_profil'];
                        $path_foto = (!empty($foto) && file_exists("uploads/avatars/" . $foto)) 
                                     ? "uploads/avatars/" . $foto 
                                     : "https://via.placeholder.com/500x600?text=No+Photo";
                ?>
                    <div class="kartu-staf">
                        <div class="bingkai-foto">
                            <img src="<?= $path_foto; ?>" alt="<?= htmlspecialchars($row['fullname']); ?>" class="foto-staf">
                        </div>
                        <div class="info-staf">
                            <p class="jabatan"><?= htmlspecialchars($row['artstyle']); ?></p>
                            <h3 class="nama-staf"><?= htmlspecialchars($row['fullname']); ?></h3>
                            <button class="tombol-kontak" style="background: black; color: white; border-radius: 20px; padding: 5px 15px; margin-top: 10px; border: none; cursor: pointer;">
                                View Works
                            </button>
                        </div>
                    </div>
                <?php 
                    } 
                } else {
                    echo "<p style='text-align: center; grid-column: 1/-1;'>Belum ada seniman yang terdaftar.</p>";
                }
                ?>
            </div>
        </div>
    </section>
</body>
</html>