<?php
session_start();

include 'koneksi.php';

if (!isset($_SESSION['level']) || $_SESSION['level'] == "") {
    header("location:login.html?pesan=belum_login");
    exit();
}

if ($_SESSION['level'] != "user") { // Or replace "user" with the required level
    header("location:login.html?pesan=unauthorized");
    exit();
}

$username = mysqli_real_escape_string($koneksi, $_SESSION['username']);

$sertifikat_query = "SELECT sertifikat.Id_NoSertif, 
kabupaten.Nama_Kab FROM sertifikat 
INNER JOIN kabupaten 
ON sertifikat.Id_Kab = kabupaten.Id_Kab
INNER JOIN data_pemiliksertif ON data_pemiliksertif.NIK = sertifikat.NIK
INNER JOIN login ON login.Id_Pengguna = data_pemiliksertif.Id_Pengguna
WHERE login.username = '$username' AND kabupaten.Nama_Kab = 'Sleman'";
$sertifikat_result = mysqli_query($koneksi, $sertifikat_query);

if(!$sertifikat_result) {
    // Handle error - inform user, log details, etc.
    die("Error fetching certificates: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Bantul</title>
        <link rel="stylesheet" type="text/css" href="css/sleman.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <div class="title">
                <h1 class="h2"><i class= "fas fa-id-card"></i>Sertifikat Anda</h1>
            </div>
            <div class="detail">
    <?php
    while($row = mysqli_fetch_assoc($sertifikat_result)) {
        $id_no_sertif = mysqli_real_escape_string($koneksi, $row['Id_NoSertif']);
        $alamat_query = "SELECT kabupaten.Nama_Kab, kapanewon.Nama_Kap, 
        kelurahan.Nama_Kelurahan, dusun.Nama_Dusun
        FROM sertifikat JOIN kabupaten 
        ON sertifikat.Id_Kab = kabupaten.Id_Kab
        JOIN kapanewon ON sertifikat.Id_Kap = kapanewon.Id_Kap
        JOIN kelurahan ON sertifikat.Id_Kel = kelurahan.Id_Kel
        JOIN dusun ON sertifikat.Id_Dusun = dusun.Id_Dusun
        WHERE sertifikat.Id_NoSertif = '$id_no_sertif'";
        $alamat_result = mysqli_query($koneksi, $alamat_query);
        if($alamat_result) {
            $alamat_data = mysqli_fetch_assoc($alamat_result);
        } else {
            $alamat_data = null;
        }
        ?>
        <div class="sertif" onclick="document.getElementById('detail-<?php echo $id_no_sertif; ?>').style.display='block';" style="cursor:pointer;">
            <button class = "button" onclick="toggleDetail('<?php echo $id_no_sertif; ?>')" data-toggle="collapse">
                <?php echo htmlspecialchars($row["Id_NoSertif"]); ?>
            </button>

            <script>
                function toggleDetail(id) {
                    var detailDiv = document.getElementById('detail-' + id);
                    detailDiv.style.display = detailDiv.style.display === 'none' ? 'block' : 'none';
                }
            </script>
        </div>
        <div class = "isi2" id="detail-<?php echo $id_no_sertif; ?>" style="display:none;">
            <h1>BADAN PERTANAHAN NASIONAL REPUBLIK INDONESIA</h1>
            <img src="css/img/garuda.png" alt="">
            <h1>SERTIFIKAT</h1>
            <h3>kabupaten = <?php echo $alamat_data ? htmlspecialchars($alamat_data["Nama_Kab"]) : "Tidak ditemukan"; ?></h3>
            <h3>kapanewon = <?php echo $alamat_data ? htmlspecialchars($alamat_data["Nama_Kap"]) : "Tidak ditemukan"; ?></h3>
            <h3>kelurahan = <?php echo $alamat_data ? htmlspecialchars($alamat_data["Nama_Kelurahan"]) : "Tidak ditemukan"; ?></h3>
            <h3>dusun = <?php echo $alamat_data ? htmlspecialchars($alamat_data["Nama_Dusun"]) : "Tidak ditemukan"; ?></h3>
            <form action="history.php" method="post">
                <input type="hidden" name="id_no_sertif" value="<?php echo $id_no_sertif; ?>">
                <button class = "button2" type="submit">History</button>
            </form>
        </div>
    <?php 
    } 

    if(mysqli_num_rows($sertifikat_result) == 0) {
        echo "<div class='warning'>
        <i class='fas fa-exclamation-triangle'></i> 
        <h2>Anda tidak memiliki sertifikat di Sleman</h2>
        </div>s";
    }
    ?>
        </div>
    </body>
</html>
