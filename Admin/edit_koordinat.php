<?php
session_start();

if ($_SESSION['level'] == "") {
    header("location:login.html?pesan=belum_login");
    exit();
}

include 'koneksi.php';

// Check if form is submitted and method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $Id_NoSertif = $_POST['Id_NoSertif'];
    $long = $_POST['longitude_akhir'];
    $lat = $_POST['latitude_akhir'];
    
    // Check if the ID to update is set
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // Prepare SQL statement to update data in database
        $stmt = $koneksi->prepare("UPDATE tracking SET longitude_akhir = ?, latitude_akhir = ? lId_NoSertif = ? WHERE Id_NoSertif = ?");
        $stmt->bind_param("sssi", $long, $lat, $Id_NoSertif, $id);
        $result = $stmt->execute();
    } else {
        echo "Error: ID is not set.";
        exit();
    }

    // Execute the statement and check if it's successful
    if ($stmt->execute()) {
        echo "Data berhasil diupdate";
        // Redirect to a different page after a successful update
        header("Location: KODE/user/datapenduduk.php.php?pesan=update_success");
        exit();
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
<title>Tracking Koordinat</title>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" type="text/css" href="css/edit.css" />
</head>
<body>
<div class="sidebar">
      <div class="logo"></div>
      <ul class="menu">
        <li>
          <a href="../homeadmin.php">
            <i class="fas fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li>
          <a href="../datapenduduk.php">
            <i class="fas fa-user"></i>
            <span>Data Penduduk</span>
          </a>
        </li>
        <li class="active">
          <a href="#">
          <i class="fas fa-solid fa-scroll"></i>
          <span>Data Sertifikat</span>
        </a>
      </li>
      <li >
          <a href="../koordinat.php">
            <i class="fas fa-map-marker-alt"></i>
            <span>Perubahan Koordinat</span>
          </a>
        </li>
      </ul>
    </div>
    <div class="content">
        <div class="title">
            <h1>Edit Data</h1>
        </div>
        <div class="form">

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <?php
    // Assuming $id is retrieved from a GET parameter or from the session
    if (isset($_GET['id']) || isset($_SESSION['id'])) {
        $id = isset($_GET['id']) ? $_GET['id'] : $_SESSION['id'];
        
        // Prepare the SQL statement
        $query = "SELECT  FROM detail 
    JOIN tracking ON tracking.Id_NoSertif = detail.Id_NoSertif
    JOIN sertifikat ON sertifikat.Id_NoSertif = detail.Id_NoSertif
    WHERE tracking.Id_NoSertif = ?";

$stmt = $koneksi->prepare($query);

// Check if the preparation is successful
if ($stmt === false) {
    throw new Exception($koneksi->error);
}

// Bind the id parameter to the prepared statement
$stmt->bind_param("i", $id);

// Execute the query
if (!$stmt->execute()) {
    throw new Exception($stmt->error);
}

// Bind the result to variables
$stmt->bind_result( $long, $lat, $id);
        
        // Fetch the data
        if ($stmt->fetch()) {
            // Data retrieved successfully, output the form with the data
            ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <ul>
                <li>
                    <label>Nama</label>
                    <input type="text" class="tambah" name="Nama" value="<?php echo htmlspecialchars($Id_NoSertif); ?>">
                </li>
                <li>
                    <label>Alamat</label>
                    <textarea class="tambah" name="Alamat" rows="4" cols="50"><?php echo htmlspecialchars($long); ?></textarea>
                </li>
                <li>
                    <label>NIK</label>
                    <input type="text" class="tambah" name="NIK" value="<?php echo htmlspecialchars($lat); ?>">
                </li>
                <li>
                    <button type="submit">Update</button>
                </li>
            </ul>
            <?php
        } else {
            // No data found for the given ID
            echo "Data tidak ditemukan.";
        }
        
        // Close the statement
        $stmt->close();
    } else {
        // ID is not provided
        echo "ID tidak ditemukan.";
    }
    ?>
</form>
</div>
</div>
</body>
</html>

