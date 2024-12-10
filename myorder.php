<?php
include "checksession.php";

$sql = "SELECT fname FROM registerhere WHERE uname='$usercheck'";
$link = mysqli_connect("localhost", "root", "", "UserInformation");
$r = mysqli_query($link, $sql);
$rs = mysqli_fetch_array($r);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link rel="stylesheet" href="carrental.css">
</head>
<body>
    <div class="navbar">
        <a href="carrental.php">Home</a>
        <a href="tarif.php">Tariffs</a>
        <a href="about.html">About Us</a>
        <a href="contact.html">Contact Us</a>
        <a href="logout.php" class="right">Logout</a>
        <a href="#" class="right">
            <?php echo "Hello! " . $rs['fname']; ?>
        </a>
        <a href="myorder.php" class="right">My Bookings</a>
        <a href="rent.php" class="right">Rent</a>
    </div>

    <div class="bg-image"></div>

    <div class="bg-text">
        <div class="header">
            <center>
                <?php
                $sql = "SELECT cc, dc, doi, dor, distance, status FROM request WHERE uname='$usercheck'";
                $link = mysqli_connect("localhost", "root", "", "UserInformation");
                $r = mysqli_query($link, $sql);

                if ($r) {
                    while ($rs = mysqli_fetch_array($r)) {
                        echo "Starting point: " . $rs['cc'] . "<br>";
                        echo "Destination point: " . $rs['dc'] . "<br>";
                        echo "Starting date: " . $rs['doi'] . "<br>";
                        echo "Ending date: " . $rs['dor'] . "<br>";
                        $distance = $rs['distance'];

                        $baseRate = 100; 
                        $extraRatePerKM = 5; 

                        $cost = $baseRate;

                        if ($distance > 50) {
                            $extraDistance = $distance - 50;
                            $cost += $extraDistance * $extraRatePerKM;
                        }
                        echo "Distance: " . $distance . " KMs<br>";
                        echo "Cost of Trip: " . $cost . " BDT<br>";
                        echo "Status: " . $rs['status'] . "<br>";
                        echo "<br>";
                    }
                } else {
                    echo "Error executing SQL query: " . mysqli_error($link);
                }
                ?>
            </center>
        </div>
    </div>
</body>
</html>
