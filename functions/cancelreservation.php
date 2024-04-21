<?php
    if (isset($_POST["roomid"])) {
        session_start();
        if (!isset($_POST["roomid"])) {
            echo "Váratlan hiba történt! Kérjük próbálja újra!";
            header("Location: ./../profile.php");
            return;
        }
        $roomid = $_POST["roomid"];
        $userid = $_SESSION['id'];
        echo "Room ID: $roomid, User ID: $userid";
        $conn = new mysqli("localhost", "root", "", "mdnhotel");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "DELETE FROM reservations WHERE RoomId='$roomid' AND UserId='$userid'";
        if ($conn->query($sql) === FALSE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
            return;
        }
        echo "Sikeres törlés!";
        $conn->close();
        header("Location: ./../profile.php");
    }
?>