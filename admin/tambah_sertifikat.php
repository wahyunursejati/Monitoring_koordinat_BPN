<?php

session_start();

if ($_SESSION['level'] == "") {
    header("location:login.html?pesan=belum_login");
    exit();
}

require_once "koneksi.php";

$username = mysqli_real_escape_string($koneksi, $_SESSION['username']);
$query_name = "SELECT nama FROM login WHERE username = '$username'";
$result_name = mysqli_query($koneksi, $query_name);

if(!$result_name) {
    // Handle error - inform user, log details, etc.
    die("Error fetching user data: " . mysqli_error($koneksi));
}

$data_user = mysqli_fetch_assoc($result_name);


// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $longitude = $_POST['longitude'];
    $latitude = $_POST['latitude'];
    $Id_NoSertif = $_POST['Id_NoSertif'];
    $NIK = $_POST['NIK'];
    $kabupaten = $_POST['Id_Kab'];
    $kapanewon = $_POST['Id_Kap'];
    $kelurahan = $_POST['Id_Kel'];

    // Corrected SQL statement to insert data into database
    
    $sql = "INSERT INTO sertifikat (longitude, latitude, NIK, 
    Id_NoSertif, Id_Kab, Id_Kap, Id_Kel) 
    VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $koneksi->prepare($sql);
    // Corrected bind_param, assuming all parameters are of string type
    $stmt->bind_param("sssssss", $longitude, $latitude, $NIK, $Id_NoSertif, 
    $kabupaten, $kapanewon, $kelurahan);

    // Execute the statement and check if it's successful
    if ($stmt->execute()) {
        header("Location: datasertif.php?pesan=data_tersimpan");
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html" />
        <meta name="author" content="aaa">
        <link
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
            rel="stylesheet"/>
            <link rel="stylesheet" type="text/css" href="css/plusertif.css" />

        <title>Tambah Sertifikat</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        
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
                <li>
                    <a href="datapengguna.php">
                        <i class="fas fa-users"></i>
                        <span>Data Pengguna</span>
                    </a>
                </li>
                <li>
                    <a href="datapenduduk.php">
                        <i class="fas fa-user"></i>
                        <span>Data Pemilik</span>
                    </a>
                </li>
                <li class="active">
                    <a href="#">
                        <i class="fas fa-solid fa-scroll"></i>
                        <span>Data Sertifikat</span>
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
            <div class="title">
                <h1>Tambah Sertifikat</h1>
                <div class="user">
                    <i class="fas fa-user"></i><span><?php echo htmlspecialchars($data_user['nama']); ?></span>
                </div>
            </div>
            <div class="form">

                <form action="" method="post">
                    <ul>
                        <li>
                            <label>NIK</label>
                            <input type="text" class="tambah" name="NIK" >
                        </li>
                        <li>
                            <label>Nomor Sertifikat</label>
                            <input type="text" class="tambah" name="Id_NoSertif">
                        </li>
                        <li>
                            <label>Kabupaten : </label>
                            <select name="Id_Kab" id="kabupaten">
                                <option value=""> Pilih Kabupaten </option>
                                <?php
                                $sql_kab = mysqli_query($koneksi, 'SELECT * FROM kabupaten');
                                while($row_kab = mysqli_fetch_array($sql_kab)) {
                                    echo '<option value="'.$row_kab['Id_Kab'].'">'.$row_kab['Nama_Kab'].'</option>';
                                }
                                ?>
                            </select><br />
                        </li>
                        <li>
                            <label>Kapanewon : </label>
                            <select name="Id_Kap" id="kapanewon">
                                <option value=""> Pilih Kapanewon </option>
                            </select><br />
                        </li>
                        <li>
                            <label>Kelurahan : </label>
                            <select name="Id_Kel" id="kelurahan">
                                <option value=""> Pilih Kelurahan </option>
                            </select>
                        </li>
                        <li>
                            <label>Latitude</label>
                            <input type="text" class="tambah" name="latitude">
                        </li>
                        <li>
                            <label>Longitude</label>
                            <input type="text" class="tambah" name="longitude">
                        </li>
                        <li>
                            <button type="submit">Simpan</button>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
        <script>
            $(document).ready(function(){
                $("#kabupaten").change(function(){
                    var Id_Kab = $(this).val();

                    $.ajax({
                        type: 'POST',
                        url: 'kapanewon.php',
                        data: 'Id_Kab=' + Id_Kab,
                        success: function(data){
                            console.log(data);
                            $("#kapanewon").html(data);
                        }
                    });
                });
                $("#kapanewon").change(function(){
                    var Id_Kap = $(this).val();
                    console.log(Id_Kap);

                    $.ajax({
                        type: 'POST',
                        url: 'kelurahan.php',
                        data: 'Id_Kap=' + Id_Kap,
                        success: function(data){
                            console.log(data);
                            $("#kelurahan").html(data);
                        }
                    });
                });
            });

        </script>
    </body>
</html>
