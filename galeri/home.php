<?php
include "koneksi.php";
session_start();
if (!isset($_SESSION["userid"])) {
    header("location:login.php");
}

// Pastikan kita memiliki informasi role di sesi
$user_role = $_SESSION['level'] ?? ''; // Mengambil role pengguna dari sesi
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GALLERY FOTO</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for heart icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">

    <style>
        /* CSS tambahan untuk mempercantik galeri */
        .gallery img {
            object-fit: cover;
            width: 100%;
            height: 250px;
            border-radius: 8px;
        }

        .gallery .card {
            margin-bottom: 20px;
        }

        .card-body {
            text-align: center;
        }

        /* Scrollable Album Section */
        .album-section {
            overflow-x: auto;
            white-space: nowrap;
        }

        .album-section a {
            display: inline-block;
            margin-right: 10px;
            padding: 10px;
            white-space: nowrap;
        }

        /* Modal Image Responsiveness */
        .modal-body img {
            width: 200%;
            object-fit: contain;
        }

        .like-icon {
            color: black;
        }

        /* Gaya untuk ikon hati yang sudah di-like */
        .modal-sm {
            max-width: 500px;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .like-count {
            user-select: none;
        }

        .heart-icon {
            color: black;
            user-select: none;
        }

        .heart-icon.fas {
            color: red;
            user-select: none;
        }

        .like-icon {
            font-size: 24px;
            transition: transform 0.2s;
            user-select: none;
        }

        .like-icon:hover {
            transform: scale(1.2);
        }

        .comment-text {
            text-align: left;
            margin-bottom: 0;
        }

        /* CSS for the navbar */
        .nav {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border-radius: 8px;
            padding: 10px 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .nav-link {
            color: #343a40;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #007bff;
        }

        .divider {
            border-top: 1px solid #ddd;
            margin: 20px 0;
        }

        .nav-item.dropdown:hover .dropdown-menu {
            display: block;
            position: relative;
            z-index: 10000;
        }
    </style>
</head>

<body style="background-image: url('your-background-image.jpg'); background-size: cover; background-position: center;">

<!-- Navbar -->
<ul class="nav nav-pills mb-3 justify-content-center">
    <li class="nav-item"><a class="nav-link" href="home.php">HOME</a></li>
    <li class="nav-item"><a class="nav-link" href="album.php">ALBUM</a></li>
    <li class="nav-item"><a class="nav-link" href="foto.php">FOTO</a></li>

    <!-- Cek apakah pengguna adalah admin -->
    <?php if ($user_role == 'admin'): ?>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                ADMIN
            </a>
            <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                <li><a class="dropdown-item" href="admingaleri.php">Admin Galeri</a></li><br>
                <li><a class="dropdown-item" href="adminfoto.php">Admin Foto</a></li>
            </ul>
        </li>
    <?php endif; ?>

    <a class="nav-link" href="logout.php" onclick="confirmLogout(event)">LOGOUT</a>
    </ul>

<h1 class="my-4 text-center">GALLERY FOTO</h1>

<!-- Album Section (Scrollable) -->


<!-- Form Pencarian -->
<form method="GET" action="home.php" class="mb-4">
    <div class="input-group">
        <input type="text" class="form-control" name="search" placeholder="Cari judul foto..." value="<?=isset($_GET['search']) ? $_GET['search'] : ''?>">
        <button class="btn btn-primary" type="submit">Cari</button>
    </div>
</form>

<div class="container">
    <p class="text-center">Selamat Datang <b><?=$_SESSION['namalengkap']?></b></p>
        <h5 class="my-4 text-center"> ALBUM</h5>
<div class="album-section d-flex justify-content-center mb-4">
    <?php
    // Query untuk mendapatkan semua album
    $album_sql = mysqli_query($conn, "SELECT * FROM album");
    while ($album = mysqli_fetch_array($album_sql)) {
    ?>
        <a href="home.php?albumid=<?=$album['albumid']?>" class="btn btn-outline-primary mx-2">
            <?=$album['namaalbum']?>
        </a>
    <?php
    }
    ?>
</div>


    <div class="row gallery d-flex justify-content-center">
    <h5 class="my-4 text-center">DAFTAR FOTO</h5>
    <?php
    // Cek apakah ada input pencarian atau album yang dipilih
    $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
    $albumid = isset($_GET['albumid']) ? mysqli_real_escape_string($conn, $_GET['albumid']) : '';
    
    // Menyiapkan query dasar
    $sql_base = "SELECT * FROM foto, user WHERE foto.userid=user.userid";
    
    // Menambahkan kondisi untuk album dan pencarian
    $conditions = [];
    
    if (!empty($albumid)) {
        $conditions[] = "foto.albumid='$albumid'";
    }
    
    if (!empty($search)) {
        $conditions[] = "judulfoto LIKE '%$search%'";
    }
    
    // Menggabungkan semua kondisi
    if (!empty($conditions)) {
        $sql = $sql_base . " AND " . implode(' AND ', $conditions);
    } else {
        // Jika tidak ada album yang dipilih dan tidak ada pencarian, ambil semua foto
        $sql = $sql_base;
    }
    
    $sql_result = mysqli_query($conn, $sql);
    while ($data = mysqli_fetch_array($sql_result)) {
        // Ambil jumlah like dari tabel likefoto berdasarkan fotoid
        $fotoID = $data['fotoid'];
        $sql2 = mysqli_query($conn, "SELECT COUNT(*) as jumlah_like FROM likefoto WHERE fotoid='$fotoID'");
        $like_data = mysqli_fetch_assoc($sql2);
        $jumlah_like = $like_data['jumlah_like'];
    ?>
    
        <div class="col-md-4 col-lg-2 text-center">
            <div class="card">
                <a href="#" data-bs-toggle="modal" data-bs-target="#fotoModal<?=$data['fotoid']?>">
                    <img src="aset/<?=$data['lokasifile']?>" class="card-img-top" alt="<?=$data['judulfoto']?>">
                </a>
                <div class="card-body">
                    <p class="card-text"><strong><?=$data['judulfoto']?></strong></p>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="fotoModal<?=$data['fotoid']?>" tabindex="-1" aria-labelledby="modalLabel<?=$data['fotoid']?>" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel<?=$data['fotoid']?>"><?=$data['judulfoto']?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
            <div class="modal-body d-flex">
                <div class="image-container" style="flex: 1; padding-right: 20px;">
                    <img src="aset/<?=$data['lokasifile']?>" class="img-fluid mb-3" alt="<?=$data['judulfoto']?>">
                    <p><strong>Deskripsi:</strong> <?=$data['deskripsifoto']?></p>
                    <p><strong>Tanggal Upload:</strong> <?=$data['tanggalunggah']?></p>
                    <p><strong>Uploader:</strong> <?=$data['namalengkap']?></p>
                    <span class="like-icon" data-fotoid="<?=$data['fotoid']?>" style="cursor: pointer;">
                        <i class="far fa-heart heart-icon"></i> 
                        <span class="like-count"><?=$jumlah_like?></span>
                    </span>
                    <a href="aset/<?=$data['lokasifile']?>" class="btn btn-success" download>
        <i class="fas fa-download"></i> Download
        
    </a>
    <button class="btn btn-info" onclick="printImage('aset/<?=$data['lokasifile']?>')">
        <i class="fas fa-print"></i> Print
    </button>
                   
                </div>

                <!-- Divider -->
                <div class="divider"></div> <!-- This is the line to separate photo and comments -->
                
                <div class="comments-container" style="flex: 1;">
                    <form id="commentForm<?=$data['fotoid']?>">
                        <div class="mb-3">
                            <label for="commentInput<?=$data['fotoid']?>" class="form-label">Tambahkan Komentar</label>
                            <textarea class="form-control" id="commentInput<?=$data['fotoid']?>" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                    </form>

                    <div class="comments-list" id="commentsList<?=$data['fotoid']?>">
                        <h5> Daftar Komentar:</h5>
                        <?php
                        $komentar_sql = mysqli_query($conn, "
                            SELECT k.isikomentar, k.tanggalkomentar, u.username
                            FROM komentarfoto k
                            JOIN user u ON k.userid = u.userid
                            WHERE k.fotoid='".$data['fotoid']."'
                            ORDER BY k.tanggalkomentar DESC
                        ");
                        while ($komentar = mysqli_fetch_array($komentar_sql)) {
                            echo '<div class="card mb-2">';
                            echo '    <div class="card-body">';
                            echo '        <h6 class="card-text comment-text">'.$komentar['username'].'</h6>';
                            echo '        <p class="card-text comment-text">'.$komentar['isikomentar'].'</p>';
                            echo '        <p class="card-text comment-text"><small class="text-muted">'.$komentar['tanggalkomentar'].'</small></p>';
                            echo '    </div>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <!-- Optional footer content -->
            </div>
        </div>
    </div>
</div>

        <?php
            }
        ?>
    </div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FontAwesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    
  
</script>
<script src="home.js"></script>
<script>
function printImage(imageSrc) {
    // Create a new window
    var printWindow = window.open('', '_blank');
    // Write the image and styles to the new window
    printWindow.document.write('<html><head><title>Print Image</title>');
    printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">');
    printWindow.document.write('</head><body>');
    printWindow.document.write('<img src="' + imageSrc + '" style="width: 100%; max-width: 600px;"/>'); // Adjust width as needed
    printWindow.document.write('</body></html>');
    printWindow.document.close(); // Close the document
    printWindow.print(); // Trigger print dialog
}
</script>
<script>
    function confirmLogout(event) {
    event.preventDefault(); // Prevent the default link action
    const confirmation = confirm("Apakah Anda yaqin ingin logout?");
    if (confirmation) {
        window.location.href = event.target.href; // Redirect to logout.php if confirmed
    }
}

</script>
</body>

</html>
