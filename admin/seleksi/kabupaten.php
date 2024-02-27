<?php
include "koneksi.php";

$sql = "SELECT * FROM kabupaten";
$result = mysqli_query($koneksi, $sql);

$kabupaten = array();
while ($row = mysqli_fetch_assoc($result)) {
    $kabupaten[] = $row;
}

echo json_encode($kabupaten);
?>
