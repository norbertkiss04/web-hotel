<?php
    if (isset($_POST['review'])) {
        if ($_POST['userid'] == 0) {
            header("Location: ../sign_in.php?error=notloggedin");
            exit();
        }
        if ($_POST['rating'] < 1 || $_POST['rating'] > 5) {
            header("Location: ../product.php?id=" . $_POST['roomid'] . "&error=invalidrating");
            exit();
        }
        if (empty($_POST['review'])) {
            header("Location: ../product.php?id=" . $_POST['roomid'] . "&error=emptyreview");
            exit();
        }

        $review = $_POST['review'];
        $rating = $_POST['rating'];
        $user_id = $_POST['userid'];
        $roomid = $_POST['roomid'];
        add_review($review, $rating, $user_id, $roomid);
        header("Location: ./../room.php?id=" . $roomid."&success=reviewadded");
    }

    function add_review($review, $rating, $user_id, $roomid) {
        $conn = new mysqli("localhost", "root", "", "mdnhotel");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "INSERT INTO roomrating (UserId, RoomId, Rating, Text) VALUES ('$user_id', '$roomid', '$rating', '$review')";
        if ($conn->query($sql) === FALSE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
            return;
        }
        echo "Sikeres hozzászólás!";
        $conn->close();
    }
?>