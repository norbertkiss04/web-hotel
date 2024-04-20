<?php
session_start();
require './utils.php';  // Assume this contains necessary utility functions.


// Database connection
$conn = new mysqli("localhost", "root", "", "mdnhotel");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

try {
    $roomNumber = $_POST['roomNumber'];
    $capacity = $_POST['capacity'];
    $price = $_POST['price'];
    $wifi = isset($_POST['wifi']) ? 1 : 0;
    $balcony = isset($_POST['balcony']) ? 1 : 0;
    $ac = isset($_POST['ac']) ? 1 : 0;

    // Start transaction
    $conn->begin_transaction();

    $query = "INSERT INTO rooms (RoomNumber, Capacity, Price, Wifi, Balcony, AirConditioning) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iiiiii", $roomNumber, $capacity, $price, $wifi, $balcony, $ac);
    $stmt->execute();

    // Commit transaction
    $conn->commit();

    echo "Room added successfully.";
} catch (Exception $e) {
    $conn->rollback();  // Rollback changes on error
    echo "Error adding room: " . $e->getMessage();
}

$stmt->close();
$conn->close();

header('Location: ../adminpanel.php');
exit();
?>
