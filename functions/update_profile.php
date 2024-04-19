<?php
session_start();
include './utils.php'; // Assume this contains necessary utility functions.

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: ../sign_in.php");
    exit();
}

$userId = $_SESSION['id'];
$firstName = $_POST['firstname'] ?? '';
$lastName = $_POST['lastname'] ?? '';
$profilePic = $_FILES['profilepic'];

// Database connection
$conn = new mysqli("localhost", "root", "", "mdnhotel");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

try {
    // Start transaction
    $conn->begin_transaction();

    $query = "UPDATE users SET FirstName = ?, LastName = ? WHERE Id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $firstName, $lastName, $userId);
    $stmt->execute();
    
    // Check if a new profile picture was uploaded
    if ($profilePic['error'] == UPLOAD_ERR_OK) {
        $tmpName = $profilePic['tmp_name'];
        $imgData = file_get_contents($tmpName);
        $base64 = 'data:' . $profilePic['type'] . ';base64,' . base64_encode($imgData);

        $query = "UPDATE users SET ProfileImg = ? WHERE Id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $base64, $userId);
        $stmt->execute();
    }

    // Commit transaction
    $conn->commit();

    echo "Profile updated successfully.";
} catch (Exception $e) {
    $conn->rollback(); // Rollback changes on error
    echo "Error updating profile: " . $e->getMessage();
}

$stmt->close();
$conn->close();

// Redirect back to profile page
header('Location: ../profile.php');
exit();
?>
