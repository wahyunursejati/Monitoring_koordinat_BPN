<?php
session_start();

if (!isset($_SESSION['level'])) {
    header("location:login.html?pesan=belum_login");
}

include 'koneksi.php';

$username = mysqli_real_escape_string($koneksi, $_SESSION['username']);
$query_name = "SELECT nama FROM login WHERE username = '$username'";
$result_name = mysqli_query($koneksi, $query_name);

if(!$result_name) {
    // Handle error - inform user, log details, etc.
    die("Error fetching user data: " . mysqli_error($koneksi));
}

$data_user = mysqli_fetch_assoc($result_name);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Penduduk</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/penduduk.css">
</head>
<body>
    <div class="sidebar">
        <div class="pengguna">
            <h1>AD</h1>
        </div>
        <div class="logo"></div>
        <ul class="menu">
            <li><a href="../homeadmin.php"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
            <li><a href="datapengguna.php"><i class="fas fa-users"></i><span>Data Pengguna</span></a></li>
            <li class="active"><a href="#"><i class="fas fa-user"></i><span>Data Pemilik</span></a></li>
            <li><a href="datasertif.php"><i class="fas fa-solid fa-scroll"></i><span>Data Sertifikat</span></a></li>
            <li><a href="koordinat.php"><i class="fas fa-map-marker-alt"></i><span>Perubahan Koordinat</span></a></li>
        </ul>
    </div>

    <div class="content">
        <section class="content-header">
            <h1>Data Pemilik</h1>
            <div class="user">
                <i class="fas fa-user"></i><span><?php echo htmlspecialchars($data_user['nama']); ?></span>
            </div>
        </section>
        <section class="con">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <div class="box-tools-pull-right">
                                <a href="tambah_data_penduduk.php" class="btn btn-success">
                                <i class="fa fa-plus"></i> Tambah Data</a>
                            </div>
                        </div>
                        <div class="filter">
                            <div class="dropdown">
                                        <button class="dropbtn">Pilih kabupaten
                                            <i class = "fa fa-caret-down"></i>
                                        </button>
                                        <div class="dropdown-content">
                                            <a href="kabupaten/penduduk/kab.php">Sleman</a>
                                            <a href="kabupaten/penduduk/kota.php">Kota</a>
                                            <a href="kabupaten/penduduk/bantul.php">Bantul</a>
                                            <a href="kabupaten/penduduk/gunung.php">Gunung Kidul</a>
                                            <a href="kabupaten/penduduk/kp.php">Kulon Progo</a>
                                        </div>
                            </div>
                        </div>
                        <div class="data">
                        <?php
                            $sql = "SELECT * FROM data_pemiliksertif ";
            
                            // Jalankan kueri SQL
                            $result = mysqli_query($koneksi,$sql);
                            $jumlah_data = mysqli_num_rows($result);
                            ?>
                            <p>Jumlah data: <?php echo $jumlah_data; ?></p>
                        </div>
                        <div class="box-body-table-responsive-no-padding">
                            <table class="table-table-hover-table-bordered">
                                <tr>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>NIK</th>
                                    <th>Aksi</th>
                                </tr>
                                
                                <?php
                                $query = "SELECT * FROM data_pemiliksertif";
                                $result = mysqli_query($koneksi, $query);

                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>{$row['nama']}</td>";
                                    echo "<td>{$row['alamat']}</td>";
                                    echo "<td>{$row['NIK']}</td>";
                                    echo "<td>
                                        <a href='deletedit/edit_data_penduduk.php?
                                        id={$row['NIK']}' class='btn-btn-primary'>
                                        <i class='fa fa-edit'></i></a>
                                        <a>/</a>
                                        <a href='deletedit/hapus_data_penduduk.php?
                                        id={$row['NIK']}' class='btn-btn-danger'>
                                        <i class='fa fa-trash'></i></a>
                                    </td>";
                                    echo "</tr>";
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
