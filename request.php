<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = $_SESSION['username'];
    $cc = $_POST['cc'];
    $dc = $_POST['dc'];
    $doi = $_POST['doi'];
    $dor = $_POST['dor'];
    $distance = $_POST['distance'];
    $car_id = $_POST['car_id']; // Assuming car_id is passed from the form

    $con = mysqli_connect("localhost", "root", "", "UserInformation");

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Insert rental request
    $sql = "INSERT INTO request (uname, cc, dc, doi, dor, distance, status, car_id) VALUES ('$uname', '$cc', '$dc', '$doi', '$dor', '$distance', 'Pending', '$car_id')";
    
    if (mysqli_query($con, $sql)) {
        // Update car status to 'rented'
        $update_car_status = "UPDATE cars SET status='rented' WHERE id='$car_id'";
        mysqli_query($con, $update_car_status);
        
        echo "<script>alert('Request submitted successfully'); window.location.href='user_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error: Could not submit request'); window.location.href='request.php';</script>";
    }

    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Rental Request</title>
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
        .form-container {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
            width: 60%;
            margin: 0 auto;
        }
        table {
            width: 100%;
            margin: auto;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="user_dashboard.php">Dashboard</a>
        <a href="request.php">Submit Request</a>
        <a href="logout.php" class="right">Logout</a>
    </div>
    <div class="bg-image"></div>
    <div class="bg-text">
        <center>
            <div class="header">
                <h1>Submit Your Rental Request</h1>
                <div class="form-container">
                    <form method="post" action="">
                        <table>
                            <tr>
                                <td>Car ID:</td> <!-- Assuming user selects car -->
                                <td><input type="number" name="car_id" required></td>
                            </tr>
                            <tr>
                                <td>Starting Point:</td>
                                <td><input type="text" name="cc" required></td>
                            </tr>
                            <tr>
                                <td>Destination Point:</td>
                                <td><input type="text" name="dc" required></td>
                            </tr>
                            <tr>
                                <td>Starting Date:</td>
                                <td><input type="date" name="doi" required></td>
                            </tr>
                            <tr>
                                <td>Ending Date:</td>
                                <td><input type="date" name="dor" required></td>
                            </tr>
                            <tr>
                                <td>Distance (in km):</td>
                                <td><input type="number" name="distance" required></td>
                            </tr>
                        </table>
                        <input type="submit" value="Submit Request">
                    </form>
                </div>
            </div>
        </center>
    </div>
</body>
</html>
