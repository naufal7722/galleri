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
    <title>ALBUM</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Tambahan styling untuk mempercantik tampilan album */
        .album-container {
            margin-top: 20px;
        }
        .album-card {
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }
        .album-card:hover {
            transform: scale(1.05);
        }
        .album-image {
            height: 150px; /* Atur tinggi gambar album */
            object-fit: cover; /* Mengatur agar gambar tidak terdistorsi */
            border-radius: 5px; /* Menambahkan border-radius untuk estetika */
        }
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
    z-index: 10000; /* pastikan dropdown berada di atas elemen lain */
}

    </style>
</head>
<body>
<!-- Your existing HTML code -->
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

<h1>Tambah Album</h1>

<!-- Form Tambah Album -->
<form action="tambah-album.php" method="post">
    <table>
        <tr>
            <td>Nama Album</td>
            <td>:</td>
            <td><input type="text" name="namaalbum" id="namaalbum" required></td>
        </tr>
        <tr>
            <td>Deskripsi</td>
            <td>:</td>
            <td><input type="text" name="deskripsi" id="deskripsi" required></td>
        </tr>
        <tr>
            <td><input type="submit" value="TAMBAH ALBUM"></td>
        </tr>
    </table>
</form>
<br>

<!-- Daftar Album -->

<!-- Container untuk daftar album -->
<div class="container album-container">
    <div class="row">
    <h2>Daftar Album</h2>
<?php
        // Mengambil semua album tanpa filter berdasarkan userid
        $sql = mysqli_query($conn, "SELECT * FROM album");

        // Menampilkan album yang diambil dari query
        while ($data = mysqli_fetch_array($sql)) {
            // Ambil foto pertama dari album
            $albumID = $data['albumid'];
            $foto_sql = mysqli_query($conn, "SELECT lokasifile FROM foto WHERE albumid='$albumID' LIMIT 1");
            $foto_data = mysqli_fetch_array($foto_sql);
            $foto_url = isset($foto_data['lokasifile']) ? 'aset/' . $foto_data['lokasifile'] : 'aset/default.jpg'; // Gambar default jika tidak ada foto
?>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card album-card">
                <img src="<?= $foto_url ?>" alt="<?= $data['namaalbum'] ?>" class="card-img-top album-image"> <!-- Menambahkan gambar album -->
                <div class="card-body">
                    <h5 class="card-title"><?= $data['namaalbum'] ?></h5>
                    <p class="card-text"><?= $data['deskripsi'] ?></p>
                    <a href="lihat-foto.php?albumid=<?= $data['albumid'] ?>" class="btn btn-primary d-inline-block">LIHAT FOTO</a>
                    <a href="update-album.php?albumid=<?= $data['albumid'] ?>" class="btn btn-danger d-inline-block">UPDATE ALBUM</a>                    
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
