<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $con = mysqli_connect("localhost", "root", "", "UserInformation");

    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $username = $_SESSION['username'];
    $car_model = $_POST['car_model'];
    $start_destination = $_POST['start_destination'];
    $end_destination = $_POST['end_destination'];
    $kilometers = $_POST['kilometers'];
    $driving_license = $_POST['driving_license'];
    $need_driver = $_POST['need_driver'];
    $status = 'pending'; // Default status

    // Calculate the price based on the distance
    if ($kilometers < 50) {
        $price = 700;
    } elseif ($kilometers <= 100) {
        $price = 1500;
    } elseif ($kilometers <= 150) {
        $price = 2000;
    } else {
        $price = 2000 + (($kilometers - 150) * 50);
    }

    // Add the driver cost if needed
    if ($need_driver == 'yes') {
        $price += 200;
    }

    $sql = "INSERT INTO rentals (username, car_model, start_destination, end_destination, kilometers, driving_license, price, status) VALUES ('$username', '$car_model', '$start_destination', '$end_destination', '$kilometers', '$driving_license', '$price', '$status')";

    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Car rented successfully'); window.location.href='dashboard.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($con);
    }

    mysqli_close($con);
}
?>
