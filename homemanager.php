<?php
session_start();

if ($_SESSION['level'] == "") {
    header("location:login.html?pesan =belum_login");
}

include 'koneksi.php';

$data = [];

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
    <link rel="stylesheet" type="text/css" href="css/manager/manager.css">
    
</head>

<body>
    <div class="sidebar">
        <div class="logo"></div>
            <ul class="menu">
                <li class="active">
                    <a href="#" >
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="manager/penduduk.php">
                        <i class="fas fa-chart-bar"></i>
                        <span>Statisik</span>
                    </a>
                </li>
                <li>
                    <a href="manager/sertifikat.php">
                    <i class="fa-solid fa-bell"></i>
                        <span>Aduan</span>
                    </a>
                </li>
                <li>
                    <a href="manager/koordinat.php">
                        <i class="fas fa-solid fa-scroll"></i>
                        <span>Sertifikat</span>
                    </a>
                </li>
            </ul>
    </div>
    <div class="main--content">
        <div class="header--title">
            <h2>Dashboard Manager</h2>
        </div>
        <div class="content">
            <h1 class="h2">Selamat Datang, <?php echo htmlspecialchars($data_user['nama']); ?>!</h1>
            <p>Silahkan Pilih Menu Yang Ingin Anda Akses</p>
        </div>
    </div>
</body>
</html>




