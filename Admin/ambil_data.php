<?php
include "koneksi.php";

$id = $_POST['id'];
$modul = $_POST['modul'];

if($modul=='Kapanewon'){
     $sql = mysqli_query($koneksi, "SELECT * FROM kapanewon where Id_Kab = '$id' ORDER BY Nama_Kap ASC") or die(mysqli_error($koneksi));
     $kap = '<option>-----pilih kapanewon-----</option>';
     while($dt = mysqli_fetch_array($sql)){
          $kap.='<option value="'.$dt['Id_Kab'].'">'.$dt['Nama_Kap'].'</option>';
     }

     echo $kap;
}
?>