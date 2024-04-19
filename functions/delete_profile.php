<?php
    if (isset($_POST['userid'])) {
        $id = $_POST['userid'];
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