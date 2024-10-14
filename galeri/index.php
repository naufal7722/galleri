<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GALERI FOTO</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for heart icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="style.css">

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

        .modal-body img {
            width: 100%;
            object-fit: contain;
            max-height: 400px; /* Batas maksimum tinggi gambar di modal */
        }

        /* Responsiveness */
        @media (max-width: 576px) {
            .modal-dialog {
                max-width: 95%;
            }
            
            .modal-body img {
                max-height: 250px; /* Ubah tinggi maksimum gambar untuk mobile */
            }
        }
        .modal-body {
    display: flex;
}

.image-container {
    flex: 1;
    padding-right: 20px; /* Space between image and comments */
}

.comments-container {
    flex: 1; /* Ensure the comments section takes the remaining space */
}

@media (max-width: 576px) {
    .modal-body {
        flex-direction: column; /* Stack vertically on smaller screens */
    }

    .image-container {
        padding-right: 0; /* Remove right padding */
    }
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
    </style>



</head>
<body>

<ul class="nav nav-pills mb-3 justify-content-center">
    <li class="nav-item"><a class="nav-link" href="login.php">LOGIN</a></li>
    <li class="nav-item"><a class="nav-link" href="register.php">REGISTER</a></li>
</ul>
<form method="GET" action="home.php" class="mb-4">

    </form>
<div class="container">
    <h1 class="my-4 text-center">GALERI FOTO</h1>
    <p class="text-center">Selamat Datang di <b>WEBSITE GALERI FOTO</b></p>

    <div class="row gallery d-flex justify-content-center">
        <?php
        include "koneksi.php";
        $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
        $sql = mysqli_query($conn, "SELECT * FROM foto, user WHERE foto.UserID=user.UserID");
        while ($data = mysqli_fetch_array($sql)) {
            // Ambil jumlah like dari tabel likefoto berdasarkan fotoid
            $fotoID = $data['fotoid'];
            $sql2 = mysqli_query($conn, "SELECT COUNT(*) as jumlah_like FROM likefoto WHERE fotoid='$fotoID'");
            $like_data = mysqli_fetch_assoc($sql2);
            $jumlah_like = $like_data['jumlah_like'];
        ?>
    <div class=" col-md-4 col-lg-2 text-center"> <!-- Center the content -->
            <div class="card">
                <a href="#" data-bs-toggle="modal" data-bs-target="#fotoModal<?=$data['fotoid']?>">
                    <img src="aset/<?=$data['lokasifile']?>" class="card-img-top" alt="<?=$data['judulfoto']?>">
                </a>
                <div class="card-body text-center">
                    <!-- Like icon -->
                    
                </div>
            </div>
        </div>

        <!-- Modal -->
       <!-- Modal -->
<div class="modal fade" id="fotoModal<?=$data['fotoid']?>" tabindex="-1" aria-labelledby="modalLabel<?=$data['fotoid']?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg"> <!-- Changed modal-sm to modal-lg -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel<?=$data['fotoid']?>"><?=$data['judulfoto']?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body d-flex"> <!-- Use flexbox to align content -->
                <div class="image-container" style="flex: 1; padding-right: 20px;"> <!-- Ensure there's space on the right -->
                    <img src="aset/<?=$data['lokasifile']?>" class="img-fluid mb-3" alt="<?=$data['judulfoto']?>">
                    <p><strong>Deskripsi:</strong> <?=$data['deskripsifoto']?></p>
                    <p><strong>Tanggal Unggah:</strong> <?=$data['tanggalunggah']?></p>
                    <p><strong>Uploader:</strong> <?=$data['namalengkap']?></p>
                    <span class="like-icon" data-fotoid="<?=$data['fotoid']?>" style="cursor: pointer;">
                        <i class="far fa-heart heart-icon"></i> 
                        <span class="like-count"><?=$jumlah_like?></span>
                    </span>
                </div>
                <div class="comments-container" style="flex: 1;"> <!-- New container for comments -->
                    

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
<!-- FontAwesome -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

<script>
    // Function to handle the like icon click
    document.querySelectorAll('.like-icon').forEach(icon => {
        icon.addEventListener('click', function() {
            alert("Silahkan Login untuk Like!");
        });
    });
</script>

</body>
</html>
