<?php
include 'koneksi.php';

if (isset($_POST['register'])) {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $role = $_POST['role']; // Ambil nilai role (0 atau 1)
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $cek_email = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
    if (mysqli_num_rows($cek_email) > 0) {
        echo "<script>alert('Email sudah terdaftar!');</script>";
    } else {
        // Masukkan role ke dalam query INSERT
        $sql = "INSERT INTO users (fullname, email, password, role) VALUES ('$fullname', '$email', '$password', '$role')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Berhasil Daftar! Silahkan Login.'); window.location='login.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SourArts</title>
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
                    <p class="nama-perusahaan">SourArts™</p>
                    <p class="sub-nama">Creative Industry Platform</p>
                </header>

                <main class="utama-form">
                    <h1 class="judul-halaman">Buat Akun Baru Mu.</h1>
                    <form action="" method="POST">
                        <div class="grup-input">
                            <label>Full Name:</label>
                            <input type="text" name="fullname" placeholder="Nama Lengkap" required>
                        </div>
                        <div class="grup-input">
                            <label>Email Address:</label>
                            <input type="email" name="email" placeholder="email@sourarts.com" required>
                        </div>
                        <div class="grup-input">
                            <label>Password:</label>
                            <input type="password" name="password" placeholder="Buat Password" required>
                        </div>
                        <div class="grup-input">
    <label>Daftar Sebagai:</label>
    <select name="role" required style="width: 100%; padding: 15px; border-radius: 50px; background: #f0f0f0; border: none; outline: none;">
        <option value="0">User Biasa (Penikmat Seni)</option>
        <option value="1">Seniman (Pembuat Karya)</option>
    </select>
</div>
                        <div class="aksi-bawah">
                            <button type="submit" name="register" class="tombol-masuk">Register Now</button>
                        </div>
                    </form>
                    <p class="teks-pindah">Sudah punya akun? <a href="login.php">Login di sini</a></p>
                </main>
            </div>
        </div>
    </div>
</body>
</html>