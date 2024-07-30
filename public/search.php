<?php include '../includes/header.php'; ?>
<?php
include '../includes/db.php';

// Initialize variables
$recommendations = [];
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['query'])) {
    $query = $_GET['query'];
    $search_term = "%$query%";

    // Get search recommendations
    $recommendation_sql = "SELECT DISTINCT id, title FROM tracks WHERE title LIKE ? LIMIT 5";
    $stmt = $conn->prepare($recommendation_sql);
    $stmt->bind_param("s", $search_term);
    $stmt->execute();
    $recommendation_result = $stmt->get_result();

    while ($rec = $recommendation_result->fetch_assoc()) {
        $recommendations[] = $rec; // Include id and title in recommendations
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search - CasaNova Music</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        body {
            background: linear-gradient(to right, rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('../assets/images/music-bg.jpeg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .search-bar {
            margin-top: 30px;
        }
        .recommendations {
            margin-top: 20px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            max-height: 400px; /* Set a max-height for the recommendations area */
            overflow-y: auto; /* Enable vertical scrolling */
        }
        .recommendations h5 {
            margin-bottom: 15px;
        }
        .recommendations a {
            color: #007bff;
            text-decoration: none;
        }
        .recommendations a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form method="GET" class="search-bar">
                    <div class="input-group mb-3">
                        <input type="text" name="query" class="form-control" placeholder="Search for tracks or genres" aria-label="Search" value="<?php echo htmlspecialchars(isset($_GET['query']) ? $_GET['query'] : ''); ?>" required>
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>
                </form>
                <?php if (!empty($recommendations)): ?>
                    <div class="recommendations">
                        <h5>Recommended Tracks:</h5>
                        <ul class="list-group">
                            <?php foreach ($recommendations as $rec): ?>
                                <li class="list-group-item">
                                    <a href="player.php?track_id=<?php echo $rec['id']; ?>">
                                        <?php echo htmlspecialchars($rec['title']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info" role="alert">
                        No recommendations found.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
