<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="carrental.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .navbar a {
            padding: 14px 20px;
            display: inline-block;
            color: white;
            text-align: center;
            text-decoration: none;
        }
        .navbar {
            border-radius: 20px;
            font-size: larger;
            overflow: hidden;
            background-color: #333;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
        .navbar a.right {
            float: right;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        .bg-image {
            background-image: url('car2.jpg'); /* Ensure this image path is correct */
            filter: blur(8px);
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            position: relative;
        }
        .bg-text {
            text-align: center;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
        }
        .header h1 {
            font-size: 50px;
            margin-bottom: 20px;
        }
        .header p {
            font-size: 20px;
            margin-bottom: 40px;
        }
        .button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 12px;
        }
        .button a {
            color: white;
            text-decoration: none;
        }
        .button a:hover {
            color: #fff;
        }
    </style>
</head>
<body>
<div class="navbar">
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="admin_cars.php">Manage Cars</a>
    <a href="admin_requests.php">Manage Requests</a>
    <a href="admin_logout.php" class="right">Logout</a>
</div>

    <div class="bg-image"></div>
    <div class="bg-text">
        <center>
            <div class="header">
                <h1>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></h1>
                <p>Use the navigation above to manage cars and rental requests.</p>
            </div>
        </center>
    </div>
</body>
</html>
