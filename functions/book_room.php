<?php
session_start();
$roomid = $_POST['roomid'];
$userid = $_POST['userid'];
$startdate = $_POST['startdate'];
$enddate = $_POST['enddate'];

$conn = new mysqli("localhost", "root", "", "mdnhotel");
if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}

if ($startdate >= $enddate) {
    header("Location:./../room.php?id=$roomid&error=invaliddate");
    exit();
}

$sqll = "SELECT * FROM reservations WHERE UserId='$userid' AND RoomId='$roomid'";
$result = $conn->query($sqll);

if ($result->num_rows > 0) {
    header("Location:./../room.php?id=$roomid&error=alreadybooked");
    exit();
}
$sql = "INSERT INTO reservations (UserId, RoomId, StartDate, EndDate) VALUES ('$userid', '$roomid', '$startdate', '$enddate')";
if ($conn->query($sql) === TRUE) {
    header("Location:./../room.php?id=$roomid&success=booked");
} else {
    echo "Error: ". $sql. "<br>". $conn->error;
}
$conn->close();
?>