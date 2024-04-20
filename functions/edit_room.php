<?php
    session_start();
    if (!isset($_SESSION['id'])) {
        header("Location: ./index.php");
    }
    if (!isset($_POST["roomId"]) || trim($_POST["roomId"]) === "" || !isset($_POST["roomName"]) || trim($_POST["roomName"]) === "" || !isset($_POST["price"]) || trim($_POST["price"]) === "") {
        header("Location: ./../editroom.php?roomId=".$roomid."&error=emptyfields");
        return;
    }
    $roomid = $_POST["roomId"];
    $roomname = $_POST["roomName"];
    $roomprice = $_POST["price"];
    $roomcapacity = $_POST["capacity"];
    $roomwifi = isset($_POST["freewifi"]) ? 1 : 0;
    $roombalcony = isset($_POST["balcony"]) ? 1 : 0;
    $roomac = isset($_POST["airconditioning"]) ? 1 : 0;
    $roomimg = $_FILES["roompic"];

    if (!isset($roomname) || trim($roomname) === "" || !isset($roomprice) || trim($roomprice) === "" || !isset($roomcapacity) || trim($roomcapacity) === "") {
        echo "Room name is NOT set.";
        header("Location: ./../editroom.php?roomId=".$roomid."&error=emptyfields");
        return;
    }

    if ($roomimg["error"] == UPLOAD_ERR_OK) {
        $target_dir = "./../uploads/";
        $target_file = $target_dir . basename($roomimg["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($roomimg["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
        } else {
            echo "File is not an image.";
        }
        if (move_uploaded_file($roomimg["tmp_name"], $target_file)) {
            $name = $roomimg["name"];
            $query = "UPDATE rooms SET Name='$roomname', Capacity='$roomcapacity', Price='$roomprice', Wifi='$roomwifi', Balcony='$roombalcony', AirConditioning='$roomac', Image='$name' WHERE Id='$roomid'";
            $conn = new mysqli("localhost", "root", "", "mdnhotel");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            if ($conn->query($query) === FALSE) {
                echo "Error: " . $query . "<br>" . $conn->error;
                return;
            }
            echo "Room updated successfully.";
            header("Location: ./../adminpanel.php?msg=success");
        } else {
            echo "Sorry, there was an error uploading your file.";
            header("Location: ./../editroom.php?roomId=".$roomid."&error=unexpectederr");
        }
    } else {
        $name = $roomimg["name"];
        $query = "UPDATE rooms SET Name='$roomname', Capacity='$roomcapacity', Price='$roomprice', Wifi='$roomwifi', Balcony='$roombalcony', AirConditioning='$roomac' WHERE Id='$roomid'";
        $conn = new mysqli("localhost", "root", "", "mdnhotel");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        if ($conn->query($query) === FALSE) {
            echo "Error: " . $query . "<br>" . $conn->error;
            return;
        }
        echo "Room updated successfully.";
        header("Location: ./../adminpanel.php?msg=success");
    }
?>