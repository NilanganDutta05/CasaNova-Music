<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin.php");
    exit();
}

include '../includes/db.php';
include '../includes/header.php'; // Ensure the navbar is included

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_playlist'])) {
    $playlistId = $_POST['playlist_id'];

    // Delete the playlist
    $deletePlaylistSql = "DELETE FROM playlists WHERE id = ?";
    $stmt = $conn->prepare($deletePlaylistSql);
    $stmt->bind_param("i", $playlistId);
    $stmt->execute();

    // Delete associated tracks
    $deleteTracksSql = "DELETE FROM playlist_tracks WHERE playlist_id = ?";
    $stmt = $conn->prepare($deleteTracksSql);
    $stmt->bind_param("i", $playlistId);
    $stmt->execute();

    echo '<div class="alert alert-success" role="alert">Playlist deleted successfully.</div>';
}

// Fetch all playlists
$sql = "SELECT p.id, p.name, u.username FROM playlists p JOIN users u ON p.user_id = u.id ORDER BY p.name";
$result = $conn->query($sql);
$playlists = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Playlists - CasaNova Music</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        body {
            background: linear-gradient(to right, rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('../assets/images/music-bg.jpeg') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            margin-top: 50px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .card-body {
            padding: 30px;
        }
        .card-title {
            text-align: center;
            font-size: 2em;
            color: #ff416c;
            margin-bottom: 20px;
        }
        .table {
            background-color: rgba(255, 255, 255, 0.8);
            color: black;
        }
        .btn-primary {
            background-color: #ff416c;
            border-color: #ff416c;
            transition: background-color 0.3s, border-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #ff4b2b;
            border-color: #ff4b2b;
        }
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Manage Playlists</h5>
                        <?php if (!empty($playlists)): ?>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Playlist Name</th>
                                        <th>Created By</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($playlists as $playlist): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($playlist['name']); ?></td>
                                            <td><?php echo htmlspecialchars($playlist['username']); ?></td>
                                            <td>
                                                <form method="POST" class="d-inline">
                                                    <input type="hidden" name="playlist_id" value="<?php echo $playlist['id']; ?>">
                                                    <button type="submit" name="delete_playlist" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                                <a href="view_playlist.php?id=<?php echo $playlist['id']; ?>" class="btn btn-info btn-sm">View</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p>No playlists found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
