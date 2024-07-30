<?php include '../includes/header.php'; ?>
<?php
include '../includes/db.php';

// Handle playlist creation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $sql = "INSERT INTO playlists (user_id, name) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $_SESSION['user_id'], $name);
    if ($stmt->execute()) {
        header("Location: playlist.php");
        exit();
    } else {
        echo '<div class="alert alert-danger" role="alert">Error creating playlist.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Playlist - CasaNova Music</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        body {
            background: linear-gradient(to right, rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('../assets/images/music-bg.jpeg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            margin-top: 30px;
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
        .form-control {
            border-radius: 10px;
            background-color: rgba(255, 255, 255, 0.8);
            border: 1px solid #ddd;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Create New Playlist</h5>
                        <form method="POST">
                            <div class="form-group">
                                <label for="name">Playlist Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Create Playlist</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
