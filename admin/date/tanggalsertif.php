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
    $sql = "SELECT * FROM detail, sertifikat, kabupaten, 
    kapanewon, kelurahan, dusun 
    WHERE detail.Id_NoSertif = sertifikat.Id_NoSertif 
    AND detail.Id_NoSertif = kabupaten.Id_NoSertif 
    AND detail.Id_NoSertif = kapanewon.Id_NoSertif 
    AND detail.Id_NoSertif = kelurahan.Id_NoSertif 
    AND detail.Id_NoSertif = dusun.Id_NoSertif AND sertifikat.Tanggal = ?";

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
        <link rel="stylesheet" type="text/css" href="../css/sertifikat.css">
    </head>
    <body>
    <div class="sidebar">
    <div class="pengguna">
            <h1>AD</h1>
        </div>
        <div class="logo"></div>
            <ul class="menu">
                <li >
                    <a href="../homeadmin.php" >
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li >
                    <a href="../datapenduduk.php">
                        <i class="fas fa-user"></i>
                        <span>Data Penduduk</span>
                    </a>
                </li>
                <li class="active">
                    <a href="../datasertifikat.php">
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
    <div class="content">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Data Penduduk
            </h1>
            <div class="user">
                <?php
                $username = mysqli_real_escape_string($koneksi, $_SESSION['username']);
                $query_name = "SELECT nama FROM users WHERE username = '$username'";
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
        <!-- all your HTML code -->
        <section class="con">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                    <div class="box-header">
                            <div class="box-tools-pull-right">
                                <a href="../tambah_sertifikat.php" class="btn btn-success">
                                <i class="fa fa-plus"></i> Tambah Data</a>
                            </div>
                        </div>
                        <div class="filter">
                        <form method="post" action="date/tanggalsertif.php">
                                <label for="date-filter"></label>
                                <input type="date" id="date-filter" name="date_filter" value="<?php echo isset($_POST['date_filter']) ? $_POST['date_filter'] : '' ?>">
                                <button>Filter</button>
                            </form> 
                            <div class="dropdown">
                                        <button class="dropbtn">Pilih kabupaten
                                            <i class = "fa fa-caret-down"></i>
                                        </button>
                                        <div class="dropdown-content">
                                            <a href="../kabupaten/sertifikat/kab.php">Sleman</a>
                                            <a href="../kabupaten/sertifikat/kota.php">Kota</a>
                                            <a href="../kabupaten/sertifikat/bantul.php">Bantul</a>
                                            <a href="../kabupaten/sertifikat/gunung.php">Gunung Kidul</a>
                                            <a href="../kabupaten/sertifikat/kp.php">Kulon Progo</a>
                                        </div>
                                    </div> 
                        </div>
                        <div class="data">
    <?php
    // get the date from the filter
    $date_filter = isset($_POST['date_filter']) ? $_POST['date_filter'] : '';

    // modify the SQL query to count data based on date
    $sql = "SELECT * FROM sertifikat WHERE sertifikat.Tanggal = '$date_filter'";

    // Execute the SQL query
    $result = mysqli_query($koneksi, $sql);
    $jumlah_data = mysqli_num_rows($result);
    ?>
    <p>Jumlah data: <?php echo $jumlah_data; ?></p>
</div>
                        <div class="box-body-table-responsive-no-padding">
                            <table class="table table-hover table-bordered">
                            <tr>
                                    <th>Nomor Sertifikat</th>
                                    <th>NIK</th>
                                    <th>Longitude</th>
                                    <th>Latitude</th>
                                    <th>kabupaten</th>
                                    <th>Kapanewon</th>
                                    <th>kelurahan</th>
                                    <th>Dusun</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                                <?php foreach ($data as $row) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['Id_NoSertif']) ?></td>
                                        <td><?= htmlspecialchars($row['NIK']) ?></td>
                                        <td><?= htmlspecialchars($row['longitude']) ?></td>
                                        <td><?= htmlspecialchars($row['latitude']) ?></td>
                                        <td><?= htmlspecialchars($row['kab']) ?></td>
                                        <td><?= htmlspecialchars($row['kapanewon']) ?></td>
                                        <td><?= htmlspecialchars($row['kelurahan']) ?></td>
                                        <td><?= htmlspecialchars($row['dusun']) ?></td>
                                        <td><?= htmlspecialchars($row['Tanggal']) ?></td>

                                        <td><a href='deletedit/edit_data_penduduk.php?id={$row['NIK']}' class='btn-btn-primary'><i class='fa fa-edit'></i></a>
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

