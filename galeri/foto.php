<?php
include "koneksi.php";
session_start();
if (!isset($_SESSION["userid"])) {
    header("location:login.php");
}
$user_role = $_SESSION['level'] ?? ''; // Mengambil role pengguna dari sesi
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FOTO</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* CSS for the navbar */
        .nav {
            background: rgba(255, 255, 255, 0.7); /* White with some transparency */
            backdrop-filter: blur(10px); /* Blurring effect */
            border-radius: 8px; /* Rounded corners */
            padding: 10px 20px; /* Padding for better spacing */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
        }

        /* Navbar links styling */
        .nav-link {
            color: #343a40; /* Dark color for links */
            font-weight: bold; /* Bold text */
            transition: color 0.3s ease; /* Smooth transition for hover effect */
        }

        .nav-link:hover {
            color: #007bff; /* Change color on hover */
        }
        
        .nav-item.dropdown:hover .dropdown-menu {
            display: block;
            position: relative;
            z-index: 10000; /* Pastikan dropdown berada di atas elemen lain */
        }
    </style>
</head>
<body>
    <ul class="nav nav-pills mb-3 justify-content-center">
        <li class="nav-item"><a class="nav-link" href="home.php">HOME</a></li>
        <li class="nav-item"><a class="nav-link" href="album.php">ALBUM</a></li>
        <li class="nav-item"><a class="nav-link" href="foto.php">FOTO</a></li>

        <!-- Cek apakah pengguna adalah admin -->
        <?php if ($user_role == 'admin'): ?>
            <li class="nav-item dropdown" style="position: relative; z-index: 9999;">
                <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    ADMIN
                </a>
                <ul class="dropdown-menu" aria-labelledby="adminDropdown" style="z-index: 10000;">
                    <li><a class="dropdown-item" href="admingaleri.php">Admin Galeri</a></li><br>
                    <li><a class="dropdown-item" href="adminfoto.php">Admin Foto</a></li>
                </ul>
            </li>
        <?php endif; ?>

        <li class="nav-item"><a class="nav-link" href="logout.php">LOGOUT</a></li>
    </ul>

    <h1>Tambah Foto</h1>
    <p>Selamat Datang <b><?=$_SESSION['namalengkap']?></b></p>

    <form action="tambah-foto.php" method="post" enctype="multipart/form-data">
        <table>
            <tr>
                <td>Judul Foto</td>
                <td>:</td>
                <td><input type="text" name="judulfoto" id="judulfoto" required></td>
            </tr>
            <tr>
                <td>Deskripsi</td>
                <td>:</td>
                <td><input type="text" name="deskripsifoto" id="deskripsifoto" required></td>
            </tr>
            <tr>
                <td>Album</td>
                <td>:</td>
                <td>
                    <select name="albumid" id="albumid">
                        <?php
                            // Admin can select from all albums
                            $sql = mysqli_query($conn, "SELECT album.albumid, album.namaalbum, user.namalengkap FROM album JOIN user ON album.userid=user.userid");
                       
                        while ($data = mysqli_fetch_array($sql)) {
                        ?>
                            <option value="<?=$data['albumid']?>"><?=$data['namaalbum']?> (<?=$data['namalengkap'] ?? 'Your Album'?>)</option>
                        <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Upload Foto</td>
                <td>:</td>
                <td><input type="file" accept=".jpg, .jpeg, .png, .gif, .jfif" name="lokasifile" id="lokasifile" required></td>
            </tr>
            <tr>
                <td><input type="submit" value="TAMBAH"></td>
            </tr>
        </table>
    </form>
    <br>
    <h2>Daftar Foto Kamu</h2>
    <div class="container">
        <div class="row">
            <?php
            // Query to retrieve all photos uploaded by the current user including uploader's name
            $UserID = $_SESSION['userid'];
            $sql = mysqli_query($conn, "
                SELECT foto.*, album.namaalbum, user.namalengkap 
                FROM foto 
                JOIN album ON foto.albumid = album.albumid 
                JOIN user ON foto.userid = user.userid 
                WHERE foto.userid = '$UserID'
            ");

            while ($data = mysqli_fetch_array($sql)) {
            ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card">
                        <img src="aset/<?=$data['lokasifile']?>" class="card-img-top" alt="<?=$data['judulfoto']?>" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?=$data['judulfoto']?></h5>
                            <p class="card-text"><?=$data['deskripsifoto']?></p>
                            <p><b>Album:</b> <?=$data['namaalbum']?></p>
                            <p><b>Tanggal:</b> <?=$data['tanggalunggah']?></p>
                            <p><b>Uploader:</b> <?=$data['namalengkap']?></p>
                            <p><b>Jumlah Like:</b> 
                                <?php
                                    $FotoID = $data['fotoid'];
                                    $sql2 = mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid='$FotoID'");
                                    echo mysqli_num_rows($sql2);
                                ?>
                            </p>
                            <a href="update-foto.php?fotoid=<?=$data['fotoid']?>" class="btn btn-warning btn-sm">Edit Foto</a>
                            <?php if ($_SESSION['level'] == 'admin') { ?> 
                                <a href="hapus-foto.php?fotoid=<?=$data['fotoid']?>" class="btn btn-danger btn-sm">Hapus Foto</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</body>
</html>
