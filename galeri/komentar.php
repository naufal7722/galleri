<?php
include"koneksi.php";
session_start();
if(!isset($_SESSION["userid"])){
    header("location:login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HALAMAN KOMENTAR</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>GALLERY FOTO</h1>
    <p>Selamat Datang <b><?=$_SESSION['namalengkap']?></b></p>

    <ul>
        <li><a href="home.php">HOME</a></li>
        <li><a href="album.php">ALBUM</a></li>
        <li><a href="foto.php">FOTO</a></li>
        <li><a href="logout.php">LOGOUT</a></li>
    </ul>

    <form action="tambah-komentar.php" method="post">
        <?php
           $FotoID = $_GET['fotoid'];
           $sql=mysqli_query($conn,"SELECT * FROM foto, user WHERE foto.fotoid='$FotoID' and foto.userid=user.userid ");
           while($data=mysqli_fetch_array($sql)){
        ?>
        <table>
        <input type="text" value="<?=$data['fotoid']?>" name="fotoid" id="fotoid" hidden>
            <tr>
                <td>Isi Komentar</td>
                <td>:</td>
                <td><textarea name="isiKomentar" id="isiKomentar" cols="22" rows="5" required></textarea></td>
            </tr>
            <tr>
                <td><input type="submit" value="TAMBAH KOMENTAR"></td>
            </tr>
        </table>
        <?php
           }
        ?>
    </form>
    <br>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>ISI KOMENTAR</th>
            <th>TANGGAL KOMENTAR</th>
            <th>NAMA PENGGUNA</th>
        </tr>
        <?php
           $FotoID = $_GET['fotoid'];
           $sql=mysqli_query($conn,"SELECT * FROM komentarfoto,user WHERE komentarfoto.userid and komentarfoto.fotoid='$FotoID' ");
           while($data=mysqli_fetch_array($sql)){
        ?>
        <tr>
            <td><?=$data['komentarid']?></td>
            <td><?=$data['isikomentar']?></td>
            <td><?=$data['tanggalkomentar']?></td>
            <td><?=$data['namalengkap']?></td>
        </tr>
        <?php
           }
        ?>
    </table>
</body>
</html>