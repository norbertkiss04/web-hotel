<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./css/profile_style.css">
    <script
      src="https://kit.fontawesome.com/e8a7f12e99.js"
      crossorigin="anonymous"
    ></script>
      <link rel="stylesheet" href=
      "https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&amp;display=swap">
    <script src="./js/global.js"></script>
    <title>Profilom</title>
  </head>
  <?php
  include './functions/utils.php';
    session_start();
    if (!isset($_SESSION['id'])) {
        header("Location: ./sign_in.php");
        exit();
    }
    $myid = $_SESSION['id'];

    $conn = new mysqli("localhost", "root", "", "mdnhotel");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM users WHERE Id='$myid'";
    
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $lastname = $row["LastName"];
        $firstname = $row["FirstName"];
        $email = $row["Email"];
        $profilepic = $row["ProfileImg"];
    }

    $sql = "SELECT rooms.Id, rooms.Name, rooms.Price, rooms.Capacity, rooms.Wifi, rooms.Balcony, rooms.AirConditioning, res.Id AS ResId, res.StartDate, res.EndDate FROM rooms INNER JOIN reservations AS res ON res.UserId = '$myid' AND res.RoomId = rooms.Id;";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $bookings = array();
        while ($row = $result->fetch_assoc()) {
            $bookings[] = $row;
        }
    }
    $conn->close();
?>
  <body>
    <header>
        <div class="nav-container">
            <div class="logo">
                <p class="x">MDN</p>
                <p>Hotel</p>
            </div>
            <div class="nav-bar">
                <nav class="nav">
                    <ul>
                        <li><a href="./index.php">Főoldal</a></li>
                        <li><a href="./reservation.php">Szobáink</a></li>
                        <li><a href="./gallery.php">Galéria</a></li>
                    </ul>
                </nav>
                <div class="book-now">
                    <?php
                    if (isset($_SESSION['id'])) {
                        echo '<a class="book-now-text" href="./reservation.php">FOGLALÁS</a>';
                        echo '<a class="my-account-text m-l-24" href="./profile.php">Profilom</a>';
                        if ($_SESSION['IsAdmin'] == 1) {
                            echo '<a class="my-account-text" href="./adminpanel.php">AdminPanel</a>';
                        }
                        echo '<a class="my-account-text" href="./functions/sign_out.php">Kijelentkezés</a>';
                    } else {
                        echo '<a class="my-account-text" href="./sign_in.php">Bejelentkezés</a></li>';
                        echo '<a class="book-now-text" href="./sign_up.php">Regisztráció</a>';
                    }
                    ?>
                </div>
                <div class="hamburger-menu-icon" onclick="showHamburgerMenu()">
                    <i class="fa-solid fa-bars" aria-hidden="true">&nbsp;</i>
                </div>
                <div class="hamburger-menu" id="hamburger-menu">
                    <div class="hamburger-menu-close-icon" onclick="hideHamburgerMenu()">
                        <i class="fa-solid fa-times" aria-hidden="true">&nbsp;</i>
                    </div>
                    <nav class="nav-mobile">
                        <ul>
                            <li><a href="./index.php">Főoldal</a></li>
                            <li><a href="./reservation.php">Szobáink</a></li>
                            <li><a href="./gallery.php">Galéria</a></li>
                            <?php
                            if (isset($_SESSION['id'])) {
                                echo '<li><a class="book-now-text" href="./reservation.php">FOGLALÁS</a></li>';
                                echo '<li><a class="my-account-text m-l-24" href="./profile.php">Profilom</a></li>';
                                if ($_SESSION['IsAdmin'] == 1) {
                                    echo '<li><a class="my-account-text" href="./adminpanel.php">AdminPanel</a></li>';
                                }
                                echo '<li><a class="my-account-text" href="./functions/sign_out.php">Kijelentkezés</a></li>';
                            } else {
                                echo '<li><a class="my-account-text" href="./sign_in.php">Bejelentkezés</a></li>';
                                echo '<li><a class="book-now-text" href="./sign_up.php">Regisztráció</a></li>';
                            }
                            ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <section class="up">
      <h1 class="section-title">Személyes adatok</h1>
      <div class="profile-details">
        <div class="profile-content">
            <div class="profile-img-container">
                <?php

                echo '<img src="./uploads/'.$profilepic.'" alt="Profil kép" class="profile-img">';
                ?>
            </div>
            <div class="profile-details">
            <div class="profile-details-section">
              <div class="profile-details-section-title">Vezetéknév</div>
              <?php
                echo '<div class="profile-details-section-value">'.$lastname.'</div>';
              ?>
            </div>
            <div class="profile-details-section">
              <div class="profile-details-section-title">Keresztnév</div>
              <?php
                echo '<div class="profile-details-section-value">'.$firstname.'</div>';
              ?>
            </div>
            <div class="profile-details-section">
              <div class="profile-details-section-title">Email cím:</div>
              <?php
                echo '<div class="profile-details-section-value">'.$email.'</div>';
              ?>
            </div>
          </div>
        </div>
      </div>
      <button class="update-profile-btn" onclick="showUpdateForm()">Profil Frissítése</button>
      <button onclick="deleteProfile(<?php echo $myid ?>)" class="update-profile-btn red">Profil Törlése</button>

