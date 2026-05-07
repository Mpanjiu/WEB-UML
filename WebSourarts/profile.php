<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}
// Cek status login untuk navbar
$sudah_login = isset($_SESSION['id_user']);

$id_user = $_SESSION['id_user'];
$nama    = $_SESSION['nama'];
$role    = $_SESSION['role'];

// 1. Ambil Data User Terbaru (termasuk foto_profil)
// Ambil daftar karya yang sudah diposting oleh user ini (jika dia seniman)
$query_karya = mysqli_query($conn, "SELECT * FROM seniman WHERE id_user = '$id_user' ORDER BY id DESC");
$query_user = mysqli_query($conn, "SELECT email, foto_profil FROM users WHERE id = '$id_user'");
$data_user = mysqli_fetch_assoc($query_user);
$email = $data_user['email'];
$foto_profil = $data_user['foto_profil'] ? $data_user['foto_profil'] : 'default_avatar.png';

// 2. LOGIKA GANTI FOTO PROFIL
if (isset($_POST['update_avatar'])) {
    $nama_file = $_FILES['avatar']['name'];
    $tmp_name  = $_FILES['avatar']['tmp_name'];
    $ekstensi_valid = ['jpg', 'jpeg', 'png'];
    $ekstensi_gambar = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

    if (in_array($ekstensi_gambar, $ekstensi_valid)) {
        $nama_file_baru = "avatar_" . $id_user . "_" . time() . "." . $ekstensi_gambar;
        
        if (!is_dir('uploads/avatars')) mkdir('uploads/avatars', 0777, true);

        if (move_uploaded_file($tmp_name, 'uploads/avatars/' . $nama_file_baru)) {
            // Update database
            mysqli_query($conn, "UPDATE users SET foto_profil = '$nama_file_baru' WHERE id = '$id_user'");
            echo "<script>alert('Foto profil berhasil diperbarui!'); window.location='profile.php';</script>";
        }
    } else {
        echo "<script>alert('Format gambar tidak valid!');</script>";
    }
}



// 3. LOGIKA UPLOAD KARYA (Seniman)
if (isset($_POST['upload_karya'])) {
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $artstyle  = $_POST['artstyle'];
    $nama_file = $_FILES['foto']['name'];
    $tmp_name  = $_FILES['foto']['tmp_name'];
    
    $ekstensi_valid = ['jpg', 'jpeg', 'png'];
    $ekstensi_gambar = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

    if (in_array($ekstensi_gambar, $ekstensi_valid)) {
        $nama_file_baru = uniqid() . '.' . $ekstensi_gambar;
        if (!is_dir('uploads')) mkdir('uploads');

        if (move_uploaded_file($tmp_name, 'uploads/' . $nama_file_baru)) {
            $query = "INSERT INTO seniman (id_user, foto_karya, deskripsi, artstyle) 
                      VALUES ('$id_user', '$nama_file_baru', '$deskripsi', '$artstyle')";
            if (mysqli_query($conn, $query)) {
                echo "<script>alert('Karya berhasil diposting!'); window.location='profile.php';</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - SourArts</title>
     <?php
    echo "<link rel='stylesheet' type='text/css' href='styleProfile.css'>";
     echo "<link rel='stylesheet' type='text/css' href='style.css'>";
?>
<style></style>
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

    <div class="profile-container">
        <div class="cover-photo"></div>

        <div class="avatar-section">
            <div class="avatar-wrapper">
                <?php 
                    $path_foto = "uploads/avatars/" . $foto_profil;
                    $display_foto = (file_exists($path_foto) && $foto_profil != 'default_avatar.png') ? $path_foto : 'https://via.placeholder.com/150';
                ?>
                <img src="<?= $display_foto; ?>" class="avatar-img" id="profile-preview">
                
                <form action="" method="POST" enctype="multipart/form-data" id="form-avatar">
                    <label for="file-avatar" class="change-photo-label">Change</label>
                    <input type="file" name="avatar" id="file-avatar" onchange="document.getElementById('form-avatar').submit();">
                    <input type="hidden" name="update_avatar">
                </form>
            </div>

            <div class="user-meta">
                <h2><?= htmlspecialchars($nama); ?></h2>
                <p><?= ($role == 1) ? 'Artist' : 'Pengguna'; ?> @ SourArts</p>
            </div>
        </div>

        <div class="details-list">
            <div class="detail-item">
                <span class="detail-label">Email</span>
                <span class="detail-value"><?= htmlspecialchars($email); ?></span>
                <a href="#" class="edit-link">Edit</a>
            </div>
            <div class="detail-item">
                <span class="detail-label">Subscription Type</span>
                <span class="detail-value"><?= ($role == 1) ? 'Artist Pro' : 'Basic User'; ?> <a href="#" style="color:var(--primary-blue); font-size:12px; margin-left:10px;">Upgrade</a></span>
                <a href="#" class="edit-link">Edit</a>
            </div>
            <div class="detail-item">
                <span class="detail-label">Password</span>
                <span class="detail-value">********</span>
                <a href="#" class="edit-link">Edit</a>
            </div>
        </div>

        <?php if ($role == 1) : ?>
            <div class="artist-section">
                <h3>Post New Artwork</h3>
                <form action="" method="POST" enctype="multipart/form-data">
                    <label>Select Image</label>
                    <input type="file" name="foto" required>
                    <label>Description</label>
                    <textarea name="deskripsi" placeholder="Describe your art..." required></textarea>
                    <label>Style</label>
                    <select name="artstyle">
                        <option value="Landscape">Landscape</option>
                        <option value="Still-Life">Still-Life</option>
                        <option value="Abstract">Abstract</option>
                        <option value="City-scape">City-scape</option>
                    </select>
                    <button type="submit" name="upload_karya" class="btn-black">Publish Artwork</button>
                </form>
            </div>
        <?php endif; ?>
    </div>

  <?php if ($role == 1) : ?>
        <div class="gallery-section">
            <div class="gallery-header">
                <h3>My Portfolio</h3>
                <span style="color: var(--text-muted); font-size: 14px;"><?= mysqli_num_rows($query_karya); ?> Artworks</span>
            </div>

            <div class="gallery-grid">
                <?php 
                if ($query_karya && mysqli_num_rows($query_karya) > 0) : 
                    while ($karya = mysqli_fetch_assoc($query_karya)) : 
                ?>
                    <div class="gallery-item">
                        <img src="uploads/<?= $karya['foto_karya']; ?>" class="gallery-img">
                        <div class="gallery-content">
                            <span class="tag"><?= htmlspecialchars($karya['artstyle']); ?></span>
                            <p><?= htmlspecialchars($karya['deskripsi']); ?></p>
                        </div>
                    </div>
                <?php 
                    endwhile; 
                else : 
                ?>
                    <div class="no-data" style="grid-column: 1 / -1; text-align:center;">
                        <p>Belum ada karya atau terjadi kesalahan pada database.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
        
</body>
</html>