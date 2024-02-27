<?php
require_once "koneksi.php";

$Id_Kel = $_POST['Id_Kel'];

$sql_sertif = mysqli_query($koneksi, "SELECT * FROM sertifikat WHERE Id_Kel = '$Id_Kel'");

echo '<option>Pilih Nomor Sertifikat</option>';
while ($row_sertif = mysqli_fetch_array($sql_sertif)) {
    echo '<option value="' . $row_sertif['Id_NoSertif'] . '">' . $row_sertif['Id_NoSertif'] . '</option>';
}
?>