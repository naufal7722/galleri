<?php
include "koneksi.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fotoid = $_POST['fotoid'];
    $isikomentar = $_POST['comment'];
    $userid = $_SESSION['userid']; // Mendapatkan userid dari session

    // Masukkan komentar ke database
    $query = "INSERT INTO komentarfoto (fotoid, userid, isikomentar, tanggalkomentar) VALUES ('$fotoid', '$userid', '$isikomentar', NOW())";
    if (mysqli_query($conn, $query)) {
        // Mendapatkan komentarid yang baru saja disisipkan
        $komentarid = mysqli_insert_id($conn);

        // Ambil username dan tanggal untuk ditampilkan
        $user_query = mysqli_query($conn, "SELECT username FROM user WHERE userid='$userid'");
        $user_data = mysqli_fetch_assoc($user_query);

        $response = [
            'status' => 'success',
            'komentarid' => $komentarid, // Tambahkan komentarid ke respons
            'username' => $user_data['username'],
            'tanggalkomentar' => date('Y-m-d H:i:s') // Format tanggal sesuai kebutuhan
        ];
    } else {
        $response = ['status' => 'error'];
    }

    echo json_encode($response);
}
?>
