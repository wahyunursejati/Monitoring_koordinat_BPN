<?php

// Koneksi database
$host = "127.0.0.1";
$database = "skripsi3";
$user = "root";
$password = "";

$conn = mysqli_connect($host, $user, $password, $database);

// Fungsi Haversine untuk menghitung jarak
function haversine($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo) {
    $earthRadius = 6371;  // Radius bumi dalam kilometer
    $latFrom = deg2rad($latitudeFrom);
    $lonFrom = deg2rad($longitudeFrom);
    $latTo = deg2rad($latitudeTo);
    $lonTo = deg2rad($longitudeTo);

    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;

    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
    return $angle * $earthRadius;
}

// Input koordinat
$longitude2 = filter_input(INPUT_POST, 'longitude');
$latitude2 = filter_input(INPUT_POST, 'latitude');
$Id = filter_input(INPUT_POST, 'Id_NoSertif');
$Date = $_POST['tanggal_kejadian'];

// Ambil data sertifikat berdasarkan ID yang diberikan
$query = "SELECT longitude, latitude FROM sertifikat 
WHERE Id_NoSertif = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 's', $Id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Cek jika ada data
if ($data = mysqli_fetch_assoc($result)) {
    // Konversi longitude dan latitude menjadi float
    $longitude1 = (float)$data['longitude'];
    $latitude1 = (float)$data['latitude'];
    
    // Hitung perubahan koordinat
    $perubahan_jarak = haversine($latitude1, $longitude1, 
    $latitude2, $longitude2);
    
    // Cetak output
    echo "<p> Perubahan jarak untuk ID {$Id}: {$perubahan_jarak} km</p>";
    
    // Check if input date is not in the future
    $dateNow = date("Y-m-d H:i:s");
if ($Date > $dateNow){
    echo "<script type='text/javascript'>
    window.onload = function () {
        alert('Melebihi Tanggal Hari ini !!!'); window.location.href = 'tambah_koordinat.php';}</script>";
} else {
    // Simpan data ke database
    $insertQuery = "INSERT INTO hiostory (Id_NoSertif, 
    tanggal_kejadian, longitude_baru, latitude_baru, jarak) 
    VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insertQuery);
    mysqli_stmt_bind_param($stmt, 'ssdds',$Id, $Date, $longitude2, $latitude2, $perubahan_jarak);
    mysqli_stmt_execute($stmt);

    // Redirect ke halaman koordinat.php
    header('Location: koordinat.php');
    exit;
}
} else {
    echo "Tidak ada data sertifikat ditemukan untuk ID tersebut.";
}

// Tutup koneksi database
mysqli_close($conn);

?>

