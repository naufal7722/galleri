<?php
include "koneksi.php";
session_start();

// Memastikan user sudah login
if(!isset($_SESSION["userid"])){
    header("location:login.php");
}

// Mendapatkan fotoid dari URL
$fotoid = $_GET['albumid'];

// Mengambil data lama dari database berdasarkan fotoid
$sql = mysqli_query($conn, "SELECT * FROM album WHERE albumid='$fotoid'");
$data = mysqli_fetch_array($sql);

// Jika form disubmit
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $judulfoto = $_POST['namaalbum'];
    $deskripsifoto = $_POST['deskripsi'];

    

                // Update dengan gambar baru
                mysqli_query($conn, "UPDATE album SET namaalbum='$judulfoto', deskripsi='$deskripsifoto' WHERE albumid='$fotoid'");
                header("location:album.php");
            } else {
            }
        

?>

<!DOCTYPE html>
<html lang="en">

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Album</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        // Fungsi untuk pratinjau gambar
        function previewImage(event) {
            const image = document.getElementById('gambarLama');
            image.src = URL.createObjectURL(event.target.files[0]);
            image.style.display = 'block';
        }
    </script>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Update Foto</h1>
        
        <!-- Form untuk update foto -->
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="judulfoto" class="form-label">Nama Album</label>
                <input type="text" class="form-control" name="namaalbum" value="<?=$data['namaalbum']?>" required>
            </div>

            <div class="mb-3">
                <label for="deskripsifoto" class="form-label">Deskripsi </label>
                <textarea class="form-control" name="deskripsi" rows="4" required><?=$data['deskripsi']?></textarea>
            </div>


        
            

            <!-- Tombol submit -->
            <button type="submit" class="btn btn-primary">Update Album</button>
            <a href="foto.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
