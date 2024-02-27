<?php
session_start();

if ($_SESSION['level'] == "") {
    header("location:login.html?pesan =belum_login");
}

include 'koneksi.php';

if (isset($_POST['search'])) {
    $noSertif = $_POST['Id_NoSertif'];
    $query = "SELECT * FROM data_pemiliksertif,sertifikat 
    WHERE data_pemiliksertif.NIK = sertifikat.NIK 
    AND Id_NoSertif = '?'";

    if ($stmt = mysqli_prepare($koneksi, $query)) {
        
        // Bind parameters
        mysqli_stmt_bind_param($stmt, "s", $noSertif);

        // Execute query
        mysqli_stmt_execute($stmt);

        // Get result
        $result = mysqli_stmt_get_result($stmt);

        // Fetch data
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }
}
?>

<!DOCTYPE html> 
<html>
    <head>
        <title>Data Sertifikat</title>
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
                        <span>Statisik</span>
                    </a>
                </li>
                <li>
                    <a href="sertifikat.php">
                        <i class="fas fa-solid fa-bell"></i>
                        <span>Aduan</span>
                    </a>
                </li>
                <li class="active">
                    <a href="#">
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
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                        <?php
                             if (isset($_POST['search'])) {
                                 $noSertif = $_POST['Id_NoSertif'];
                                 $query = "SELECT * FROM sertifikat WHERE Id_NoSertif = '$noSertif'";
                                 $result = mysqli_query($conn, $query);

                                 if (mysqli_num_rows($result) > 0) {
                                     while($row = mysqli_fetch_assoc($result)) {
                                         echo "Id_NoSertif: " . $row["Id_NoSertif"]. " - NIK: " . $row["NIK"]. " - Tanggal: " . $row["Tanggal"]. "<br>";
                                     }
                                 } else {
                                     echo "No results found";
                                 }
                             }
                             ?>
                             <form method="post" action="search.php" class="sertifikat">
                                 <label for="no_sertif">Nomor Sertifikat:</label>
                                 <input type="text" id="no_sertif" name="no_sertif">
                                 <input type="submit" name="search" value="Search">
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
                                <?php foreach ($data as $row) : ?>
                                    <tr>
                                        <td><?= $row['Id_NoSertif'] ?></td>
                                        <td><?= $row['nama'] ?></td>
                                        <td><?= $row['NIK'] ?></td>
                                        <td><?= $row['longitude'] ?></td>
                                        <td><?= $row['latitude'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
    </body>
</html>