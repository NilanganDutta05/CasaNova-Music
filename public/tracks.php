<?php include '../includes/header.php'; ?>
<?php
include '../includes/db.php';

// Fetch all tracks
$sql = "SELECT tracks.*, albums.title AS album_title, artists.name AS artist_name FROM tracks 
        JOIN albums ON tracks.album_id = albums.id 
        JOIN artists ON tracks.artist_id = artists.id";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tracks - CasaNova Music</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        .track-card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .track-card img {
            border-radius: 15px 15px 0 0;
            width: 100%;
            height: auto;
        }
        .track-card-body {
            padding: 20px;
        }
        .track-title {
            font-size: 1.5em;
            color: #ff416c;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <?php while ($track = $result->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="track-card">
                        <img src="<?php echo htmlspecialchars($track['cover_art']); ?>" alt="Cover Art">
                        <div class="track-card-body">
                            <h5 class="track-title"><?php echo htmlspecialchars($track['title']); ?></h5>
                            <p>Album: <?php echo htmlspecialchars($track['album_title']); ?></p>
                            <p>Artist: <?php echo htmlspecialchars($track['artist_name']); ?></p>
                            <p>Genre: <?php echo htmlspecialchars($track['genre']); ?></p>
                            <audio controls>
                                <source src="<?php echo htmlspecialchars($track['file_path']); ?>" type="audio/mpeg">
                                Your browser does not support the audio element.
                            </audio>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
