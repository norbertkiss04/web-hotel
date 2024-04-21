<?php
if (isset($_POST['review'], $_POST['userid'], $_POST['rating'], $_POST['roomid'])) {
    $review = $_POST['review'];
    $rating = $_POST['rating'];
    $user_id = $_POST['userid'];
    $roomid = $_POST['roomid'];

    if ($user_id == 0) {
        redirect_with_error("../sign_in.php", "notloggedin");
    }
    if ($rating < 1 || $rating > 5) {
        redirect_with_error("../product.php?id=$roomid", "invalidrating");
    }
    if (empty($review)) {
        redirect_with_error("../product.php?id=$roomid", "emptyreview");
    }

    add_review($review, $rating, $user_id, $roomid);
    header("Location: ../room.php?id=$roomid&success=reviewadded");
    exit();
}

function add_review($review, $rating, $user_id, $roomid) {
    $conn = new mysqli("localhost", "root", "", "mdnhotel");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "INSERT INTO roomrating (UserId, RoomId, Rating, Text) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("iiis", $user_id, $roomid, $rating, $review);
        $stmt->execute() or die("Error: " . $stmt->error);
        echo "Sikeres hozzászólás!";
        $stmt->close();
    } else {
        echo "Hiba történt: " . $conn->error;
    }
    $conn->close();
}

function redirect_with_error($url, $error) {
    header("Location: $url?error=$error");
    exit();
}
?>