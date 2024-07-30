<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include '../includes/db.php';
include '../includes/header.php'; // Ensure the navbar is included
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - CasaNova Music</title>
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
            margin-top: 20px;
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
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
            transition: background-color 0.3s, border-color 0.3s;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Welcome to Admin Dashboard</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <a href="user_management.php" class="btn btn-primary btn-block">Manage Users</a>
                            </div>
                            <div class="col-md-6">
                                <a href="site_settings.php" class="btn btn-secondary btn-block">Manage Playlists</a>
                            </div>
                        </div>
                        <!-- Optional: Display some statistics or data -->
                        <h6 class="text-center">Dashboard Overview</h6>
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <div class="card bg-light text-dark">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Users</h5>
                                        <?php
                                        $sql = "SELECT COUNT(*) as user_count FROM users";
                                        $result = $conn->query($sql);
                                        $data = $result->fetch_assoc();
                                        ?>
                                        <p class="card-text"><?php echo $data['user_count']; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light text-dark">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Playlists</h5>
                                        <?php
                                        $sql = "SELECT COUNT(*) as playlist_count FROM playlists";
                                        $result = $conn->query($sql);
                                        $data = $result->fetch_assoc();
                                        ?>
                                        <p class="card-text"><?php echo $data['playlist_count']; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light text-dark">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Tracks</h5>
                                        <?php
                                        $sql = "SELECT COUNT(*) as track_count FROM tracks";
                                        $result = $conn->query($sql);
                                        $data = $result->fetch_assoc();
                                        ?>
                                        <p class="card-text"><?php echo $data['track_count']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
