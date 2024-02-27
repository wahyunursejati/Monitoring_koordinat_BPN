<?php
require_once "koneksi.php";

$Id_Kap = $_POST['Id_Kap'];

$sql_kel = mysqli_query($koneksi, "SELECT * FROM kelurahan WHERE Id_Kap = '$Id_Kap'");

echo '<option>Pilih Kelurahan</option>';
while ($row_kel = mysqli_fetch_array($sql_kel)) {
    echo '<option value="' . $row_kel['Id_Kel'] . '">' . $row_kel['Nama_Kelurahan'] . '</option>';
}
?>