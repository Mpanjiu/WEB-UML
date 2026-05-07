<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
    
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        if (password_verify($password, $row['password'])) {
            // SIMPAN ROLE KE SESSION
            $_SESSION['id_user'] = $row['id'];
            $_SESSION['nama'] = $row['fullname'];
            $_SESSION['role'] = $row['role']; // <--- Ini yang paling penting
            
            echo "<script>alert('Login Berhasil!'); window.location='index.php';</script>";
            exit;
        }
    }
    $error = "Email atau Password salah!";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SourArts</title>
    <?php
    echo "<link rel='stylesheet' type='text/css' href='styleLogin.css'>";
?>
</head>
<body>
    <div class="wadah-utama">
        <div class="sisi-kiri"></div>
        <div class="sisi-kanan">
            <div class="konten-form">
                <header class="header-form">
                    <p class="nama-perusahaan">SourArts</p>
                    <p class="sub-nama">Creative Industry Platform</p>
                </header>

                <main class="utama-form">
                    <h1 class="judul-halaman">Selamat Datang, Login.</h1>
                    
                    <?php if(isset($error)) : ?>
                        <p style="color: #ff4d4d; font-size: 14px; margin-bottom: 10px;"><?= $error; ?></p>
                    <?php endif; ?>

                    <form action="" method="POST">
                        <div class="grup-input">
                            <label>Email Address:</label>
                            <input type="email" name="email" placeholder="email@sourarts.com" required>
                        </div>
                        <div class="grup-input">
                            <label>Password:</label>
                            <input type="password" name="password" placeholder="Masukkan Password" required>
                        </div>
                        <div class="aksi-bawah">
                            <button type="submit" name="login" class="tombol-masuk">Sign In Here</button>
                            <a href="#" class="link-lupa">Lupa password?</a>
                        </div>
                    </form>
                    <p class="teks-pindah">Belum punya akun? <a href="register.php">Daftar di sini</a></p>
                </main>
            </div>
        </div>
    </div>
</body>
</html>