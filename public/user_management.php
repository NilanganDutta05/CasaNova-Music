<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: admin.php");
    exit();
}

include '../includes/db.php';
include '../includes/header.php'; // Ensure the navbar is included

if (isset($_GET['delete'])) {
    $userId = $_GET['delete'];
    $deleteSql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($deleteSql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    echo '<div class="alert alert-success" role="alert">User deleted successfully.</div>';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management - CasaNova Music</title>
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
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">User Management</h5>
                        <?php
                        $sql = "SELECT * FROM users";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            echo '<table class="table table-striped table-bordered">';
                            echo '<thead><tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Actions</th></tr></thead>';
                            echo '<tbody>';
                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . $row['id'] . '</td>';
                                echo '<td>' . $row['username'] . '</td>';
                                echo '<td>' . $row['email'] . '</td>';
                                echo '<td>' . $row['role'] . '</td>';
                                echo '<td>';
                                echo '<a href="edit_user.php?id=' . $row['id'] . '" class="btn btn-warning btn-sm">Edit</a> ';
                                echo '<a href="user_management.php?delete=' . $row['id'] . '" class="btn btn-danger btn-sm">Delete</a>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            echo '</tbody></table>';
                        } else {
                            echo '<div class="alert alert-info" role="alert">No users found.</div>';
                        }

                        $conn->close();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
