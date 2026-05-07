<?php
include 'koneksi.php';

if (isset($_GET['id_karya'])) {
    $id_karya = $_GET['id_karya'];
    $query = mysqli_query($conn, "SELECT k.*, u.fullname FROM komentar k 
                                  JOIN users u ON k.id_user = u.id 
                                  WHERE k.id_karya = '$id_karya' 
                                  ORDER BY k.tanggal DESC");

    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            echo '<div class="comment-item">';
            echo '<span class="comment-user">@' . htmlspecialchars($row['fullname']) . '</span>';
            echo '<p style="margin: 5px 0 0 0;">' . nl2br(htmlspecialchars($row['isi_komentar'])) . '</p>';
            echo '<small style="color: #999; font-size: 10px;">' . $row['tanggal'] . '</small>';
            echo '</div>';
        }
    } else {
        echo '<p style="color: #999; font-size: 14px;">Belum ada ulasan.</p>';
    }
}
?>