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

if (isset($_POST['approve'])) {
    $id = $_POST['request_id'];
    $sql = "UPDATE rentals SET status='Approved' WHERE id='$id'";
    mysqli_query($con, $sql);
}

if (isset($_POST['cancel'])) {
    $id = $_POST['request_id'];
    $sql = "UPDATE rentals SET status='Cancelled' WHERE id='$id'";
    mysqli_query($con, $sql);

    // Retrieve car_id associated with the request
    $car_query = "SELECT car_id FROM rentals WHERE id='$id'";
    $car_result = mysqli_query($con, $car_query);
    if ($car_result) {
        $car_row = mysqli_fetch_assoc($car_result);
        $car_id = $car_row['car_id'];

        // Update car status to 'available'
        $update_car_status = "UPDATE cars SET status='available' WHERE id='$car_id'";
        mysqli_query($con, $update_car_status);
    }
}

$sql = "SELECT * FROM rentals";
$result = mysqli_query($con, $sql);

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Requests</title>
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
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            color: black; /* Adjusted text color for better visibility */
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
                <h1>Manage Requests</h1>
                <p>Here you can approve or cancel rental requests.</p>
            </div>
            <div class="form-container">
                <table>
                    <tr>
                        <th>Request ID</th>
                        <th>Username</th>
                        <th>Car Model</th>
                        <th>Starting Destination</th>
                        <th>Ending Destination</th>
                        <th>Kilometers</th>
                        <th>Price (BDT)</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo $row['car_model']; ?></td>
                            <td><?php echo $row['start_destination']; ?></td>
                            <td><?php echo $row['end_destination']; ?></td>
                            <td><?php echo $row['kilometers']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td><?php echo $row['rental_date']; ?></td>
                            <td>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                                    <input type="submit" name="approve" value="Approve" class="button">
                                    <input type="submit" name="cancel" value="Cancel" class="button">
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
