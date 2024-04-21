<?php
    session_start();
    if (!isset($_SESSION['id'])) {
        header("Location: ./index.php");
    }
    $roomid = $_GET['roomId'];
    $conn = new mysqli("localhost", "root", "", "mdnhotel");
    if ($conn->connect_error) {
        die("Connection failed: ". $conn->connect_error);
    }
    $sql = "SELECT * FROM rooms WHERE Id='$roomid'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $roomname = $row['Name'];
        $price = $row['Price'];
        $capacity = $row['Capacity'];
        $wifi = $row['Wifi'] == 1 ? true : false;
        $balcony = $row['Balcony'] == 1 ? true : false;
        $ac = $row['AirConditioning'] == 1 ? true : false;
        $image = $row['Image'];
    }

    if (isset($_GET['error'])) {
        if ($_GET['error'] == 'emptyfields') {
            $msg = "Minden mezőt ki kell tölteni!";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/adminpanel_style.css">
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href=
    "https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&amp;display=swap">
    <title>Szoba módosítása</title>
</head>
<body>
<section>
    <h1>&nbsp;</h1>
    <?php
    if (isset($_GET['error'])) {
        if ($_GET['error'] == 'emptyfields') {
            echo '<div class="error-msg">Minden mezőt ki kell tölteni!</div>';
        }
        if ($_GET['error'] == 'unexpectederr') {
            echo '<div class="error-msg">Váratlan hiba történt!</div>';
        }
    }
    if (isset($_GET['msg'])) {
        if ($_GET['msg'] == 'success') {
            echo '<div class="success-msg">Sikeres módosítás!</div>';
        }
    }
    ?>
    <div class="section-title">Szoba módosítása</div>
    <form class="admin-panel-form" id="editRoomForm" method="post" action="./functions/edit_room.php" enctype="multipart/form-data">
        <input type="hidden" name="roomId" value="<?php echo $roomid ?>">
        <label class="admin-panel-from-subtitle">Neve: </label>
        <input class="admin-panel-form-input" type="text" id="roomName" value="<?php echo $roomname ?>" name="roomName" required placeholder="Szoba neve">
        <label class="admin-panel-from-subtitle">Férőhelyek száma: </label>
        <input class="admin-panel-form-input" type="number" id="capacity" value="<?php echo $capacity ?>" min="0" max="5" name="capacity" required placeholder="Férőhely">
        <label class="admin-panel-from-subtitle">Ára: </label>
        <input class="admin-panel-form-input" type="number" id="price" value="<?php echo $price ?>" name="price" required placeholder="Ár / Éjszaka">
            <label class="admin-panel-from-subtitle" for="roompic">Kép a szobáról: </label>
            <?php  
                echo '<img src="./uploads/'.$image.'" alt="Profil kép" class="profile-img">';
            ?>
            <input type="file" name="roompic" id="roompic">
        <div class="admin-panel-spec-input">
            <input type="checkbox" id="freewifi" name="freewifi">
            <label for="freewifi">Ingyenes internet</label><br>
        </div>
        <div class="admin-panel-spec-input">
            <input type="checkbox" id="balcony" name="balcony" >
            <label for="balcony">Terasz</label><br>
        </div>
        <div class="admin-panel-spec-input">
            <input type="checkbox" id="airconditioning" name="airconditioning">
            <label for="airconditioning">Légkonícionáló</label><br>
        </div>
        <button class="input-form-btn" type="submit">Szoba módosítása</button>
    </form>
</section>
</body>
</html>