<?php
session_start();
$conn = connectToDatabase();

if (!isset($_POST['roomName'], $_POST['capacity'], $_POST['price'])) {
    redirectTo('../adminpanel.php?war=emptyfields');
}

$roomName = trim($_POST['roomName']);
$capacity = trim($_POST['capacity']);
$price = trim($_POST['price']);
$wifi = isset($_POST['wifi']);
$balcony = isset($_POST['balcony']);
$ac = isset($_POST['ac']);

if (empty($roomName) || empty($capacity) || empty($price)) {
    redirectTo('../adminpanel.php?war=emptyfields');
}

if (checkRoomExists($roomName)) {
    redirectTo('../adminpanel.php?war=nametaken');
}

if (isset($_FILES['roompic'])) {
    $img = $_FILES['roompic'];
    if ($img['error']!= UPLOAD_ERR_OK) {
        redirectTo('../adminpanel.php?war=emptyfields');
    }

    $target_dir = "./../uploads/";
    $target_file = $target_dir. basename($img["name"]);
    if (!is_uploaded_file($img["tmp_name"]) ||!getimagesize($img["tmp_name"])) {
        redirectTo('../adminpanel.php?war=invalidimage');
    }

    if (!move_uploaded_file($img["tmp_name"], $target_file)) {
        redirectTo('../profile.php?err=unexpectederr');
    }

    $name = $img["name"];
    $query = "INSERT INTO rooms (Name, Capacity, Price, Wifi, Balcony, AirConditioning, Image) VALUES ('$roomName', '$capacity', '$price', '$wifi', '$balcony', '$ac', '$name')";
    if ($conn->query($query) === FALSE) {
        echo "Error: ". $query. "<br>". $conn->error;
        return;
    }
    redirectTo('../adminpanel.php?msg=success');
} else {
    redirectTo('../adminpanel.php?war=emptyfields');
}

$conn->close();
exit();

function connectToDatabase() {
    $conn = new mysqli("localhost", "root", "", "mdnhotel");
    if ($conn->connect_error) {
        die("Connection failed: ". $conn->connect_error);
    }
    return $conn;
}

function redirectTo($url) {
    header('Location: '. $url);
    exit();
}

function checkRoomExists($roomName) {
    global $conn;
    $stmt = $conn->prepare("SELECT COUNT(*) FROM rooms WHERE Name =?");
    $stmt->bind_param("s", $roomName);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    return $count > 0;
}