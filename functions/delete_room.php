<?php
session_start();

    $conn = new mysqli("localhost", "root", "", "mdnhotel");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (!isset($_GET['roomId'])) {
        echo "Váratlan hiba történt! Kérjük próbálja újra!";
        header("Location: ./../adminpanel.php");
        exit();
    }
    $roomId = $_GET['roomId'];

    $query = "DELETE FROM reservations WHERE RoomId = '$roomId'";
    if ($conn->query($query) === FALSE) {
        echo "Error: " . $query . "<br>" . $conn->error;
        return;
    }
    $query = "DELETE FROM roomrating WHERE RoomId = '$roomId'";
    if ($conn->query($query) === FALSE) {
        echo "Error: " . $query . "<br>" . $conn->error;
        return;
    }
    $query = "DELETE FROM rooms WHERE Id = '$roomId'";
    if ($conn->query($query) === FALSE) {
        echo "Error: " . $query . "<br>" . $conn->error;
        return;
    }

    echo "Room deleted successfully.";
    header('Location: ./../adminpanel.php?msg=roomdeleted');

    $conn->close();
?>
