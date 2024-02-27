<?php
require_once "koneksi.php";

$Id_Kab = $_POST['Id_Kab'];

$sql_kap = mysqli_query($koneksi, "SELECT * FROM kapanewon WHERE Id_Kab = '$Id_Kab'");

echo '<option>Pilih Kapanewon</option>';
while ($row_kap = mysqli_fetch_array($sql_kap)) {
    echo '<option value="' . $row_kap['Id_Kap'] . '">' . $row_kap['Nama_Kap'] . '</option>';
}
?>