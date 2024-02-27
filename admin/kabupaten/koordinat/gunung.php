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
        <div class="pengguna">
            <h1>AD</h1>
        </div>
        <div class="logo"></div>
            <ul class="menu">
                <li >
                    <a href="../../../homeadmin.php" >
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="../../datapengguna.php">
                        <i class="fas fa-users"></i>
                        <span>Data Pengguna</span>
                    </a>
                </li>
                <li>
                    <a href="../../datapenduduk.php">
                        <i class="fas fa-user"></i>
                        <span>Data Pemilik</span>
                    </a>
                </li>
                <li>
                    <a href="../../datasertif.php">
                        <i class="fas fa-solid fa-scroll"></i>
                        <span>Data Sertifikat</span>
                    </a>
                </li>
                <li class="active">
                    <a href="../../koordinat.php">
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
                <div class="user">
                <?php
                $username = mysqli_real_escape_string($koneksi, $_SESSION['username']);
                $query_name = "SELECT nama FROM login WHERE username = '$username'";
                $result_name = mysqli_query($koneksi, $query_name);
                
                if(!$result_name) {
                    // Handle error - inform user, log details, etc.
                    die("Error fetching user data: " . mysqli_error($koneksi));
                }
                
                $data_user = mysqli_fetch_assoc($result_name);
                ?>
                <i class="fas fa-user"></i><span><?php echo htmlspecialchars($data_user['nama']); ?></span>
            </div>
                </section>
                
                <!-- Main content -->
                <section class="con">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                    <div class="box-header">
                            <div class="box-tools-pull-right">
                                <a href="../../tambah_sertifikat.php" class="btn btn-success">
                                    <i class="fa fa-plus"></i> Tambah Data
                                </a>
                            </div>
                            <div class="box-tool">
                                <div class="filter-form">
                                    <form method="post" action="../../date/tanggalkoordinat.php">
                                            <label for="date-filter"></label>
                                            <input type="date" id="date-filter" name="date_filter" value="<?php echo isset($_POST['date_filter']) ? $_POST['date_filter'] : '' ?>">
                                            <button>Filter</button>
                                    </form> 
                                    <div class="dropdown">
                                        <button class="dropbtn">Pilih kabupaten
                                            <i class = "fa fa-caret-down"></i>
                                        </button>
                                        <div class="dropdown-content">
                                            <a href="kab.php">Sleman</a>
                                            <a href="kota.php">Kota</a>
                                            <a href="bantul.php">Bantul</a>
                                            <a href="gunung.php">Gunung Kidul</a>
                                            <a href="kp.php">Kulon Progo</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="data">
                                    <?php
                                        $sql = "SELECT * FROM hiostory, sertifikat, kabupaten
                                        WHERE hiostory.Id_NoSertif = sertifikat.Id_NoSertif 
                                        AND sertifikat.Id_Kab = kabupaten.Id_Kab
                                        AND kabupaten.Nama_Kab = 'Gunung Kidul'";
                                        // Jalankan kueri SQL
                                        $result = mysqli_query($koneksi,$sql);
                                        $jumlah_data = mysqli_num_rows($result);
                                        ?>
                                        <p>Jumlah data: <?php echo $jumlah_data; ?></p>
                                </div>
                        <div class="box-body-table-responsive-no-padding">
                        <table class="table table-hover table-bordered">
                            <tr>
                                <th>Nomor Sertifikat</th>
                                <th>NIK</th>
                                <th>Tanggal Kejadian</th>
                                <th>Longitude Awal</th>
                                <th>Latitude Awal</th>
                                <th>Longitude Akhir</th>
                                <th>Latitude Akhir</th>
                                <th>Jarak Perubahan</th>
                            </tr>
                                <?php
                                // Fetch data penduduk from database
                                $query = "SELECT * FROM hiostory, sertifikat, kabupaten
                                WHERE hiostory.Id_NoSertif = sertifikat.Id_NoSertif 
                                AND sertifikat.Id_Kab = kabupaten.Id_Kab
                                AND kabupaten.Nama_Kab = 'Gunung Kidul'";
                                $result = mysqli_query($koneksi, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo"<tr>";
                                    echo "<td>" . $row['Id_NoSertif'] . "</td>";
                                    echo "<td>" . $row['NIK'] . "</td>";
                                    echo "<td>" . $row['tanggal_kejadian'] . "</td>";
                                    echo "<td>" . $row['longitude'] . "</td>";
                                    echo "<td>" . $row['latitude'] . "</td>";
                                    echo "<td>" . $row['longitude_baru'] . "</td>";
                                    echo "<td>" . $row['latitude_baru'] . "</td>";
                                    echo "<td>" . $row['jarak'] . "</td>";
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

