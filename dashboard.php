<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

$con = mysqli_connect("localhost", "root", "", "UserInformation");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$username = $_SESSION['username'];
$sql = "SELECT * FROM rentals WHERE username = '$username' ORDER BY rental_date DESC";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="carrental.css">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f4f4f4;
        }
        .navbar {
            background-color: #333;
            overflow: hidden;
            border-radius: 5px;
        }
        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }
        .navbar a.right {
            float: right;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        .container {
            padding: 20px;
            max-width: 800px;
            margin: auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }
        input[type="text"], input[type="number"], select {
            width: 100%;
            padding: 10px;
            margin: 8px 0 20px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="carrental.html">Home</a>
        <a href="tarif.php">Tariffs</a>
        <a href="about.html">About Us</a>
        <a href="contact.html">Contact Us</a>
        <a href="logout.php" class="right">Logout</a>
    </div>
    <div class="container">
        <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
        <p>Rent a car by filling out the form below.</p>
        <form method="post" action="rent_car.php">
            <label for="car_model">Car Model:</label>
            <input type="text" id="car_model" name="car_model" required>

            <label for="start_destination">Starting Destination:</label>
            <input type="text" id="start_destination" name="start_destination" required>

            <label for="end_destination">Ending Destination:</label>
            <input type="text" id="end_destination" name="end_destination" required>

            <label for="kilometers">Kilometers:</label>
            <input type="number" id="kilometers" name="kilometers" required>

            <label for="driving_license">Driving License:</label>
            <input type="text" id="driving_license" name="driving_license" required>

            <label for="need_driver">Need a Driver?</label>
            <select id="need_driver" name="need_driver" required>
                <option value="no">No</option>
                <option value="yes">Yes</option>
            </select>

            <input type="submit" value="Rent Car">
        </form>

        <h2>Your Rental Requests</h2>
        <table border="1" cellpadding="10">
            <tr>
                <th>Car Model</th>
                <th>Starting Destination</th>
                <th>Ending Destination</th>
                <th>Kilometers</th>
                <th>Price (BDT)</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['car_model']}</td>";
                echo "<td>{$row['start_destination']}</td>";
                echo "<td>{$row['end_destination']}</td>";
                echo "<td>{$row['kilometers']}</td>";
                echo "<td>{$row['price']}</td>";
                echo "<td>{$row['status']}</td>";
                echo "<td>{$row['rental_date']}</td>";
                echo "</tr>";
            }
            ?>
        </table>
        <p><strong>Note:</strong> Tolls are not included in the payment and are to be paid by the customer. In case you need a driver, the cost is 200 BDT per day.</p>
    </div>
</body>
</html>

<?php
mysqli_close($con);
?>