<div id="updateForm" class="update-form-container" style="display:none;">
    <form action="./functions/update_profile.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="firstname">Keresztnév:</label>
            <input type="text" name="firstname" id="firstname" value="<?php echo $firstname; ?>">
        </div>
        <div class="form-group">
            <label for="lastname">Vezetéknév:</label>
            <input type="text" name="lastname" id="lastname" value="<?php echo $lastname; ?>">
        </div>
        <div class="form-group">
            <label for="profilepic">Profil kép:</label>
            <input type="file" name="profilepic" id="profilepic">
        </div>
        <button type="submit">Mentés</button>
        <button type="button" onclick="hideUpdateForm()">Mégsem</button>
    </form>
</div>

    </section>

    <section>
        <h1 class="section-title">Foglalások listája</h1>
        <?php
        if (empty($bookings)) {
            echo '<div class="no-bookings">Nincs foglalás</div>';
        } else {
            echo '<div class="bookings-section">';
            foreach ($bookings as $booking) {
                echo '<div class="room-container">';
                echo '<div class="room-content">';
                echo '<div class="w-48p-l">';
                echo '<div class="large-img">';
                echo '<img class="img" alt="kep" src="img/hotel-room.jpg">';
                echo '</div>';
                echo '</div>';
                echo '<div class="w-48p-r">';
                echo '<div class="room-details">';
                foreach ([
                             "Foglalás periódusa" => formatDate($booking["StartDate"]) . ' - ' . formatDate($booking["EndDate"]),
                             "Ár" => formatPrice($booking["Price"]) . ' HUF / Éjszaka',
                             "Férőhelyek száma" => $booking["Capacity"],
                         ] as $title => $value) {
                    echo '<div class="room-details-section">';
                    echo '<div class="room-details-section-title">' . $title . ':</div>';
                    echo '<div class="room-details-section-value">' . $value . '</div>';
                    echo '</div>';
                }
                $features = [
                    "Wifi" => ["icon" => "fa-solid fa-wifi", "texts" => ["Ingyenes WIFI", "Fizetős WIFI"]],
                    "Balcony" => ["icon" => "fas fa-door-open", "texts" => ["Erkélyes szoba", "Nincs erkély"]],
                    "AirConditioning" => ["icon" => "fa-solid fa-snowflake", "texts" => ["Ingyenes légkodícionáló", "Fizetős légkodícionáló"]],
                ];
                foreach ($features as $key => $feature) {
                    echo '<div class="room-details-section">';
                    echo '<div class="room-details-section-title">Egyéb</div>';
                    echo '<div class="room-details-section-value-other">';
                    echo '<div class="d-f-j-c-a-c">';
                    echo '<i class="' . $feature["icon"] . '">&nbsp;</i>';
                    echo '</div>';
                    echo $booking[$key] == 1 ? $feature["texts"][0] : $feature["texts"][1];
                    echo '</div>';
                    echo '</div>';
                }
                echo '<div class="room-details-section-btn">';
                echo '<form action="./functions/cancelreservation.php" method="POST">';
                echo '<input type="hidden" name="roomid" value="' . $booking["Id"] . '">';
                echo '<input type="submit" class="room-reserving-btn" value="Lemondás">';
                echo '</form>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        }
        ?>
    </section>


    <script>
      function showUpdateForm() {
        document.getElementById('updateForm').style.display = 'block';
    }

    function hideUpdateForm() {
        document.getElementById('updateForm').style.display = 'none';
    }
    </script>
  </body>
</html>
