<?php
include "koneksi.php";
session_start();

if (!isset($_SESSION["userid"])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

$komentarid = $_POST['komentarid'];
$user_id = $_SESSION['userid'];

// Fetch the user ID of the comment's author
$sql = "SELECT userid FROM komentarfoto WHERE komentarid='$komentarid'";
$result = mysqli_query($conn, $sql);
if ($result) {
    $comment_data = mysqli_fetch_assoc($result);
    
    // Check if the logged-in user is the author of the comment
    if ($comment_data && $comment_data['userid'] == $user_id) {
        // Delete the comment from the database
        $delete_sql = "DELETE FROM komentarfoto WHERE komentarid='$komentarid'";
        if (mysqli_query($conn, $delete_sql)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus komentar.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'You do not have permission to delete this comment.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Comment not found.']);
}
?>
