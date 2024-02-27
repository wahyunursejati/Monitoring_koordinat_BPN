<?php
session_start();

if ($_SESSION['level'] == "") {
    header("location:login.html?pesan=belum_login");
    exit();
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


// Check if form is submitted and method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $IdSertif = $_POST['Id_NoSertif'];
    $nik = $_POST['NIK'];
    $long = $_POST['longitude'];
    $lat = $_POST['latitude'];
    
    // Check if the ID to update is set
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        // Prepare SQL statement to update data in database
        $stmt = $koneksi->prepare("UPDATE sertifikat SET Id_NoSertif = ?, NIK = ?, longitude = ?, 
        latitude = ? WHERE NIK = ?");
        $stmt->bind_param("ssssi", $IdSertif, $nik, $long, $lat, $id);
    } else {
        echo "Error: ID is not set.";
        exit();
    }

    // Execute the statement and check if it's successful
    if ($stmt->execute()) {
        echo "Data berhasil diupdate";
        // Redirect to a different page after a successful update
        header("Location: ../datasertif.php?pesan=update_success");
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
<title>Data Pemilik</title>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" type="text/css" href="css/edit.css" />
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
          <a href="../datapengguna.php">
            <i class="fas fa-users"></i>
            <span>Data Pengguna</span>
          </a>
        </li>
        <li>
          <a href="../datapenduduk.php">
            <i class="fas fa-user"></i>
            <span>Data Pemilik</span>
          </a>
        </li>
        <li class="active">
          <a href="../datasertif.php">
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
        <div class="content-header">
            <div class="title">
                <h1>Edit Data</h1>
            </div>
            <div class="user">
                <i class="fas fa-user"></i><span><?php echo htmlspecialchars($data_user['nama']); ?></span>
            </div>
        </div>
        
        <div class="form">

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <?php
    // Assuming $id is retrieved from a GET parameter or from the session
    if (isset($_GET['id']) || isset($_SESSION['id'])) {
        $id = isset($_GET['id']) ? $_GET['id'] : $_SESSION['id'];
        
        // Prepare the SQL statement
        $stmt = $koneksi->prepare("SELECT Id_NoSertif,NIK, longitude, latitude FROM sertifikat WHERE NIK = '$id'");
        
        // Execute the query
        $stmt->execute();
        
        // Bind the result to variables
        $stmt->bind_result($IdSertif, $nik, $long, $lat);
        
        // Fetch the data
        if ($stmt->fetch()) {
            // Data retrieved successfully, output the form with the data
            ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <ul>
                <li>
                    <label>Nomor Sertifikat</label>
                    <input type="text" class="tambah" name="Id_NoSertif" value="<?php echo htmlspecialchars($IdSertif); ?>">
                </li>
                <li>
                    <label>NIK</label>
                    <input type="text" class="tambah" name="NIK" value="<?php echo htmlspecialchars($nik); ?>">
                </li>
                <li>
                    <label>longitude</label>
                    <input type="text" class="tambah" name="longitude" value="<?php echo htmlspecialchars($long); ?>">
                </li>
                <li>
                    <label>latitude</label>
                    <input type="text" class="tambah" name="latitude" value="<?php echo htmlspecialchars($lat); ?>">
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

