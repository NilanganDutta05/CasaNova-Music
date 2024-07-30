<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $playlist_id = $_POST['playlist_id'];
    $track_id = $_POST['track_id'];

    // Check if the track_id exists in the tracks table
    $track_check_sql = "SELECT id FROM tracks WHERE id = ?";
    $track_check_stmt = $conn->prepare($track_check_sql);
    $track_check_stmt->bind_param("i", $track_id);
    $track_check_stmt->execute();
    $track_check_stmt->store_result();

    if ($track_check_stmt->num_rows === 0) {
        // Track ID does not exist
        echo "Error: Track ID does not exist.";
        $track_check_stmt->close();
        exit();
    }
    $track_check_stmt->close();

    // Insert into playlist_tracks
    $sql = "INSERT INTO playlist_tracks (playlist_id, track_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $playlist_id, $track_id);

    if ($stmt->execute()) {
        header("Location: playlist.php?playlist_id=$playlist_id");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
