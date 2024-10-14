<?php
include "koneksi.php";
session_start();

$Username = $_POST["username"];
$Password = $_POST["password"];

// Untuk keamanan, sebaiknya Anda menggunakan password hashing
$sql = mysqli_query($conn, "SELECT * FROM user WHERE username='$Username' and password='$Password'");

$cek = mysqli_num_rows($sql);

if ($cek == 1) {
    while ($data = mysqli_fetch_array($sql)) {
        $_SESSION["userid"] = $data["userid"];
        $_SESSION["namalengkap"] = $data["namalengkap"];
        $_SESSION['level'] = $data['level'];
    }
    header("location:home.php");
    exit();
} else {
    header("location:login.php?error=1");
    exit();
}
?>
