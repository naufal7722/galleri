<?php
include"koneksi.php";
session_start();
if(!isset($_SESSION["UserID"])){
    header("location:login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDIT ALBUM</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>GALLERY FOTO</h1>
    <p>Selamat Datang <b><?=$_SESSION['NamaLengkap']?></b></p>

    <ul>
        <li><a href="home.php">HOME</a></li>
        <li><a href="album.php">ALBUM</a></li>
        <li><a href="foto.php">FOTO</a></li>
        <li><a href="logout.php">LOGOUT</a></li>
    </ul>

    <form action="update-album.php" method="post">
        <?php
           $AlbumID=$_GET['AlbumID'];
           $sql=mysqli_query($conn,"SELECT * FROM album WHERE AlbumID='$AlbumID' ");
           while($data=mysqli_fetch_array($sql)){
        ?>
        <table>
        <input type="text" value="<?=$data['AlbumID']?>" name="AlbumID" id="AlbumID" hidden>
            <tr>
                <td>NamaAlbum</td>
                <td>:</td>
                <td><input type="text" value="<?=$data['NamaAlbum']?>" name="NamaAlbum" id="NamaAlbum" required></td>
            </tr>
            <tr>
                <td>Deskripsi</td>
                <td>:</td>
                <td><input type="text" value="<?=$data['Deskripsi']?>" name="Deskripsi" id="Deskripsi" required></td>
            </tr>
            <tr>
                <td><input type="submit" value="EDIT ALBUM"></td>
            </tr>
        </table>
        <?php
           }
        ?>
    </form>
</body>
</html>