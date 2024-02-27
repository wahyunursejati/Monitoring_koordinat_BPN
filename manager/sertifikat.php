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
                <li class="active">
                    <a href="#">
                        <i class="fa-solid fa-bell"></i>
                        <span>Aduan</span>
                    </a>
                </li>
                <li>
                    <a href="koordinat.php">
                        <i class="fas fa-solid fa-scroll"></i>
                        <span>Sertifikat</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Content Header (Page header) -->
        <div class="content">
            <section class="content-header">
                <h1>
                    Aduan Masyarakat
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
                                    <form method="post" action="tanggal.php">
                                        <label for="date-filter"></label>
                                        <input type="date" id="date-filter" name="date-filter" value="<?php echo isset($_POST['date_filter']) ? $_POST['date_filter'] : '' ?>">
                                        <button>Filter</button>
                                    </form>
                                </div>
                            </div>
                        <div class="box-body-table-responsive-no-padding">
                            <table class="table table-hover table-bordered">
                                <tr>
                                    <th>Id</th>
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>NIK</th>
                                    <th>No Hp</th>
                                    <th>Jenis Aduan</th>
                                    <th>Aduan</th>
                                </tr>
                                <?php
                                // Fetch data penduduk from database
                                $query = "SELECT * FROM aduan";
                                $result = mysqli_query($koneksi, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo"<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['tanggal'] . "</td>";
                                    echo "<td>" . $row['nama'] . "</td>";
                                    echo "<td>" . $row['NIK'] . "</td>";
                                    echo "<td>" . $row['no_hp'] . "</td>";
                                    echo "<td>" . $row['jenis'] . "</td>";
                                    echo "<td>" . $row['aduan'] . "</td>";
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

