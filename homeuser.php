<?php
session_start();

include 'koneksi.php';

if (!isset($_SESSION['level']) || $_SESSION['level'] == "") {
    header("location:login.html?pesan=belum_login");
    exit();
}

if ($_SESSION['level'] != "user") { 
    // Or replace "user" with the required level
    header("location:login.html?pesan=unauthorized");
    exit();
}

$username = mysqli_real_escape_string($koneksi, $_SESSION['username']);
// Mengambil semua sertifikat milik pengguna
$sertifikat_query = "SELECT sertifikat.Id_NoSertif, login.username FROM data_pemiliksertif
                    INNER JOIN sertifikat ON sertifikat.NIK = data_pemiliksertif.NIK
                    INNER JOIN login ON login.Id_Pengguna = data_pemiliksertif.Id_Pengguna
                    WHERE login.username = '$username'";
$sertifikat_result = mysqli_query($koneksi, $sertifikat_query);

if(!$sertifikat_result) {
    // Handle error - inform user, log details, etc.
    die("Error fetching certificates: " . mysqli_error($koneksi));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home Page</title>
    <link rel="stylesheet" type="text/css" href="css/user.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">

</head>
<body>
        <div class="container">
            <div class="Id">
                <p class="h2"><i class= "fas fa-id-card"></i>Sertifikat Anda</p>
                <div class="IdSertif">
                    <?php while ($data_sertifikat = mysqli_fetch_assoc($sertifikat_result)) : ?>
                        <?php
                            $id_no_sertif = mysqli_real_escape_string($koneksi, $data_sertifikat
                            ['Id_NoSertif']);
                            $alamat_query = "SELECT kabupaten.Nama_Kab, kapanewon.Nama_Kap, 
                            kelurahan.Nama_Kelurahan
                            FROM sertifikat JOIN kabupaten 
                            ON sertifikat.Id_Kab = kabupaten.Id_Kab
                            JOIN kapanewon ON sertifikat.Id_Kap = kapanewon.Id_Kap
                            JOIN kelurahan ON sertifikat.Id_Kel = kelurahan.Id_Kel
                            WHERE sertifikat.Id_NoSertif = '$id_no_sertif'";
                            $alamat_result = mysqli_query($koneksi, $alamat_query);
                            if($alamat_result) {
                                $alamat_data = mysqli_fetch_assoc($alamat_result);
                            } else {
                                $alamat_data = null;
                            }
                        ?>
                        <div onclick="document.getElementById('detail-<?php echo $id_no_sertif; ?>').style.display='block';" style="cursor:pointer;">
                            <button class = "button" onclick="toggleDetail('<?php echo $id_no_sertif; ?>')" data-toggle="collapse">
                                <?php echo htmlspecialchars($data_sertifikat["Id_NoSertif"]); ?>
                            </button>

                            <script>
                                function toggleDetail(id) {
                                    var detailDiv = document.getElementById('detail-' + id);
                                    detailDiv.style.display = detailDiv.style.display === 'none' ? 'block' : 'none';
                                }
                            </script>
                        </div>
                        <div class = "detail" id="detail-<?php echo $id_no_sertif; ?>" style="display:none;">
                        <h1>BADAN PERTANAHAN NASIONAL REPUBLIK INDONESIA</h1>
                        <img src="img/garuda.png" alt="">
                        <h1>SERTIFIKAT</h1>
                            <h3>kabupaten = <?php echo $alamat_data ? htmlspecialchars($alamat_data["Nama_Kab"]) : "Tidak ditemukan"; ?></h3>
                            <h3>kapanewon = <?php echo $alamat_data ? htmlspecialchars($alamat_data["Nama_Kap"]) : "Tidak ditemukan"; ?></h3>
                            <h3>kelurahan = <?php echo $alamat_data ? htmlspecialchars($alamat_data["Nama_Kelurahan"]) : "Tidak ditemukan"; ?></h3>
                            <h3>dusun = <?php echo $alamat_data ? htmlspecialchars($alamat_data["Nama_Dusun"]) : "Tidak ditemukan"; ?></h3>
                            <form action="user/history.php" method="post">
                                <input type="hidden" name="id_no_sertif" value="<?php echo $id_no_sertif; ?>">
                                <button class = "button2" type="submit">History</button>
                            </form>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
    </div>
</body>
</html>


