<?php
session_start();
include '../includes/db.php';

if (!isset($_GET['playlist_id'])) {
    echo "Playlist ID not provided.";
    exit();
}

$playlist_id = $_GET['playlist_id'];

// Fetch playlist details
$sql = "SELECT * FROM playlists WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $playlist_id);
$stmt->execute();
$playlist = $stmt->get_result()->fetch_assoc();

if (!$playlist) {
    echo "Playlist not found.";
    exit();
}

// Fetch tracks in the playlist
$sql = "
    SELECT tracks.id, tracks.title, tracks.file_path, tracks.cover_art, albums.name AS album_name, albums.artist 
    FROM playlist_tracks 
    JOIN tracks ON playlist_tracks.track_id = tracks.id 
    LEFT JOIN albums ON tracks.album_id = albums.id 
    WHERE playlist_tracks.playlist_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $playlist_id);
$stmt->execute();
$tracks = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Playlist - CasaNova Music</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($playlist['name']); ?></h1>
        <ul class="list-group">
            <?php while ($track = $tracks->fetch_assoc()): ?>
                <li class="list-group-item">
                    <img src="<?php echo htmlspecialchars($track['cover_art']); ?>" alt="Cover Art" width="50" height="50">
                    <strong><?php echo htmlspecialchars($track['title']); ?></strong>
                    <small><?php echo htmlspecialchars($track['artist']); ?> - <?php echo htmlspecialchars($track['album_name']); ?></small>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
</body>
</html>
