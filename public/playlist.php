<?php 
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); 
    exit();
}
include '../includes/header.php'; 
include '../includes/db.php';

$user_id = $_SESSION['user_id'];

// Handle Playlist Search
$search_query = '';
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    $search_query = $_GET['search'];
    $sql = "SELECT * FROM playlists WHERE user_id = ? AND name LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_query = "%$search_query%";
    $stmt->bind_param("is", $user_id, $search_query);
} else {
    $sql = "SELECT * FROM playlists WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
}
$stmt->execute();
$playlists = $stmt->get_result();

// Function to fetch tracks for a given playlist
function getPlaylistTracks($playlist_id, $conn) {
    $sql = "
        SELECT tracks.id, tracks.title, tracks.file_path, tracks.cover_art, albums.name AS album_name, albums.artist 
        FROM playlist_tracks 
        JOIN tracks ON playlist_tracks.track_id = tracks.id 
        LEFT JOIN albums ON tracks.album_id = albums.id 
        WHERE playlist_tracks.playlist_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $playlist_id);
    $stmt->execute();
    return $stmt->get_result();
}

// Fetch all tracks for adding to playlist
$tracks_sql = "SELECT * FROM tracks";
$tracks_result = $conn->query($tracks_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Playlists - CasaNova Music</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        body {
            background: linear-gradient(to right, rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('../assets/images/music-bg.jpeg') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }
        .playlist-card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
        }
        .playlist-card:hover {
            transform: translateY(-10px);
        }
        .playlist-card-body {
            padding: 20px;
        }
        .playlist-title {
            font-size: 1.5em;
            color: #ff416c;
        }
        .track-select {
            width: auto;
            display: inline-block;
        }
        .header-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .header-buttons .btn {
            margin-left: 10px;
        }
        .form-inline {
            justify-content: center;
        }
        .track-info {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px;
            background-color: rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }
        .track-info img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }
        .track-details {
            margin-left: 10px;
        }
        .track-details strong {
            display: block;
        }
        .track-details small {
            color: #555;
        }
        .delete-btn {
            margin-left: auto;
        }
        .track-link {
            margin-left: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .track-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-buttons">
            <div>
                <a href="create_playlist.php" class="btn btn-success">+ Create Playlist</a>
            </div>
            <form method="GET" class="form-inline mb-3">
                <input type="text" class="form-control mr-2" name="search" placeholder="Search Playlists" value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
        <div class="row">
            <?php while ($playlist = $playlists->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="playlist-card">
                        <div class="playlist-card-body">
                            <h5 class="playlist-title"><?php echo htmlspecialchars($playlist['name']); ?></h5>
                            <form action="add_to_playlist.php" method="POST">
                                <input type="hidden" name="playlist_id" value="<?php echo $playlist['id']; ?>">
                                <div class="form-group">
                                    <select name="track_id" class="form-control track-select">
                                        <option value="">Select a track to add</option>
                                        <?php 
                                        $tracks_result->data_seek(0); 
                                        while ($track = $tracks_result->fetch_assoc()): ?>
                                            <option value="<?php echo $track['id']; ?>"><?php echo htmlspecialchars($track['title']); ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary mb-3">Add Track</button>
                            </form>
                            <form action="delete_playlist.php" method="POST">
                                <input type="hidden" name="playlist_id" value="<?php echo $playlist['id']; ?>">
                                <button type="submit" class="btn btn-danger delete-btn">Delete Playlist</button>
                            </form>
                            <h6 class="playlist-title">Tracks:</h6>
                            <?php 
                            $tracks = getPlaylistTracks($playlist['id'], $conn);
                            if ($tracks->num_rows > 0): 
                                while ($track = $tracks->fetch_assoc()): ?>
                                    <div class="track-info">
                                        <img src="<?php echo htmlspecialchars($track['cover_art']); ?>" alt="Cover Art">
                                        <div class="track-details">
                                            <strong><?php echo htmlspecialchars($track['title']); ?></strong>
                                            <small><?php echo htmlspecialchars($track['artist']); ?> - <?php echo htmlspecialchars($track['album_name']); ?></small>
                                        </div>
                                        <a href="player.php?track_id=<?php echo $track['id']; ?>" class="track-link">Play</a>
                                        <form action="delete_track.php" method="POST" class="delete-btn">
                                            <input type="hidden" name="playlist_id" value="<?php echo $playlist['id']; ?>">
                                            <input type="hidden" name="track_id" value="<?php echo $track['id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </div>
                                <?php endwhile; 
                            else: ?>
                                <p>No tracks in this playlist.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
