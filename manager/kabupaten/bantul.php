<?php
session_start();

if ($_SESSION['level'] == "") {
    header("location:login.html?pesan =belum_login");
}

include 'koneksi.php';
$_kab = "";
if (isset($_GET['kab'])) {
    $_kab = $_GET['kab'];
}
?>

<!DOCTYPE html>
<html>
    <head>
    <title>Data sertifikat</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/sertifikat.css">
    </head>
    <body>
    <div class="sidebar">
        <div class="logo"></div>
            <ul class="menu">
                <li >
                    <a href="../../homemanager.php" >
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="../penduduk.php">
                        <i class="fas fa-user"></i>
                        <span>Data Penduduk</span>
                    </a>
                </li>
                <li class="active">
                    <a href="#">
                        <i class="fas fa-solid fa-scroll"></i>
                        <span>Data Sertifikat</span>
                    </a>
                </li>
                <li>
                    <a href="../koordinat.php">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Perubahan Koordinat</span>
                    </a>
                </li>
            </ul>
    </div>
        <!-- Content Header (Page header) -->
        <div class="content">
            <section class="content-header">
                <h1>
                    Data Sertifikat
                </h1>
                <ol class="breadcrumb">
                    </ol>
                </section>
                
                <!-- Main content -->
                <section class="con">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <div class="box-tool">
                                <div class="filter-form">
                                    <div class="dropdown">
                                        <button class="dropbtn">Pilih kabupaten
                                            <i class = "fa fa-caret-down"></i>
                                        </button>
                                        <div class="dropdown-content">
                                            <a href="kab.php">Sleman</a>
                                            <a href="kota.php">Kota</a>
                                            <a href="bantul.php">Bantul</a>
                                            <a href="gunung.php">Gunung Kidul</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="box-body-table-responsive-no-padding">
                            <table class="table table-hover table-bordered">
                                <tr>
                                    <th>Id_NoSertif</th>
                                    <th>NIK</th>
                                    <th>Longitude</th>
                                    <th>Latitude</th>
                                    <th>kabupaten</th>
                                    <th>Kapanewon</th>
                                    <th>kelurahan</th>
                                    <th>Dusun</th>
                                    <th></th>
                                </tr>
                                <?php
                                // Fetch data penduduk from database
                                $query = "SELECT * FROM detail, sertifikat, kabupaten, kapanewon, kelurahan, dusun WHERE detail.Id_NoSertif = sertifikat.Id_NoSertif AND detail.Id_NoSertif = kabupaten.Id_NoSertif AND detail.Id_NoSertif = kapanewon.Id_NoSertif AND detail.Id_NoSertif = kelurahan.Id_NoSertif AND detail.Id_NoSertif = dusun.Id_NoSertif AND kabupaten.kab = 'Bantul'";
                                $result = mysqli_query($koneksi, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo"<tr>";
                                    echo "<td>" . $row['Id_NoSertif'] . "</td>";
                                    echo "<td>" . $row['NIK'] . "</td>";
                                    echo "<td>" . $row['longitude'] . "</td>";
                                    echo "<td>" . $row['latitude'] . "</td>";
                                    echo "<td>" . $row['kab'] . "</td>";
                                    echo "<td>" . $row['kapanewon'] . "</td>";
                                    echo "<td>" . $row['kelurahan'] . "</td>";
                                    echo "<td>" . $row['dusun'] . "</td>";
                                    echo "</tr>";
                                    
                                }
                                ?>
                            </table>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
            </div>
        </section><!-- /.content -->
    </div>
    </body>
</html>

