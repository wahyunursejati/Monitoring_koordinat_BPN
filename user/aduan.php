<?php
session_start();

include 'koneksi.php';

if (!isset($_SESSION['level']) || empty($_SESSION['level'])) {
    header("location:login.html?pesan=belum_login");
    exit();
}

if ($_SESSION['level'] != "user") {
    header("location:login.html?pesan=unauthorized");
    exit();
}

$username = mysqli_real_escape_string($koneksi, $_SESSION['username']);

$value1 = $value2 = $value3 = $value4 = $value5 = '';

// Check if form is submitted
if (isset($_POST['submit'])) {
    $value1 = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $value2 = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $value3 = mysqli_real_escape_string($koneksi, $_POST['NIK']);
    $value4 = mysqli_real_escape_string($koneksi, $_POST['jenis']);
    $value5 = mysqli_real_escape_string($koneksi, $_POST['aduan']);

    $query = "INSERT INTO aduan(nama, no_hp, NIK, jenis, aduan) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, 'sssss', $value1, $value2, $value3, $value4, $value5);

    if(mysqli_stmt_execute($stmt)) {
        header("Location: aduan.php?pesan=sukses");
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Aduan</title>
        <link rel="stylesheet" type="text/css" href="css/aduan.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <div class="title">
                <h1>Silahkan Isi Aduan</h1>
            </div>
            <div class="form">
                <form method="post" action="">
                    <ul>
                        <li>
                            <label for="nama">Nama:</label><br>
                            <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($value1) ?>"><br>
                        </li>
                        <li>
                            <label for="nomor_hp">Nomor HP:</label><br>
                            <input type="text" id="nomor_hp" name="no_hp" value="<?= htmlspecialchars($value2) ?>"><br>
                        </li>
                        <li>
                            <label for="nik">NIK:</label><br>
                            <input type="text" id="nik" name="NIK" value="<?= htmlspecialchars($value3) ?>"><br>
                        </li>
                        <li>
                            <label for="jenis_aduan">Jenis Aduan:</label><br>
                            <select id="jenis_aduan" name="jenis">
                                <option value="">--------------- Pilih Aduan ---------------</option>
                                <option value="Mengecek Koordinat">Mengecek Koordinat</option>
                                <option value="Kepemilikan sertifikat">Kepemilikan sertifikat</option>
                            </select><br>
                        </li>
                        <li>
                            <label for="aduan">Aduan:</label><br>
                            <textarea id="aduan" name="aduan"><?= htmlspecialchars($value5) ?></textarea><br>
                        </li>
                        <li>
                            <button type="submit" name="submit">Kirim</button>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </body>
</html>

