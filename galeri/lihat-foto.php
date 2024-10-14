<?php
include "koneksi.php";
session_start();
if (!isset($_SESSION["userid"])) {
    header("location:login.php");
}
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Foto</title>

    <style>
        /* Styling untuk galeri */
        .gallery img {
            object-fit: cover;
            width: 100%;
            height: 250px; /* Sesuaikan tinggi gambar sesuai keinginan */
            border-radius: 8px;
        }

        .gallery .card {
            margin-bottom: 20px;
        }

        .card-body {
            text-align: center;
        }

        /* Modal Image Responsiveness */
        .modal-body img {
            width: 200%;
            object-fit: contain;
        }
        .like-icon {
    color: black; /* Outline heart (unliked) berwarna putih */
}

/* Gaya untuk ikon hati yang sudah di-like */

/* Default styling for modal (desktop and large screens) */
.modal-sm {
    max-width: 500px; /* Slightly larger size for modal */
}
.card:hover {
    transform: scale(1.05); /* Scale card on hover */
}

.modal-body img {
    object-fit: contain;
    max-height: 250px; /* Increase the height limit of the image */
}

/* Adjustments for small screen sizes (mobile) */
@media (max-width: 576px) {
    .modal-dialog {
        max-width: 95%; /* Slightly larger modal width on small screens (95% of screen width) */
        margin: auto;
    }
    
    .modal-body img {
        max-height: 250px; /* Increase the height for better image visibility */
    }

    .modal-content {
        padding: 10px;
    }

    .modal-footer {
        display: flex;
        justify-content: center;
    }

    .modal-header .modal-title {
        font-size: 1.2rem; /* Adjust the font size slightly larger for mobile */
    }
}
.like-count {
    user-select: none; /* This prevents text selection */
}
.heart-icon {
    color: black; /* Outline will be black */
        user-select: none; /* This prevents text selection */

}
.heart-icon.fas {
    color: red; /* Solid heart when liked */
    user-select: none; /* This prevents text selection */

}
.like-icon {
    font-size: 24px; /* Sesuaikan ukuran sesuai keinginan */
    transition: transform 0.2s; /* Efek transisi saat hover */
    user-select: none;
}

.like-icon:hover {
    transform: scale(1.2); /* Membesarkan ikon saat hover */
}

.comment-text {
    text-align: left; /* Mengatur teks agar rata kiri */
    margin-bottom: 0; /* Menghapus margin bawah untuk merapikan tampilan */
}

/* CSS for the navbar */
.nav {
    background: rgba(255, 255, 255, 0.7); /* White with some transparency */
    backdrop-filter: blur(10px); /* Blurring effect */
    border-radius: 8px; /* Rounded corners */
    padding: 10px 20px; /* Padding for better spacing */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    position:relative;
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
/* Add some padding to the body for aesthetics */
.divider {
    border-top: 1px solid #ddd; /* Light gray color for the divider */
    margin: 20px 0; /* Margin above and below the divider */
}
/* CSS untuk menampilkan dropdown pada hover */
/* CSS untuk menampilkan dropdown pada hover dan memastikan tidak tertutup elemen lain */
.nav-item.dropdown:hover .dropdown-menu {
    display: block;
    position: relative;
    z-index: 10000; /* pastikan dropdown berada di atas elemen lain */
}
    </style>
</head>

<body>

    <!-- Navbar -->
    <ul class="nav nav-pills mb-3 justify-content-center">
        <li class="nav-item"><a class="nav-link" href="home.php">HOME</a></li>
        <li class="nav-item"><a class="nav-link" href="album.php">ALBUM</a></li>
        <li class="nav-item"><a class="nav-link" href="foto.php">FOTO</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">LOGOUT</a></li>
    </ul>

    <div class="container ">
        <?php
        // Ambil albumid dari URL
        $albumID = $_GET['albumid'];

        // Query untuk mengambil nama album berdasarkan albumid
        $albumQuery = mysqli_query($conn, "SELECT namaalbum FROM album WHERE albumid='$albumID'");
        $albumData = mysqli_fetch_array($albumQuery);
        ?>

        <!-- Tampilkan nama album sebagai judul -->
        <h1 class="text-center"><?= $albumData['namaalbum']; ?></h1>

        <div class="row gallery d-flex justify-content-center">
            <?php
            // Query untuk mengambil foto berdasarkan albumid
            $sql = mysqli_query($conn, "SELECT * FROM foto WHERE albumid='$albumID'");

            // Tampilkan foto-foto dari query
            while ($data = mysqli_fetch_array($sql)) {
                // Ambil jumlah like dari tabel likefoto berdasarkan fotoid
                $fotoID = $data['fotoid'];
                $sql2 = mysqli_query($conn, "SELECT COUNT(*) as jumlah_like FROM likefoto WHERE fotoid='$fotoID'");
                $like_data = mysqli_fetch_assoc($sql2);
                $jumlah_like = $like_data['jumlah_like'];            ?>
<div class="col-md-4 col-lg-2 text-center">
    <div class="card text-center">
        <a href="#" data-bs-toggle="modal" data-bs-target="#fotoModal<?=$data['fotoid']?>">
            <img src="aset/<?=$data['lokasifile']?>" class="card-img-top" alt="<?=$data['judulfoto']?>">
        </a>
        <div class="card-body">
            <p class="card-text"><strong><?=$data['judulfoto']?></strong></p>
        </div>
    </div>
</div>


            <!-- Modal untuk menampilkan foto dengan deskripsi -->
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

                <!-- Separator -->
                <div class="divider"></div>

                <!-- Comments Section -->
                <div class="comments-container" style="flex: 1;">
                    <form id="commentForm<?=$data['fotoid']?>">
                        <div class="mb-3">
                            <label for="commentInput<?=$data['fotoid']?>" class="form-label">Tambahkan Komentar</label>
                            <textarea class="form-control" id="commentInput<?=$data['fotoid']?>" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                    </form>

                    <div class="comments-list" id="commentsList<?=$data['fotoid']?>">
                        <h5>Daftar Komentar:</h5>
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
<script src="home.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

</body>
</html>
