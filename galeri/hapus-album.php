<?php
include"koneksi.php";
session_start();

$AlbumID = $_GET["albumid"];

$sql = mysqli_query($conn,"DELETE FROM album WHERE albumid='$AlbumID'");

header("location:album.php");
?>