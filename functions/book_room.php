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

$sql = "INSERT INTO reservations (UserId, RoomId, StartDate, EndDate) VALUES ('$userid', '$roomid', '$startdate', '$enddate')";
if ($conn->query($sql) === TRUE) {
    header("Location:./room.php?id=$roomid&success=booked");
} else {
    echo "Error: ". $sql. "<br>". $conn->error;
}
$conn->close();
?>