<?php
    if (isset($_GET['userid'])) {
        $id = $_GET['userid'];
        $conn = new mysqli("localhost", "root", "", "mdnhotel");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "DELETE FROM reservations WHERE UserId='$id'";
        if ($conn->query($sql) === FALSE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
            return;
        }
        $sql = "DELETE FROM roomrating WHERE UserId='$id'";
        if ($conn->query($sql) === FALSE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
            return;
        }
        $sql = "SELECT * FROM users WHERE Id='$id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $image = $row['ProfileImg'];
        }
        echo $image;
        if ($image != "DefaultProfileImg.png") {
            unlink("./../uploads/".$image);
        }
        $sql = "DELETE FROM users WHERE Id='$id'";
        if ($conn->query($sql) === FALSE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
            return;
        }
        $conn->close();
        echo "Sikeres törlés!";
        session_start();
        session_unset();
        session_destroy();
        header("Location: ./../index.php");
    } else {
        echo "Váratlan hiba történt! Kérjük próbálja újra!";
        header("Location: ../index.php");
        exit();
    }
?>