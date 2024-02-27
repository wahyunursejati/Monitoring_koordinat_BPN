<?php
session_start();

if (!isset($_SESSION['level'])) {
    header("location:login.html?pesan=belum_login");
    exit();
}

// Koneksi ke database
$db_host = '127.0.0.1';
$db_user = 'root';
$db_pass = '';
$db_name = 'skripsi3';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
$username = $conn->real_escape_string($_SESSION['username']);
$query_name = "SELECT nama FROM login WHERE username = ?";
$stmt_name = $conn->prepare($query_name);
$stmt_name->bind_param("s", $username);

if(!$stmt_name->execute()) {
    die("Error fetching user data: " . $stmt_name->error);
}

$result_name = $stmt_name->get_result();
$data_user = $result_name->fetch_assoc();

// Function to fetch users
function fetchUsers($conn) {
    $stmt = $conn->prepare("SELECT Id_Pengguna, nama FROM login");
    $stmt->execute();
    return $stmt->get_result();
}

// Function to fetch user by id
function fetchUserById($conn, $id) {
    $stmt = $conn->prepare("SELECT nama,username FROM login WHERE Id_Pengguna = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    return $stmt->get_result();
}

// Function to insert data
function insertData($conn, $id,$nama, $alamat, $nik) {
    $stmt = $conn->prepare("INSERT INTO data_pemiliksertif (Id_Pengguna, nama, alamat, nik) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $id, $nama, $alamat, $nik);
    return $stmt->execute();
}

$selected_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
$result = fetchUsers($conn);
$options = "";
while($row = $result->fetch_assoc()) {
    $selected = ($row['Id_Pengguna'] == $selected_id) ? 'selected' : '';
    $options .= "<option value='" . $row['Id_Pengguna'] . "' $selected>" . $row['Id_Pengguna'] . "</option>";
}

if (isset($_POST['submit'])) {
    $result = fetchUserById($conn, $selected_id);
}

if (isset($_POST['submit_data'])) {
    $alamat = $_POST['alamat'];
    $nama = $_POST['nama_pemilik'];
    $nik = $_POST['nik'];
    $isInserted = insertData($conn, $selected_id, $nama ,$alamat, $nik);
}

$conn->close();
?>
<!DOCTYPE html>
<html>
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
                <li>
                <a href="datapengguna.php">
                    <i class="fas fa-users"></i>
                    <span>Data Pengguna</span>
                </a>
                </li>
                <li class="active">
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
            <h1>Tambah Data Pemilik</h1>
            <div class="user">
                <i class="fas fa-user"></i><span><?php echo htmlspecialchars($data_user['nama']); ?></span>
            </div>
        </div>
        <div class="form">
            <form method="post" action="">
                <ul>
                    <li>
                        <label for="user_id">Pilih ID :</label>
                        <select name="user_id" id="user_id">
                        <?php echo $options; ?>
                        </select>
                        <button type="submit" name="submit">Tampilkan Nama</button>
                    </li>
                    <li>
                        <?php
                        if(isset($_POST['submit'])){
                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                                echo '
                                <ul>
                                <li><label>Nama : </label>
                                <input type="text" name="nama_pemilik" value="' . $row['nama'] . '" readonly>
                                </li>
                                <li><label>NIK : </label>
                                <input type="text" name="nik" value="' . $row['username'] . '" readonly>
                                </ul>';
                                ;
                            } else {
                                echo "Data tidak ditemukan";
                            }
                        }
                        ?>
                    </li>
                </ul>
                <form method="post" action="">
                    <ul>
                        <li>
                            <input type="hidden" name="selected_id" value="<?php echo $selected_id; ?>">
                        </li>
                        <li>
                            <label for="alamat">Alamat:</label>
                            <textarea name="alamat" id="alamat"></textarea>
                        </li>
                        <li>
                            <button type="submit" name="submit_data">Submit</button>
                                <?php
                                if(isset($_POST['submit_data'])){
                                    if ($isInserted) {
                                        echo "Data berhasil disimpan";
                                        header("Location: datapenduduk.php");
                                    } else {
                                        echo "Error: " . $conn->error;
                                    }
                                }
                                ?>
                        </li>
                    </ul>
                </form>
        </div>
    </div>
</body>
</html>

