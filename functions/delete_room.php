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

    // Start transaction
    $conn->begin_transaction();

    $query = "DELETE FROM rooms WHERE RoomNumber = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $roomNumber);
    $stmt->execute();

    // Commit transaction
    $conn->commit();

    echo "Room deleted successfully.";
} catch (Exception $e) {
    $conn->rollback();  // Rollback changes on error
    echo "Error deleting room: " . $e->getMessage();
}

$stmt->close();
$conn->close();

header('Location: ../adminpanel.php');
exit();
?>
