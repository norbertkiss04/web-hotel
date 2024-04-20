<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/global.css" />
    <link rel="stylesheet" href="./css/profile_style.css" />
    <script
      src="https://kit.fontawesome.com/e8a7f12e99.js"
      crossorigin="anonymous"
    ></script>
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"
      rel="stylesheet"
    />
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

    //Get the user data from the database
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

    //Get the bookings from the database
    // $sql = "SELECT rooms.Id, rooms.Name, rooms.RoomNumber, rooms.Price, rooms.Capacity, rooms.Wifi, rooms.Parking, rooms.AirConditioning FROM rooms INNER JOIN reservations ON reservations.UserId = '$myid' AND reservations.RoomId = rooms.Id";
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
                echo '<a class="my-account-text" href="./sign_in.php">Bejelentkezés</a>';
                echo '<a class="book-now-text" href="./sign_up.php">Regisztráció</a>';
            }
        ?>
        </div>
        <div class="hamburger-menu-icon" onclick="showHamburgerMenu()">
          <i class="fa-solid fa-bars"></i>
        </div>
          <div class="hamburger-menu" id="hamburger-menu">
            <div class="hamburger-menu-close-icon" onclick="hideHamburgerMenu()">
              <i class="fa-solid fa-times"></i>
            </div>
            <nav class="nav-mobile">
              <ul>
                <li><a href="./index.php">Főoldal</a></li>
                <li><a href="./reservation.php">Szobáink</a></li>
                <li><a href="./gallery.php">Galéria</a></li>
                <?php
                    if (isset($_SESSION['id'])) {
                        echo '<a class="my-account-text" href="./profile.php">Profilom</a>';
                        echo '<a class="book-now-text" href="./reservation.php">FOGLALÁS</a>';
                        if ($_SESSION['IsAdmin'] == 1) {
                            echo '<a class="my-account-text" href="./adminpanel.php">Admin</a>';
                        }
                        echo '<a class="my-account-text m-l-24" href="./functions/sign_out.php">Kijelentkezés</a>';
                    } else {
                        echo '<li><a href="./sign_in.php">Bejelentkezés</a></li>';
                        echo '<li><a href="./sign_up.php">Regisztráció</a></li>';
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
                <!-- <img src="./img/hero.jpg" alt="Profil kép" class="profile-img" /> -->
                <?php

                echo '<img src='."$profilepic".' alt="Profil kép" class="profile-img" />';
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
      <form action="./functions/delete_profile.php" method="POST">
        <input type="hidden" name="userid" value="<?php echo $myid; ?>">
        <button class="update-profile-btn red">Profil Törlése</button>
      </form>

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
                echo '<img class="img" src="img/hotel-room.jpg" />';
                echo '</div>';
                echo '</div>';
                echo '<div class="w-48p-r">';
                echo '<div class="room-details">';
                echo '<div class="room-details-section">';
                echo '<div class="room-details-section-title">Foglalás periódusa:</div>';
                echo '<div class="room-details-section-value">'.formatDate($booking["StartDate"]). ' - ' .formatDate($booking["EndDate"]).'</div>';
                echo '</div>';
                // echo '<div class="room-details-section">';
                // echo '<div class="room-details-section-title">Szoba száma:</div>';
                // echo '<div class="room-details-section-value">'.$booking["RoomNumber"].'</div>';
                // echo '</div>';
                echo '<div class="room-details-section">';
                echo '<div class="room-details-section-title">Ár:</div>';
                echo '<div class="room-details-section-value">'.formatPrice($booking["Price"]).' HUF / Éjszaka</div>';
                echo '</div>';
                echo '<div class="room-details-section">';
                echo '<div class="room-details-section-title">Férőhelyek száma:</div>';
                echo '<div class="room-details-section-value">'.$booking["Capacity"].'</div>';
                echo '</div>';
                echo '<div class="room-details-section">';
                echo '<div class="room-details-section-title">Egyéb</div>';
                echo '<div class="room-details-section-value-other">';
                echo '<div class="d-f-j-c-a-c">';
                echo '<i class="fa-solid fa-wifi"></i>';
                echo '</div>';
                if ($booking["Wifi"] == 1) {
                    echo 'Ingyenes WIFI';
                } else {
                    echo 'Fizetős WIFI';
                }
                echo '</div>';

                echo '<div class="room-details-section-value-other">';
                echo '<div class="d-f-j-c-a-c">';
                echo '<i class="fas fa-door-open"></i>';
                echo '</div>';
                if ($booking["Balcony"] == 1) {
                    echo 'Erkélyes szoba';
                } else {
                    echo 'Nincs erkély';
                }
                echo '</div>';
                echo '<div class="room-details-section-value-other">';
                echo '<div class="d-f-j-c-a-c">';
                echo '<i class="fa-solid fa-snowflake"></i>';
                echo '</div>';
                if ($booking["AirConditioning"] == 1) {
                    echo 'Ingyenes légkodícionáló';
                } else {
                    echo 'Fizetős légkodícionáló';
                }
                echo '</div>';
                echo '</div>';
                echo '<div class="room-details-section-btn">';
                echo '<form action="./functions/cancelreservation.php" method="POST">';
                echo '<input type="hidden" name="roomid" value="'.$booking["Id"].'">';
                echo '<input type="submit" class="room-reserving-btn" value="Lemondás">';
                echo '</form>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
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
