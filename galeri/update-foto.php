<?php
include "koneksi.php";
session_start();

// Memastikan user sudah login
if(!isset($_SESSION["userid"])){
    header("location:login.php");
}

// Mendapatkan fotoid dari URL
$fotoid = $_GET['fotoid'];

// Mengambil data lama dari database berdasarkan fotoid
$sql = mysqli_query($conn, "SELECT * FROM foto WHERE fotoid='$fotoid'");
$data = mysqli_fetch_array($sql);

// Jika form disubmit
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $judulfoto = $_POST['judulfoto'];
    $deskripsifoto = $_POST['deskripsifoto'];

    // Cek apakah ada file gambar baru di-upload
    if($_FILES['lokasifile']['name'] != ''){
        $rand = rand();
        $ekstensi =  array('png','jpg','jpeg','gif','jfif');
        $filename = $_FILES['lokasifile']['name'];
        $ukuran = $_FILES['lokasifile']['size'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        // Validasi ekstensi file gambar
        if(!in_array($ext, $ekstensi)) {
            echo "Ekstensi file tidak valid!";
        } else {
            if($ukuran < 104407098){ // Cek ukuran file
                $xx = $rand.'_'.$filename;
                move_uploaded_file($_FILES['lokasifile']['tmp_name'], 'aset/'.$xx);

                // Update dengan gambar baru
                mysqli_query($conn, "UPDATE foto SET judulfoto='$judulfoto', deskripsifoto='$deskripsifoto', lokasifile='$xx' WHERE fotoid='$fotoid'");
                header("location:foto.php");
            } else {
                echo "Ukuran file terlalu besar!";
            }
        }
    } else {
        // Jika tidak ada gambar baru yang di-upload, hanya update judul dan deskripsi
        mysqli_query($conn, "UPDATE foto SET judulfoto='$judulfoto', deskripsifoto='$deskripsifoto' WHERE fotoid='$fotoid'");
        header("location:adminfoto.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Foto</title>
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
                <label for="judulfoto" class="form-label">Judul Foto</label>
                <input type="text" class="form-control" name="judulfoto" value="<?=$data['judulfoto']?>" required>
            </div>

            <div class="mb-3">
                <label for="deskripsifoto" class="form-label">Deskripsi Foto</label>
                <textarea class="form-control" name="deskripsifoto" rows="4" required><?=$data['deskripsifoto']?></textarea>
            </div>

            <div class="mb-3">
                <label for="gambar" class="form-label">Upload Gambar Baru (Opsional)</label>
                <input type="file" class="form-control" name="lokasifile" accept=".jpg, .jpeg, .png, .gif, .jfif" onchange="previewImage(event)">
                <p><small>Jika tidak ingin mengganti foto, biarkan kosong.</small></p>
            </div>

            <!-- Menampilkan gambar lama -->
            <div class="mb-3">
                <label for="gambarLama" class="form-label"></label>
                <div>
                    <img src="aset/<?=$data['lokasifile']?>" alt="Gambar Lama" class="img-fluid" id="gambarLama" style="max-width: 300px; height: auto;">
                </div>
            </div>

            <!-- Tombol submit -->
            <button type="submit" class="btn btn-primary">Update Foto</button>
            <a href="foto.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
