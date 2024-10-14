<?php
include"koneksi.php";
session_start();

$FotoID = $_POST["fotoid"];
$IsiKomentar = $_POST["isikomentar"];
$TanggalKomentar = date("y-m-d");
$UserID = $_SESSION["userid"];

$sql = mysqli_query($conn,"INSERT INTO komentarfoto VALUES('','$FotoID','$UserID','$IsiKomentar','$TanggalKomentar')");

header("location:home.php");
?>