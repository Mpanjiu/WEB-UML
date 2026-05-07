<?php
session_start();
include 'koneksi.php';

$sudah_login = isset($_SESSION['id_user']);

// Logika Tambah Komentar
if (isset($_POST['kirim_komentar'])) {
    if (!$sudah_login) {
        echo "<script>alert('Login terlebih dahulu!'); window.location='login.php';</script>";
        exit;
    }
    $id_user = $_SESSION['id_user'];
    $id_karya = $_POST['id_karya'];
    $isi = mysqli_real_escape_string($conn, $_POST['isi_komentar']);
    
    mysqli_query($conn, "INSERT INTO komentar (id_karya, id_user, isi_komentar) VALUES ('$id_karya', '$id_user', '$isi')");
    echo "<script>window.location='album.php';</script>";
}

$query_album = mysqli_query($conn, "SELECT s.*, u.fullname FROM seniman s JOIN users u ON s.id_user = u.id ORDER BY s.id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Album Galeri - SourArts</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* CSS Modal Komentar */
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); overflow-y: auto; }
        .modal-content { background-color: white; margin: 5% auto; padding: 20px; width: 80%; max-width: 800px; border-radius: 15px; display: flex; flex-wrap: wrap; }
        .modal-left { flex: 1; min-width: 300px; }
        .modal-right { flex: 1; min-width: 300px; padding: 0 20px; display: flex; flex-direction: column; }
        .modal-img { width: 100%; border-radius: 10px; object-fit: cover; }
        .close { color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer; }
        .comment-box { border-top: 1px solid #eee; margin-top: 15px; padding-top: 15px; max-height: 300px; overflow-y: auto; }
        .comment-item { margin-bottom: 10px; font-size: 14px; padding: 10px; background: #f9f9f9; border-radius: 8px; }
        .comment-user { font-weight: bold; color: #4A90E2; }
        .comment-form textarea { width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd; margin-top: 10px; }
        .art-card { cursor: pointer; }
    </style>
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

    <section class="gallery-section">
        <h1 style="text-align: center; margin-top: 30px; font-family: 'Playfair Display', serif;">Public Gallery</h1><br>
        <div class="grid-container">
            <?php while ($row = mysqli_fetch_assoc($query_album)) : ?>
                <article class="art-card" onclick="openModal(<?= htmlspecialchars(json_encode($row)); ?>)">
                    <img src="uploads/<?= $row['foto_karya']; ?>" alt="Artwork">
                    <div class="art-info">
                        <span class="art-style-tag"><?= $row['artstyle']; ?></span>
                        <span class="art-artist">@<?= $row['fullname']; ?></span>
                        <p class="art-desc"><?= substr($row['deskripsi'], 0, 50); ?>...</p>
                    </div>
                </article>
            <?php endwhile; ?>
        </div>
    </section>

    <div id="commentModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div class="modal-left">
                <img id="modalImg" src="" class="modal-img">
            </div>
            <div class="modal-right">
                <h3 id="modalTitle">Detail Karya</h3>
                <p id="modalDesc" style="color: #666;"></p>
                
                <h4>Reviews</h4>
                <div id="commentSection" class="comment-box">
                    </div>

                <?php if($sudah_login): ?>
                <form action="" method="POST" class="comment-form">
                    <input type="hidden" name="id_karya" id="modalIdKarya">
                    <textarea name="isi_komentar" placeholder="Tulis ulasan Anda..." required></textarea>
                    <button type="submit" name="kirim_komentar" style="background: black; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer; margin-top: 5px;">Kirim Ulasan</button>
                </form>
                <?php else: ?>
                    <p style="font-size: 12px; margin-top: 10px;"><a href="login.php">Login</a> untuk memberi ulasan.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        function openModal(data) {
            document.getElementById('commentModal').style.display = "block";
            document.getElementById('modalImg').src = "uploads/" + data.foto_karya;
            document.getElementById('modalTitle').innerText = "Karya #" + data.id + " by " + data.fullname;
            document.getElementById('modalDesc').innerText = data.deskripsi;
            document.getElementById('modalIdKarya').value = data.id;

            // Ambil komentar menggunakan Fetch API
            fetch('get_komentar.php?id_karya=' + data.id)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('commentSection').innerHTML = html;
                });
        }

        function closeModal() {
            document.getElementById('commentModal').style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('commentModal')) {
                closeModal();
            }
        }
    </script>
</body>
</html>