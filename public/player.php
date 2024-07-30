<?php
include '../includes/db.php';

// Fetch track details based on track_id
if (isset($_GET['track_id'])) {
    $track_id = $_GET['track_id'];

    $sql = "SELECT * FROM tracks WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $track_id);
    $stmt->execute();
    $track = $stmt->get_result()->fetch_assoc();
} else {
    $track = null; // Handle case where track_id is not set
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Player - CasaNova Music</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        body {
            background: linear-gradient(to right, rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('../assets/images/music-bg.jpeg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            min-height: 75vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 0px; /* Adjusted to ensure space for any content at the top */
            padding-bottom: 0px; /* Adjusted to ensure space for any content at the bottom */
        }
        .container {
            width: 100%;
            max-width: 800px; /* Set a max-width for the content */
            margin: 0 auto;
            padding: 0 0px;
        }
        .player-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 100%;
            max-width: 375px;
            margin: 20px auto;
        }
        .player-container h3 {
            margin-bottom: 5px;
            color: #ff416c;
        }
        .player-container audio {
            width: 100%;
            margin-bottom: 5px;
        }
        .player-container img {
            max-width: 100%;
            border-radius: 10px;
            margin-bottom: 5px;
        }
        .player-container p {
            color: #333; /* Darker color for better contrast */
            font-weight: bold; /* Optional: Make the text bold for better visibility */
        }
        .back-btn {
            margin-top: 15px;
            background-color: #ff416c;
            border-color: #ff416c;
        }
        .back-btn:hover {
            background-color: #ff4b2b;
            border-color: #ff4b2b;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="player-container">
            <?php if ($track): ?>
                <h3><?php echo htmlspecialchars($track['title']); ?></h3>
                <img src="<?php echo htmlspecialchars($track['cover_art']); ?>" alt="Cover Art">
                <audio controls>
                    <source src="<?php echo htmlspecialchars($track['file_path']); ?>" type="audio/mpeg">
                    Your browser does not support the audio element.
                </audio>
                <p>Artist: <span style="color: #ff416c;"><?php echo htmlspecialchars($track['artist']); ?></span></p>
                <p>Genre: <span style="color: #ff416c;"><?php echo htmlspecialchars($track['genre']); ?></span></p>
                <a href="javascript:history.back()" class="btn btn-primary back-btn">Back</a>
            <?php else: ?>
                <div class="alert alert-danger" role="alert">
                    Track not found or track_id is missing.
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
