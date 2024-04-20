<?php
session_start();

$conn = new mysqli("localhost", "root", "", "mdnhotel");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

try {
    if (!isset($_GET['roomId'])) {
        echo "Váratlan hiba történt! Kérjük próbálja újra!";
        header("Location: ./../adminpanel.php");
        exit();
    }
    $roomId = $_GET['roomId'];
    echo "Room ID: $roomId";

    $conn->begin_transaction();

    $query = "DELETE FROM rooms WHERE Id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $roomId);
    $stmt->execute();

    $conn->commit();

    echo "Room deleted successfully.";
    header('Location: ./../adminpanel.php?msg=roomdeleted');
} catch (Exception $e) {
    $conn->rollback();
    echo "Error deleting room: " . $e->getMessage();
}

// $stmt->close();
$conn->close();

// header('Location: ../adminpanel.php');
// exit();
?>
