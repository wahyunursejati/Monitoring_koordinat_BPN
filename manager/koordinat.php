<?php
session_start();

if (!isset($_SESSION['level'])) {
    header("Location: login.html?pesan=belum_login");
    exit();
}

include 'koneksi.php';

$query = "";
$result = [];

if (isset($_GET['nama'])) {
    $cari = $_GET['nama'];
    $query = "SELECT * FROM data_pemiliksertif, sertifikat
    WHERE data_pemiliksertif.NIK = sertifikat.NIK
    AND data_pemiliksertif.nama = '$cari'";
} else {
    $query = "SELECT * FROM data_pemiliksertif, sertifikat 
    WHERE data_pemiliksertif.NIK = sertifikat.NIK";
}

$result = mysqli_query($koneksi, $query);

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Data sertifikat</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/koordinat.css">
    </head>
    <body>
        <div class="sidebar">
            <div class="logo"></div>
            <ul class="menu">
                <li >
                    <a href="../homemanager.php" >
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="penduduk.php">
                        <i class="fas fa-chart-bar"></i>
                        <span>Statistik</span>
                    </a>
                </li>
                <li>
                    <a href="sertifikat.php">
                        <i class="fa-solid fa-bell"></i>
                        <span>Aduan</span>
                    </a>
                </li>
                <li class="active">
                    <a href="koordinat.php">
                        <i class="fas fa-solid fa-scroll"></i>
                        <span>Sertifikat</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="content">
            <section class="content-header">
                <h1>
                    Sertifikat
                </h1>
                <ol class="breadcrumb"></ol>
            </section>
            <section class="conn">
                <div class="row">
                    <div class="box">
                        <div class="box-header">
                            <div class="filter-form">
                                <form action="koordinat.php">
                                    <label>Cari : </label>
                                    <input type="text" name="nama" />
                                    <input type="submit" value="Cari" />
                                </form>
                            </div>
                            <div class="box-body-table-responsive-no-padding">

                                <table class="table table-hover table-bordered">
                                    <tr>
                                        <th>No Sertif</th>
                                        <th>Nama</th>
                                        <th>NIK</th>
                                        <th>Longitude</th>
                                        <th>Latitude</th>
                                    </tr>
                                    <?php
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>";
                                            echo "<td>" . $row['Id_NoSertif'] . "</td>";
                                            echo "<td>" . $row['nama'] . "</td>";
                                            echo "<td>" . $row['NIK'] . "</td>";
                                            echo "<td>" . $row['longitude'] . "</td>";
                                            echo "<td>" . $row['latitude'] . "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5'>No record found</td></tr>";
                                    }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </body>
</html>
<!-- The HTML part remains the same -->


