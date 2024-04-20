<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../sign_in.php");
    exit();
}

$userId = $_SESSION['id'];
$firstName = $_POST['firstname'] ?? '';
$lastName = $_POST['lastname'] ?? '';
$profilePic = $_FILES['profilepic'];

$conn = new mysqli("localhost", "root", "", "mdnhotel");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

try {
    $conn->begin_transaction();

    $query = "UPDATE users SET FirstName = ?, LastName = ? WHERE Id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $firstName, $lastName, $userId);
    $stmt->execute();
    
    if ($profilePic['error'] == UPLOAD_ERR_OK) {
        $target_dir = "./../uploads/";
        $target_file = $target_dir . basename($_FILES['profilepic']["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $check = getimagesize($_FILES['profilepic']["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
        } else {
            echo "File is not an image.";
            header('Location: ./../profile.php?err=notimg');
        }
        if (move_uploaded_file($_FILES['profilepic']["tmp_name"], $target_file)) {
            $sql = "UPDATE users SET ProfileImg = ? WHERE Id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $_FILES['profilepic']["name"], $userId);
            $stmt->execute();
            header('Location: ./../profile.php');
          } else {
            echo "Sorry, there was an error uploading your file.";
            header('Location: ./../profile.php?err=unexpectederr');
          }
    }

    $conn->commit();

} catch (Exception $e) {
    $conn->rollback();
    echo "Error updating profile: " . $e->getMessage();
}

$stmt->close();
$conn->close();

?>
