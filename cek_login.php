<?php 
// mengaktifkan session pada php
session_start();

// menghubungkan php dengan koneksi database
include 'koneksi.php';

// menangkap data yang dikirim dari form login
$username = $_POST['username'];
$password = $_POST['password'];

// menyeleksi data user dengan username dan password yang sesuai
$login = mysqli_query($koneksi,"select * from login where username='$username' and password='$password'");
// menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($login);

// cek apakah username dan password di temukan pada database
if($cek > 0){

    $data = mysqli_fetch_assoc($login);
    
    // cek jika user login sebagai admin
    if($data['level']=="admin"){

        // buat session login dan username
        $_SESSION['username'] = $username;
        $_SESSION['level'] = "admin";
        // alihkan ke halaman dashboard admin
        header("location:homeadmin.php");

    // cek jika user login sebagai manager
    }elseif($data['level']=="manager"){
        // buat session login dan username
        $_SESSION['username'] = $username;
        $_SESSION['level'] = "manager";
        // alihkan ke halaman dashboard manager
        header("location:homemanager.php");

    // cek jika user login sebagai user
    }elseif($data['level']=="user"){
        // buat session login dan username
        $_SESSION['username'] = $username;
        $_SESSION['level'] = "user";
        // alihkan ke halaman dashboard user
        header("location:homeuser2.php");

    }else{

        // alihkan ke halaman login kembali dengan pesan error
        header("location:login.html?pesan=akses_ditolak");
    }   
}else{
    // alihkan ke halaman login dengan pesan "username dan password belum terdaftar"
    header("location:login.html?pesan=belum_terdaftar");
}
?>

