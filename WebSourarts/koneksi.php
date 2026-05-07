<?php
$host = "localhost";
$user = "root"; // Default XAMPP
$pass = "";     // Default XAMPP kosong
$db   = "sourarts";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi ke database sourarts gagal: " . mysqli_connect_error());
}
?>