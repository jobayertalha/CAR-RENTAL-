<?php
session_start();

$uname1 = $_POST['uname'];
$pwd1 = $_POST['pwd'];

$con = mysqli_connect("localhost", "root", "", "UserInformation");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$q = "SELECT uname FROM registerhere WHERE uname='$uname1' AND pwd='$pwd1'";
$r = mysqli_query($con, $q);

if (mysqli_num_rows($r) == 1) {
    $_SESSION['username'] = $uname1;
    echo "Login successful!";
    header("Location: rent.php");
    exit();
} else {
    echo "<script>alert('Invalid username or password'); window.location.href='login.html';</script>";
}

mysqli_close($con);
?>
