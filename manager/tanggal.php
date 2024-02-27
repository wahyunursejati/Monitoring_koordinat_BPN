<?php
session_start();

if (!isset($_SESSION['level'])) {
    header("location:login.html?pesan=belum_login");
    exit();
}

require 'koneksi.php';

$data = [];

if (!empty($_POST['date_filter'])) {
    // Prepare SQL statement
    $sql = "SELECT * FROM aduan WHERE tanggal = ?";

    // Prepare statement
    if ($stmt = mysqli_prepare($koneksi, $sql)) {

        // Bind parameters
        $date_filter = $_POST['date_filter'];
        mysqli_stmt_bind_param($stmt, "s", $date_filter);

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
        <title>Data Koordinat</title>
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
                <li class="active">
                    <a href="sertifikat.php">
                        <i class="fas fa-solid fa-bell"></i>
                        <span>Aduan</span>
                    </a>
                </li>
                <li>
                    <a href="koordinat.php">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Perubahan Koordinat</span>
                    </a>
                </li>
            </ul>
    </div>
    <div class="content">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Perubahan Koordinat
            </h1>
        </section>
        <!-- all your HTML code -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                    <div class="box-header">
                            <!-- Add form for date filter -->
                            <form method="post" action="tanggal.php" class="data">
                                <label for="date-filter"></label>
                                <input type="date" id="date-filter" name="date_filter" value="<?php echo isset($_POST['date_filter']) ? $_POST['date_filter'] : '' ?>">
                                <button>Filter</button>
                            </form> 
                        </div><!-- /.box-header -->
                        <?php
                            // get the date from the filter
    $date_filter = isset($_POST['date_filter']) ? $_POST['date_filter'] : '';

    // modify the SQL query to count data based on date
    $sql = "SELECT * FROM hiostory WHERE hiostory.tanggal_kejadian = '$date_filter'";

    // Execute the SQL query
    $result = mysqli_query($koneksi, $sql);
    $jumlah_data = mysqli_num_rows($result);
                        ?>
                        <p>Jumlah data: <?php echo $jumlah_data; ?></p>
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
                                <?php foreach ($data as $row) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['id']) ?></td>
                                        <td><?= htmlspecialchars($row['tanggal']) ?></td>
                                        <td><?= htmlspecialchars($row['nama']) ?></td>
                                        <td><?= htmlspecialchars($row['NIK']) ?></td>
                                        <td><?= htmlspecialchars($row['no_hp']) ?></td>
                                        <td><?= htmlspecialchars($row['jenis']) ?></td>
                                        <td><?= htmlspecialchars($row['aduan']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                    </div>
                </div>
                </div>
            </div>
        </section>
                <!-- all your HTML code -->
    </div>
    </body>
</html>

