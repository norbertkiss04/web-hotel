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
    $sql = "SELECT * FROM rooms WHERE Id='$roomId'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $image = $row['Image'];
    }
    if ($image != "DefaultRoomImg.png") {
        unlink("./../uploads/".$image);
    }

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
