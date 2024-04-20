<?php
    session_start();
    $conn = new mysqli("localhost", "root", "", "mdnhotel");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    $roomName = $_POST['roomName'];
    $capacity = $_POST['capacity'];
    $price = $_POST['price'];
    $wifi = isset($_POST['wifi']) ? 1 : 0;
    $balcony = isset($_POST['balcony']) ? 1 : 0;
    $ac = isset($_POST['ac']) ? 1 : 0;

    if (!isset($roomName) || trim($roomName) === "" || !isset($capacity) || trim($capacity) === "" || !isset($price) || trim($price) === "") {
        header('Location: ../adminpanel.php?war=emptyfields');
        return;
    }

    $query = "INSERT INTO rooms (Name, Capacity, Price, Wifi, Balcony, AirConditioning) VALUES ('$roomName', '$capacity', '$price', '$wifi', '$balcony', '$ac')";
    if ($conn->query($query) === FALSE) {
        echo "Error: " . $query . "<br>" . $conn->error;
        return;
    }
    echo "Room added successfully.";
    header('Location: ../adminpanel.php?msg=success');

    $conn->close();
    exit();
?>
