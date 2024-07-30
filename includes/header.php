<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CasaNova Music</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
    <style>
        body {
            background: linear-gradient(to right, rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('../assets/images/music-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
        }
        .navbar {
            background-color: rgba(0, 0, 0, 0.8);
            font-family: Arial, Helvetica, sans-serif;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
        }
        .navbar-brand img {
            height: 40px; /* Adjust the height as needed */
            width: 40px; /* Ensure width matches height for a perfect circle */
            border-radius: 50%; /* Makes the image circular */
            margin-right: 10px;
            object-fit: cover; /* Ensures the image covers the circle area */
        }
        .navbar-brand, .nav-link {
            color: white !important;
        }
        .navbar-nav .nav-item .nav-link {
            margin-right: 15px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="index.php">
            <img src="../assets/images/logo.jpeg" alt="CasaNova Music Logo"> <!-- Logo Image -->
            CasaNova Music
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <?php if (!isset($_SESSION['user_id'])): ?>
                    <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <li class="nav-item"><a class="nav-link" href="admin.php">Admin</a></li>
                    <?php endif; ?>
                <?php endif; ?>
                <li class="nav-item"><a class="nav-link" href="upload.php">Upload</a></li>
                <li class="nav-item"><a class="nav-link" href="search.php">Search</a></li>
                <li class="nav-item"><a class="nav-link" href="playlist.php">Playlists</a></li>
            </ul>
        </div>
    </nav>
</body>
</html>
