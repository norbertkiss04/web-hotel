<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./css/reservation_style.css">
    <link rel="stylesheet" href=
    "https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&amp;display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="./js/global.js"></script>
</head>
<body>
    <?php
        include './functions/utils.php';
        $conn = new mysqli("localhost", "root", "", "mdnhotel");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $whereClauses = [];
        if (isset($_GET['wifi']) && $_GET['wifi'] == '1') {
            $whereClauses[] = "Wifi = 1";
        }
        if (isset($_GET['balcony']) && $_GET['balcony'] == '1') {
            $whereClauses[] = "Balcony = 1";
        }
        if (isset($_GET['ac']) && $_GET['ac'] == '1') {
            $whereClauses[] = "AirConditioning = 1";
        }
        if (!empty($_GET['people'])) {
            $whereClauses[] = "Capacity >= " . intval($_GET['people']);
        }
        if (!empty($_GET['price'])) {
            $whereClauses[] = "Price <= " . intval($_GET['price']);
        }

        $sql = "SELECT * FROM rooms";
        if (!empty($whereClauses)) {
            $sql .= " WHERE " . implode(" AND ", $whereClauses);
        }
        $result = $conn->query($sql);
        $rooms = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $rooms[] = $row;
            }
        }
        $conn->close();
    ?>

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
                    echo '<a class="my-account-text" href="./functions/sign_out.php">Kijelentkezés</a>';
                } else {
                    echo '<a class="my-account-text" href="./sign_in.php">Bejelentkezés</a>';
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
                        echo '<li><a href="./profile.php">Profilom</a></li>';
                        echo '<li><a href="./reservation.php">Foglalás</a></li>';
                        echo '<li><a href="./functions/sign_out.php">Kijelentkezés</a></li>';
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

    <header class="up">
        <div>
            <h1>Szobáink</h1>
            <form method="GET" action="reservation.php">
                <div class="filter">
                    <span class="filter-label">Filterek:</span>
                    <label class="custom-checkbox">
                        <i class="fas fa-wifi icon" aria-hidden="true">&nbsp;</i>WiFi
                        <input type="checkbox" name="wifi" value="1" <?= isset($_GET['wifi']) ? 'checked' : '' ?>>
                        <span class="checkmark">&nbsp;</span>
                    </label>
                    <label class="custom-checkbox">
                        <i class="fas fa-door-open icon" aria-hidden="true">&nbsp;</i>Terasz
                        <input type="checkbox" name="balcony" value="1" <?= isset($_GET['balcony']) ? 'checked' : '' ?>>
                        <span class="checkmark">&nbsp;</span>
                    </label>
                    <label class="custom-checkbox">
                        <i class="fas fa-snowflake icon" aria-hidden="true">&nbsp;</i>Légkondícionáló
                        <input type="checkbox" name="ac" value="1" <?= isset($_GET['ac']) ? 'checked' : '' ?>>
                        <span class="checkmark">&nbsp;</span>
                    </label>
                    <label>
                        <i class="fas fa-users icon" aria-hidden="true">&nbsp;</i>
                        <select name="people">
                            <option value="">Mindenki</option>
                            <option value="1" <?= isset($_GET['people']) && $_GET['people'] === '1' ? 'selected' : '' ?>>1 Személy</option>
                            <option value="2" <?= isset($_GET['people']) && $_GET['people'] === '2' ? 'selected' : '' ?>>2 Személy</option>
                            <option value="3" <?= isset($_GET['people']) && $_GET['people'] === '3' ? 'selected' : '' ?>>3 Személy</option>
                            <option value="4" <?= isset($_GET['people']) && $_GET['people'] === '4' ? 'selected' : '' ?>>4+ Személy</option>
                        </select>
                    </label>
                    <label>
                        <i class="fas fa-dollar-sign icon" aria-hidden="true">&nbsp;</i>Maximlis ár
                        <input type="number" class="input-field" name="price" min="0" value="<?= $_GET['price'] ?? '' ?>">
                    </label>
                    <button type="submit" class="submit-btn">Keresés</button>
                </div>
            </form>
        </div>
    </header>

    <section class="room-section">
        <div class="rooms">
            <?php foreach($rooms as $room) { ?>
                <a class="room-card" href="room.php?id=<?= $room['Id'] ?>">
                    <img src="./img/hotel-room.jpg" alt="<?= htmlspecialchars($room["Name"]) ?>" class="room-image">
                    <div class="room-info">
                        <h2 class="room-title"><?= htmlspecialchars($room["Name"]) ?></h2>
                        <div class="room-amenities">
                            <?php
                                if ($room["Wifi"]) {
                                    echo '<span><i class="fas fa-wifi" aria-hidden="true">&nbsp;</i> WiFi</span>';
                                }
                                if ($room["Balcony"]) {
                                    echo '<span><i class="fas fa-door-open" aria-hidden="true">&nbsp;</i> Terasz</span>';
                                }
                                if ($room["AirConditioning"]) {
                                    echo '<span><i class="fas fa-temperature-low" aria-hidden="true">&nbsp;</i> Légkondícionáló</span>';
                                }
                            ?>
                        </div>
                        <div class="room-capacity">
                            <span>Férőhely: <?= $room["Capacity"] ?></span>
                        </div>
                        <div class="room-price">
                            <span><?= formatPrice($room["Price"]) ?> HUF/Éjszaka</span>
                        </div>
                    </div>
                </a>
            <?php } ?>
        </div>
    </section>

    <footer>
      <div class="footer-left">
        <div class="contact-info">
          <p>123 Main Street, Hometown, Country 12345</p>
          <p>+1 (123) 456-7890 | info@mdnhotel.com</p>
        </div>
      </div>
      <div class="footer-right">
        <div class="social-media">
          <a href="http://facebook.com/mdnhotel"
            ><i class="fab fa-facebook-f" aria-hidden="true">&nbsp;</i
          ></a>
          <a href="http://twitter.com/mdnhotel"
            ><i class="fab fa-twitter" aria-hidden="true">&nbsp;</i
          ></a>
          <a href="http://instagram.com/mdnhotel"
            ><i class="fab fa-instagram" aria-hidden="true">&nbsp;</i
          ></a>
        </div>
        <div class="awards">
          <p>Awarded Best City Hotel 2024</p>
        </div>
      </div>
    </footer>
</body>
</html>