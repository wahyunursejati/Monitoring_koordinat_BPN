<?php
include "koneksi.php";

$kapanewon_id = $_GET['Id_Kap'];

$sql = "SELECT * FROM kelurahan WHERE Id_Kap = $kapanewon_id";
$result = mysqli_query($koneksi, $sql);

$kelurahan = array();
while ($row = mysqli_fetch_assoc($result)) {
    $kelurahan[] = $row;
}

echo json_encode($kelurahan);
?>
