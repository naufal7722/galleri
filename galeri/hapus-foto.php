<?php
include"koneksi.php";
session_start();

$FotoID = $_GET["fotoid"];

$sql = mysqli_query($conn,"DELETE FROM foto WHERE fotoid='$FotoID'");

header("location:foto.php");
?>