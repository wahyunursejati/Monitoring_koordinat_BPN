<?php
session_start();

if (!isset($_SESSION['level'])) {
  header("location:login.html?pesan=belum_login");
  exit();
}

include "koneksi.php";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tracking Koordinat</title>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" type="text/css" href="css/pluskoordinat.css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  </head>
  <body>
    <div class="sidebar">
      <div class="pengguna">
        <h1>AD</h1>
      </div>
      <div class="logo"></div>
      <ul class="menu">
        <li>
          <a href="../homeadmin.php">
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
        <li>
          <a href="koordinat.php">
            <i class="fas fa-solid fa-scroll"></i>
            <span>Data Sertifikat</span>
          </a>
        </li>
        <li class="active">
          <a href="#">
            <i class="fas fa-map-marker-alt"></i>
            <span>Perubahan Koordinat</span>
          </a>
        </li>
      </ul>
    </div>
    <div class="content">
      <div class="title">
        <h1>Tambah Perubahan Koordinat</h1>
      </div>
      <!-- Form untuk input ID sertifikat dan koordinat baru -->
      <div class="form">
        <form action="jarak.php" method="post">
  <label for="Id_NoSertif">Nomor Sertifikat:</label>
  <select id="Id_NoSertif" name="Id_NoSertif" required>
    <option value="">Pilih Nomor Sertifikat</option>
    <?php
    $query = "SELECT Id_NoSertif FROM sertifikat"; // Replace with your actual query
    $result = $koneksi->query($query);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<option value='" . $row["Id_NoSertif"] . "'>" . $row["Id_NoSertif"] . "</option>";
        }
    } else {
        echo "<option value=''>Tidak ada sertifikat</option>";
    }
    ?>
  </select>
          <br /><br />

          <label for="latitude">Latitude Baru:</label>
          <input
            type="text"
            id="latitude"
            name="latitude"
            required
          /><br /><br />

          <label for="longitude">Longitude Baru:</label>
          <input
            type="text"
            id="longitude"
            name="longitude"
            required
          /><br /><br />

          <label for="tanggal_kejadian">Tanggal Kejadian:</label>
          <input
            type="datetime-local"
            id="tanggal_kejadian"
            name="tanggal_kejadian"
            required
            placeholder="YYYY-MM-DDThh:mm:ss"
            title="Format: YYYY-MM-DDThh:mm:ss"
            pattern="\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}"
          />
          <br /><br />
          <button>Simpan</button>
        </form>
      </div>
    </div>
  </body>
</html>

