<?php
include '../includes/db.php'; // Include database connection file
include '../includes/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - CasaNova Music</title>
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
        .alert {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Register</h5>
                        <?php
                        // PHP code for registration form processing here
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            $username = $_POST['username'];
                            $email = $_POST['email'];
                            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

                            // Check for duplicate entries
                            $checkSql = "SELECT * FROM users WHERE username = ? OR email = ?";
                            $stmt = $conn->prepare($checkSql);
                            $stmt->bind_param("ss", $username, $email);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            if ($result->num_rows > 0) {
                                echo '<div class="alert alert-danger" role="alert">Username or Email already exists. Please try again with a different one.</div>';
                            } else {
                                // Insert new user if no duplicates found
                                $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("sss", $username, $email, $password);

                                if ($stmt->execute()) {
                                    echo '<div class="alert alert-success" role="alert">Registration successful!</div>';
                                } else {
                                    echo '<div class="alert alert-danger" role="alert">Error: ' . $stmt->error . '</div>';
                                }
                            }
                            $stmt->close();
                        }
                        ?>
                        <form method="POST">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
