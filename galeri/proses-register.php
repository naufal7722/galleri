<?php
include "koneksi.php";

// Mengambil data dari form dan melakukan sanitasi
$Username = mysqli_real_escape_string($conn, $_POST["Username"]);
$Password = mysqli_real_escape_string($conn, $_POST["Password"]);
$Email = mysqli_real_escape_string($conn, $_POST["Email"]);
$NamaLengkap = mysqli_real_escape_string($conn, $_POST["NamaLengkap"]);
$Alamat = mysqli_real_escape_string($conn, $_POST["Alamat"]);
$Role = 'user'; // Set role to 'user'

// Cek apakah username sudah ada di database
$sqlCheckUsername = mysqli_query($conn, "SELECT * FROM user WHERE username='$Username'");
if (mysqli_num_rows($sqlCheckUsername) > 0) {
    // Jika username sudah ada, kembalikan ke halaman register dengan pesan error
    header("location:register.php?error=Username%20ini%20sudah%20digunakan");
    exit; // Pastikan untuk menghentikan eksekusi skrip setelah redirect
}

// Cek apakah email sudah ada di database
$sqlCheckEmail = mysqli_query($conn, "SELECT * FROM user WHERE email='$Email'");
if (mysqli_num_rows($sqlCheckEmail) > 0) {
    // Jika email sudah ada, kembalikan ke halaman register dengan pesan error
    header("location:register.php?error=Email%20ini%20sudah%20digunakan");
    exit; // Pastikan untuk menghentikan eksekusi skrip setelah redirect
}

// Hashing password sebelum disimpan
$HashedPassword = password_hash($Password, PASSWORD_DEFAULT);

// Jika username dan email belum ada, masukkan data ke database
$sql = mysqli_query($conn, "INSERT INTO user (username, password, email, namalengkap, alamat, level) 
                            VALUES ('$Username', '$HashedPassword', '$Email', '$NamaLengkap', '$Alamat', '$Role')");

// Redirect ke halaman login setelah registrasi sukses
header("location:login.php");
exit; // Pastikan untuk menghentikan eksekusi skrip setelah redirect
?>
