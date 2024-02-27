<?php 
// $koneksi = mysqli_connect("localhost","id21845674_ennur","Endut123!","id21845674_skripsi3");
$koneksi = mysqli_connect("127.0.0.1","root","","skripsi3");
// Check connection
if (mysqli_connect_errno()){
	echo "Koneksi database gagal : " . mysqli_connect_error();
}
 
?>