<?php
include"koneksi.php";
session_start();

$NamaAlbum = $_POST["namaalbum"];
$Deskripsi = $_POST["deskripsi"];
$TanggalDibuat = date("y-m-d");
$UserID = $_SESSION["userid"];

$sql = mysqli_query($conn,"INSERT INTO album VALUES('','$NamaAlbum','$Deskripsi','$TanggalDibuat','$UserID')");

header("location:album.php");
?>