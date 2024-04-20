<?php
    session_start();
    $conn = new mysqli("localhost", "root", "", "mdnhotel");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (!isset($_POST['roomName'])) {
        echo "Room name is NOT set.";
    }
    //
    $roomName = $_POST['roomName'];
    $capacity = $_POST['capacity'];
    $price = $_POST['price'];
    $wifi = isset($_POST['wifi']) ? 1 : 0;
    $balcony = isset($_POST['balcony']) ? 1 : 0;
    $ac = isset($_POST['ac']) ? 1 : 0;
    $img = $_FILES['roompic'];

    if (!isset($roomName) || trim($roomName) === "" || !isset($capacity) || trim($capacity) === "" || !isset($price) || trim($price) === "") {
        header('Location: ../adminpanel.php?war=emptyfields');
        return;
    }
    
    if (!isset($img)) {
        echo "Image is NOT set.";
        header('Location: ../adminpanel.php?war=emptyfields');
    }

    if ($img['error'] == UPLOAD_ERR_OK) {
        $target_dir = "./../uploads/";
        $target_file = $target_dir . basename($img["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $check = getimagesize($img["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
        } else {
            echo "File is not an image.";
        }
        if (move_uploaded_file($img["tmp_name"], $target_file)) {
            $name = $img["name"];
            $query = "INSERT INTO rooms (Name, Capacity, Price, Wifi, Balcony, AirConditioning, Image) VALUES ('$roomName', '$capacity', '$price', '$wifi', '$balcony', '$ac', '$name')";
            if ($conn->query($query) === FALSE) {
                echo "Error: " . $query . "<br>" . $conn->error;
                return;
            }
            echo "Room added successfully.";
            header('Location: ../adminpanel.php?msg=success');
        } else {
            echo "Sorry, there was an error uploading your file.";
            header('Location: ./../profile.php?err=unexpectederr');
        }
    } else {
        echo "Error uploading file.";
        header('Location: ../adminpanel.php?war=emptyfields');
    }
    $conn->close();
    exit();
?>
