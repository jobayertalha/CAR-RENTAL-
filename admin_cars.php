<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit();
}

$con = mysqli_connect("localhost", "root", "", "UserInformation");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete'])) {
        $id = $_POST['car_id'];
        $sql = "DELETE FROM cars WHERE id='$id'";
        if (mysqli_query($con, $sql)) {
            echo "<script>alert('Car deleted successfully'); window.location.href='admin_cars.php';</script>";
        } else {
            echo "<script>alert('Error deleting car');</script>";
        }
    } else {
        $car_name = $_POST['car_name'];
        $car_type = $_POST['car_type'];
        $rate_per_day = $_POST['rate_per_day'];

        $sql = "INSERT INTO cars (car_name, car_type, rate_per_day) VALUES ('$car_name', '$car_type', '$rate_per_day')";

        if (mysqli_query($con, $sql)) {
            echo "<script>alert('Car added successfully'); window.location.href='admin_cars.php';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }
    }
}

$sql = "SELECT * FROM cars";
$result = mysqli_query($con, $sql);

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Cars</title>
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
            margin-top: 20px;
        }
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            margin-top: 20px;
            color: white; /* Adjusted text color for better visibility */
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        input[type="submit"], input[type="button"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        input[type="submit"]:hover, input[type="button"]:hover {
            background-color: #45a049;
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
                <h1>Manage Cars</h1>
                <p>Here you can add new cars and manage existing ones.</p>
            </div>
            <div class="form-container">
                <form method="post" action="">
                    <table>
                        <tr>
                            <td>Car Name:</td>
                            <td><input type="text" name="car_name" required></td>
                        </tr>
                        <tr>
                            <td>Car Type:</td>
                            <td><input type="text" name="car_type" required></td>
                        </tr>
                        <tr>
                            <td>Rate per Day (BDT):</td>
                            <td><input type="number" name="rate_per_day" required></td>
                        </tr>
                    </table>
                    <input type="submit" value="Add Car">
                </form>
            </div>
            <div class="form-container">
                <table>
                    <tr>
                        <th>Car ID</th>
                        <th>Car Name</th>
                        <th>Car Type</th>
                        <th>Rate per Day</th>
                        <th>Actions</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_array($result)) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['car_name']; ?></td>
                            <td><?php echo $row['car_type']; ?></td>
                            <td><?php echo $row['rate_per_day']; ?></td>
                            <td>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="car_id" value="<?php echo $row['id']; ?>">
                                    <input type="submit" name="delete" value="Delete" class="button">
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </center>
    </div>
</body>
</html>
