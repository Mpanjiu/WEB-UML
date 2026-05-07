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
     <?php
    echo "<link rel='stylesheet' type='text/css' href='style.css'>";
?>
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
                <li><a href="#pembuka">Home</a></li>
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

    <section id="pembuka" class="hero">
        <div class="hero-top">
            <h1 class="hero-title">The Arts of <br> Gallery</h1>
            <div class="hero-description">
                <p>Platform berbasis web dengan Berinteraksi jual dan beli jasa gambar antara Artist dan Klien.</p>
                <div class="hero-buttons">
                    <a href="#" class="btn btn-outline">See the Product</a>
                    <a href="#" class="btn btn-outline">Album</a>
                </div>
            </div>
        </div>
        
        <div class="hero-image-container">
            <img src="img/Wind exporeslight.jpg" class="hero-image">
        </div>
    </section>

    <section class="content-section">
        </section>

        <section class="selection-section container">
    <div class="selection-header">
        <h2>What kind of Arts <br> are you looking for?</h2>
        <p>Select the type of residence that suits your lifestyle best — from elegant apartments to luxury villas.</p>
    </div>

    <div class="selection-grid-4">
        <div class="selection-item">
            <div class="image-wrapper">
                <img src="img/landg.jpg" alt="Landscape">
            </div>
            <div class="item-footer">
                <span>Landscape</span>
                <a href="#" class="choose-link">Kunjungi</a>
            </div>
        </div>

        <div class="selection-item">
            <div class="image-wrapper">
                <img src="img/hiu.jpeg" alt="Still-Life">
            </div>
            <div class="item-footer">
                <span>Still-Life</span>
                <a href="#" class="choose-link">Kunjungi</a>
            </div>
        </div>

        <div class="selection-item">
            <div class="image-wrapper">
                <img src="img/Landra2.jpg" alt="Abstract">
            </div>
            <div class="item-footer">
                <span>Abstract</span>
                <a href="#" class="choose-link">Kunjungi</a>
            </div>
        </div>

        <div class="selection-item">
            <div class="image-wrapper">
                <img src="img/justic.jpeg" alt="Cityscape">
            </div>
            <div class="item-footer">
                <span>Cityscape</span>
                <a href="#" class="choose-link">Kunjungi</a>
            </div>
        </div>
    </div>

    <div class="selection-footer-line">
        <div class="nav-line-long"></div>
    </div>
</section>

    <section class="stages-section container">
    <div class="stages-header">
        <h2>The art commission website you’ve been looking for</h2>
    </div>

    <div class="stages-grid">
        <div class="stage-item">
            <div class="stage-top">
                <span class="stage-number">01</span>
                <h3 class="stage-title">Login Akun</h3>
                <span class="stage-time">5 Minutes</span>
            </div>
            <hr class="stage-line">
            <p class="stage-desc">You leave a request and our manager will contact you to discuss the details of the project.</p>
        </div>

        <div class="stage-item">
            <div class="stage-top">
                <span class="stage-number">02</span>
                <h3 class="stage-title">Product</h3>
                <!-- <span class="stage-time">1-5 Days</span> -->
            </div>
            <hr class="stage-line">
            <p class="stage-desc">We make a drawing of the future building, discuss a detailed estimate and prepare a commercial proposal.</p>
        </div>

        <div class="stage-item">
            <div class="stage-top">
                <span class="stage-number">03</span>
                <h3 class="stage-title">Pilih Artist</h3>
                <span class="stage-time">5-10 Days</span>
            </div>
            <hr class="stage-line">
            <p class="stage-desc">After all the conditions of cooperation are approved and the prepayment is made, we start production of the building.</p>
        </div>

        <div class="stage-item">
            <div class="stage-top">
                <span class="stage-number">04</span>
                <h3 class="stage-title">Pembayaran</h3>
                <span class="stage-time">3 Days +</span>
            </div>
            <hr class="stage-line">
            <p class="stage-desc">We deliver the order to the location, install and connect all communications. The building is ready for use.</p>
        </div>
    </div>
</section>


                <section class="bento-section container">
    <div class="bento-grid">
        
        <div class="bento-main-image">
            <div class="badge">Kenapa memilih kami?</div>
            <img src="img/hiu.jpeg">
        </div>

        <div class="stats-grid">
            
            <div class="stat-card">
                <h3>2+</h3>
                <h4>Seniman</h4>
                <p>Membangun berbagai hunian dengan desain dan gaya yang beragam.</p>
            </div>

            <div class="stat-card">
                <h3>22+</h3>
                <h4>Album</h4>
                <p>Telah lama berkecimpung dan dipercaya di industri konstruksi.</p>
            </div>

            <div class="stat-card">
                <h3>98%</h3>
                <h4>Kepuasan</h4>
                <p>Klien kami memberikan kepercayaan dan merekomendasikan layanan kami.</p>
            </div>

            <div class="stat-card">
                <h3>48+</h3>
                <h4>Sell</h4>
                <p>Tim profesional yang siap mewujudkan hunian impian Anda.</p>
            </div>

        </div>
    </div>
</section>

    <section class="contact-section container">
    <div class="contact-title">
        <h2>Hubungi Kami</h2>
    </div>

    <div class="contact-info-grid">
        <div class="info-item">
            <span class="info-label">TELEPON</span>
            <p class="info-detail">+62 51 1234 5678</p>
        </div>
        <div class="info-item">
            <span class="info-label">EMAIL</span>
            <p class="info-detail">Pandjie10@gmail.com</p>
        </div>
        <div class="info-item">
            <span class="info-label">ALAMAT</span>
            <p class="info-detail">Jl. Sampul No.3, Sei Putih Bar., Kec. Medan Petisah, Kota Medan, Sumatera Utara 20118</p>
        </div>
    </div>

    <div class="map-container">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3981.950402196003!2d98.65013487574471!3d3.5988386963752883!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30312fd4e159414d%3A0x2ee9d4c72de475ab!2sUniversitas%20Prima%20Indonesia!5e0!3m2!1sid!2sid!4v1778144396542!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</section>
</body>
</html>

<script>
        const hamburger = document.getElementById('hamburger');
        const navLinks = document.getElementById('nav-links');

        hamburger.addEventListener('click', () => {
            // Toggle Menu
            navLinks.classList.toggle('active');
            // Animasi Hamburger
            hamburger.classList.toggle('toggle');
        });

        // Menutup menu otomatis saat salah satu link diklik
        document.querySelectorAll('.nav-links li a').forEach(link => {
            link.addEventListener('click', () => {
                navLinks.classList.remove('active');
                hamburger.classList.remove('toggle');
            });
        });
    </script>