<?php
session_start();

if (!isset($_SESSION['level'])) {
    header("location:login.html?pesan=belum_login");
    exit();
}

require 'koneksi.php';
$username = $koneksi->real_escape_string($_SESSION['username']);
$query_name = "SELECT nama FROM login WHERE username = ?";
$stmt_name = $koneksi->prepare($query_name);
$stmt_name->bind_param("s", $username);

if(!$stmt_name->execute()) {
    die("Error fetching user data: " . $stmt_name->error);
}

$result_name = $stmt_name->get_result();
$data_user = $result_name->fetch_assoc();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $Id = $_POST['Id_Pengguna'];
    $nama = $_POST['nama'];
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $level = $_POST['level'];

    // Prepare SQL statement to insert data into database
    $stmt = $koneksi->prepare("INSERT INTO login 
    (Id_Pengguna, nama, username, password, level) 
    VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $Id, $nama, $user, $pass, $level);

    // Execute the statement and check if it's successful
    if ($stmt->execute()) {
        $msg = "Data tersimpan";
        header("Location: datapengguna.php?pesan=" . urlencode($msg)); // Using urlencode to ensure special characters in $msg don't break the redirect
        $stmt->close();
    } else {
        $msg = "Error: " . $stmt->error;
        header("Location: datapengguna.php?pesan=" . urlencode($msg)); // Using urlencode to ensure special characters in $msg don't break the redirect
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Tambah data</title>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" type="text/css" href="css/pluspenduduk.css" />
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
        <li class="active">
          <a href="datapengguna.php">
            <i class="fas fa-users"></i>
            <span>Data Pengguna</span>
        </li>
        <li>
          <a href="datapenduduk.php">
            <i class="fas fa-user"></i>
            <span>Data Pemilik</span>
          </a>
        </li>
        <li>
          <a href="datasertif.php">
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
            <h1>Tambah Data Pengguna</h1>
            <div class="user">
                <i class="fas fa-user"></i><span><?php echo htmlspecialchars($data_user['nama']); ?></span>
            </div>
        </div>
        <div class="form">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <ul>
                    <li>
                      <label>Id</label>
                      <input type="number" class="tambah" name="Id_Pengguna">
                    </li>
                    <li>
                        <label>Nama</label>
                        <input type="text" class="tambah" name="nama" >
                    </li>
                    <li>
                        <label>Username</label>
                        <input type="text" class="tambah" name="username">
                    </li>
                    <li>
                        <label>Password</label>
                        <input type="text" class="tambah" name="password">
                    </li>
                    <li>
                        <label>Level</label>
                        <select class="tambah" name="level">
                            <option value="">--Pilih Level--</option>
                            <option value="user">user</option>
                            <option value="admin">admin</option>
                            <option value="manager">manager</option>
                        </select>
                    </li>
                    <li>
                        <button type="submit">Simpan</button>
                    </li>
                </ul>
            </form>
        </div>
        </div>
</body>
</html>


