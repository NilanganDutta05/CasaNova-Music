<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $playlist_id = $_POST['playlist_id'];

    // Delete the playlist
    $sql = "DELETE FROM playlists WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $playlist_id);

    if ($stmt->execute()) {
        header("Location: playlist.php");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
