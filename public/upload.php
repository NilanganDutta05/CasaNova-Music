<?php include '../includes/header.php'; ?>
<?php include '../includes/db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Song - CasaNova Music</title>
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
            padding-top: 0;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            margin-top: 50px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .card-title {
            text-align: center;
            font-size: 2em;
            color: #ff416c;
            margin-bottom: 20px;
        }
        .form-control, .form-control-file {
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
        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Upload Your Song</h5>
                        <?php
                        // Handle form submission
                        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["audio"])) {
                            $file_name = $_FILES["audio"]["name"];
                            $file_temp = $_FILES["audio"]["tmp_name"];
                            $file_size = $_FILES["audio"]["size"];
                            $file_error = $_FILES["audio"]["error"];
                            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

                            $allowed_ext = ['mp3', 'wav'];
                            $max_size = 5000000; // 5MB

                            if (!in_array($file_ext, $allowed_ext)) {
                                echo '<div class="alert alert-danger" role="alert">Invalid file type. Only MP3 and WAV files are allowed.</div>';
                            } elseif ($file_size > $max_size) {
                                echo '<div class="alert alert-danger" role="alert">File size exceeds the limit of 5MB.</div>';
                            } else {
                                if ($file_error === UPLOAD_ERR_OK) {
                                    $unique_name = uniqid('', true) . "." . $file_ext;
                                    $upload_path = "../uploads/" . $unique_name;
                                    
                                    if (move_uploaded_file($file_temp, $upload_path)) {
                                        $title = mysqli_real_escape_string($conn, $_POST['title']);
                                        $artist = mysqli_real_escape_string($conn, $_POST['artist']);
                                        $album = mysqli_real_escape_string($conn, $_POST['album']);
                                        $genre = mysqli_real_escape_string($conn, $_POST['genre']);
                                        $release_date = $_POST['release_date'];
                                        $website_url = mysqli_real_escape_string($conn, $_POST['website_url']);
                                        $file_path = mysqli_real_escape_string($conn, $upload_path);

                                        // Use prepared statement
                                        $stmt = $conn->prepare("INSERT INTO songs (title, artist, album, genre, release_date, file_path, website_url) VALUES (?, ?, ?, ?, ?, ?, ?)");
                                        $stmt->bind_param("sssssss", $title, $artist, $album, $genre, $release_date, $file_path, $website_url);
                                        
                                        if ($stmt->execute()) {
                                            echo '<div class="alert alert-success" role="alert">Song uploaded successfully!</div>';
                                        } else {
                                            echo '<div class="alert alert-danger" role="alert">Error uploading song: ' . $stmt->error . '</div>';
                                        }
                                        $stmt->close();
                                    } else {
                                        echo '<div class="alert alert-danger" role="alert">Error moving uploaded file.</div>';
                                    }
                                } else {
                                    echo '<div class="alert alert-danger" role="alert">Error: ' . $file_error . '</div>';
                                }
                            }
                        }
                        ?>
                        <form action="upload.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="form-group">
                                <label for="artist">Artist</label>
                                <input type="text" class="form-control" id="artist" name="artist" required>
                            </div>
                            <div class="form-group">
                                <label for="album">Album</label>
                                <input type="text" class="form-control" id="album" name="album">
                            </div>
                            <div class="form-group">
                                <label for="genre">Genre</label>
                                <input type="text" class="form-control" id="genre" name="genre">
                            </div>
                            <div class="form-group">
                                <label for="release_date">Release Date</label>
                                <input type="date" class="form-control" id="release_date" name="release_date">
                            </div>
                            <div class="form-group">
                                <label for="website_url">Website URL</label>
                                <input type="url" class="form-control" id="website_url" name="website_url" placeholder="https://example.com">
                            </div>
                            <div class="form-group">
                                <label for="audio">Select Audio File</label>
                                <input type="file" class="form-control-file" id="audio" name="audio" accept=".mp3, .wav"    >
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Upload Song</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
