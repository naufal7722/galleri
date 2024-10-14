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

        table {
            width: 100%;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
        }

        th, td {
            padding: 10px;
        }

        img {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }
        .nav-item.dropdown:hover .dropdown-menu {
    display: block;
    position: relative;
    z-index: 10000; /* pastikan dropdown berada di atas elemen lain */
    width: 1px;
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

    <div class="container">
        <!-- Form Pencarian -->
        <form method="GET" action="">
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Cari Foto..." name="search" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
                <button class="btn btn-primary" type="submit">Cari</button>
            </div>
        </form>

        <h5>Daftar Foto</h5>
        <table>
            <thead>
                <tr>
                    <th>FotoID</th> <!-- Menambahkan kolom FotoID -->
                    <th>Foto</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Album</th>
                    <th>Tanggal Unggah</th>
                    <th>Jumlah Like</th>
                    <?php if ($_SESSION['level'] == 'admin') { ?>
                        <th>Uploader</th>
                    <?php } ?>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Ambil input pencarian
                $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

                // Query untuk admin
                if ($_SESSION['level'] == 'admin') {
                    $sql = mysqli_query($conn, "
                        SELECT foto.*, album.namaalbum, user.namalengkap 
                        FROM foto 
                        JOIN album ON foto.albumid=album.albumid 
                        JOIN user ON foto.userid=user.userid
                        WHERE foto.fotoid LIKE '%$search%' 
                        OR foto.judulfoto LIKE '%$search%' 
                        OR foto.deskripsifoto LIKE '%$search%' 
                        OR album.namaalbum LIKE '%$search%' 
                        OR user.namalengkap LIKE '%$search%'
                    ");
                } else {
                    // Query untuk user biasa
                    $UserID = $_SESSION['userid'];
                    $sql = mysqli_query($conn, "
                        SELECT foto.*, album.namaalbum 
                        FROM foto 
                        JOIN album ON foto.albumid=album.albumid 
                        WHERE foto.userid='$UserID'
                        AND (foto.fotoid LIKE '%$search%' 
                        OR foto.judulfoto LIKE '%$search%' 
                        OR foto.deskripsifoto LIKE '%$search%' 
                        OR album.namaalbum LIKE '%$search%')
                    ");
                }

                // Tampilkan hasil pencarian
                while ($data = mysqli_fetch_array($sql)) {
                ?>
                <tr>
                    <td><?=$data['fotoid']?></td> <!-- Menampilkan FotoID -->
                    <td><img src="aset/<?=$data['lokasifile']?>" alt="<?=$data['judulfoto']?>"></td>
                    <td><?=$data['judulfoto']?></td>
                    <td><?=$data['deskripsifoto']?></td>
                    <td><?=$data['namaalbum']?></td>
                    <td><?=$data['tanggalunggah']?></td>
                    <td>
                        <?php
                            $FotoID = $data['fotoid'];
                            $sql2 = mysqli_query($conn, "SELECT * FROM likefoto WHERE fotoid='$FotoID'");
                            echo mysqli_num_rows($sql2);
                        ?>
                    </td>
                    <?php if ($_SESSION['level'] == 'admin') { ?>
                        <td><?=$data['namalengkap']?></td>
                    <?php } ?>
                    <td>
                        <a href="update-foto.php?fotoid=<?=$data['fotoid']?>" class="btn btn-warning btn-sm">Edit</a>
                        <?php if ($_SESSION['level'] == 'admin') { ?>
                            <a href="hapus-foto.php?fotoid=<?=$data['fotoid']?>" class="btn btn-danger btn-sm">Hapus</a>
                        <?php } ?>
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
