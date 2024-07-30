<?php include '../includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CasaNova Music</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        body {
            background: linear-gradient(to right, rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('../assets/images/music-bg.jpeg') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }
        .gallery-title {
            text-align: center;
            margin-top: 50px;
            font-size: 3em;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: bold;
            background: linear-gradient(to right, #ff416c, #ff4b2b);
            -webkit-background-clip: text;
            color: white;
        }
        .card {
            margin: 20px;
            background-color: rgba(255, 255, 255, 0.85);
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            backdrop-filter: blur(10px);
        }
        .card:hover {
            transform: scale(1.0);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }
        .card-img-top {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            height: 200px;
            object-fit: cover;
            filter: brightness(0.8);
            transition: filter 0.3s;
        }
        .card:hover .card-img-top {
            filter: brightness(1);
        }
        .card-body {
            text-align: center;
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
        <h1 class="gallery-title">Featuring Now</h1>
        <div class="row">
            <!-- Example of a music card -->
            <?php
            // Example array of songs
            $songs = [
                [
                    "id" => 1,
                    "title" => "Album Title 1",
                    "artist" => "Artist Name 1",
                    "cover" => "../assets/images/cover_page1.jpeg"
                ],
                [
                    "id" => 2,
                    "title" => "Album Title 2",
                    "artist" => "Artist Name 2",
                    "cover" => "../assets/images/cover_page2.jpeg"
                ],
                [
                    "id" => 3,
                    "title" => "Album Title 3",
                    "artist" => "Artist Name 3",
                    "cover" => "../assets/images/cover_page3.jpeg"
                ]
            ];

            // Loop through each song and create a card
            foreach ($songs as $song) {
                echo '<div class="col-md-4">
                        <div class="card">
                            <img src="' . $song["cover"] . '" class="card-img-top" alt="' . $song["title"] . '">
                            <div class="card-body">
                                <h5 class="card-title">' . $song["title"] . '</h5>
                                <p class="card-text">' . $song["artist"] . '</p>
                                <a href="player.php?track_id=' . $song["id"] . '" class="btn btn-primary">Listen Now</a>
                            </div>
                        </div>
                    </div>';
            }
            ?>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
