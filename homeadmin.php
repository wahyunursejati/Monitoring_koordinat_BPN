<?php
session_start();

// redirect to login page if not logged in
if (empty($_SESSION['level'])) {
    header("location:login.html?pesan=belum_login");
    exit();
}

include 'koneksi.php';

// fetch user data
$username = mysqli_real_escape_string($koneksi, $_SESSION['username']);
$query_name = "SELECT nama FROM login WHERE username = '$username'";
$result_name = mysqli_query($koneksi, $query_name);

if(!$result_name) {
    die("Error fetching user data: " . mysqli_error($koneksi));
}

$data_user = mysqli_fetch_assoc($result_name);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" /> 
    <title>Admin</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/admin/dashadmin.css">
</head>
<body>
    <div class="sidebar">
        <div class="pengguna">
            <h1>AD</h1>
        </div>
        <ul class="menu">
            <li class="active">
                <a href="#"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
            </li>
            <li>
                    <a href="admin/datapengguna.php">
                        <i class="fas fa-users"></i>
                        <span>Data Pengguna</span>
                    </a>
                </li>
            <li>
                <a href="admin/datapenduduk.php"><i class="fas fa-user"></i><span>Data Pemilik</span></a>
            </li>
            <li>
                <a href="admin/datasertif.php"><i class="fas fa-solid fa-scroll"></i><span>Data Sertifikat</span></a>
            </li>
            <li>
                <a href="admin/koordinat.php"><i class="fas fa-map-marker-alt"></i><span>Perubahan Koordinat</span></a>
            </li>
        </ul>
    </div>
    <div class="main--content">
        <div class="header--title">
            <div class="title">
                <h2>Dashboard Admin</h2>
            </div>
            <div class="user">
                <i class="fas fa-user"></i><span><?php echo htmlspecialchars($data_user['nama']); ?></span>
            </div>
        </div>
        <div class="content">
            <h1 class="h2">Selamat Datang, <?php echo htmlspecialchars($data_user['nama']); ?>!</h1>
            <p>Silahkan Pilih Menu Yang Ingin Anda Akses</p>
        </div>
    </div>
</body>
</html>

