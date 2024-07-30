<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $playlist_id = $_POST['playlist_id'];
    $track_id = $_POST['track_id'];

    // Delete the track from the playlist
    $sql = "DELETE FROM playlist_tracks WHERE playlist_id = ? AND track_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $playlist_id, $track_id);

    if ($stmt->execute()) {
        header("Location: playlist.php");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
