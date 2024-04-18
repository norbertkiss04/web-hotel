<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link rel="stylesheet" href="./css/global.css" />
    <link rel="stylesheet" href="./css/reservation_style.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
    <script src="./js/global.js"></script>
    <script>
      function navigate(url) {
        window.location.href = url;
      }
    </script>
  </head>
  <?php
    include './functions/utils.php';
    // Get the rooms from the database
    $conn = new mysqli("localhost", "root", "", "mdnhotel");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $sql = "SELECT * FROM rooms";
    $result = $conn->query($sql);
    $rooms = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rooms[] = $row;
        }
    }
    $conn->close();

  ?>
  <body>
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
                session_start();
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
                    session_start();
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
        <div class="filter">
          <span class="filter-label">Filterek:</span>
          <label class="custom-checkbox"
            ><i class="fas fa-wifi icon"></i>WiFi<input
              type="checkbox"
              name="wifi" /><span class="checkmark"></span
          ></label>
          <label class="custom-checkbox"
            ><i class="fas fa-door-open icon"></i>Terasz<input
              type="checkbox"
              name="balcony" /><span class="checkmark"></span
          ></label>
          <label class="custom-checkbox"
            ><i class="fas fa-snowflake icon"></i>Légkondícionáló<input
              type="checkbox"
              name="ac" /><span class="checkmark"></span
          ></label>
          <label
            ><i class="fas fa-users icon"></i
            ><select name="people">
              <option value="1">1 Személy</option>
              <option value="2">2 Személy</option>
              <option value="3">3 Személy</option>
              <option value="4">4+ Személy</option>
            </select></label
          >
          <label
            ><i class="fas fa-dollar-sign icon"></i>Maximlis ár<input
              type="number"
              class="input-field"
              name="price"
              min="0"
          /></label>
        </div>
      </div>
    </header>
    <section class="room-section">
      <div class="rooms">
        <?php
            foreach($rooms as $room) {
                echo '<a class="room-card" href="room.php?id='.$room['Id'].'">';
                echo '<img src="./img/hotel-room.jpg" alt="Room 101" class="room-image" />';
                echo '<div class="room-info">';
                echo '<h2 class="room-title">'.$room["Name"].'</h2>';
                echo '<div class="room-amenities">';
                if ($room["Wifi"]) {
                    echo '<span><i class="fas fa-wifi"></i> WiFi</span>';
                }
                if ($room["Balcony"]) {
                    echo '<span><i class="fas fa-door-open"></i> Terasz</span>';
                }
                if ($room["AirConditioning"]) {
                    echo '<span><i class="fas fa-temperature-low"></i> Légkondícionáló</span>';
                }
                echo '</div>';
                echo '<div class="room-capacity">';
                echo '<span>Férőhely: '.$room["Capacity"].'</span>';
                echo '</div>';
                echo '<div class="room-price">';
                echo '<span>'.formatPrice($room["Price"]).' HUF/Éjszaka</span>';
                echo '</div>';
                echo '</div>';
                echo '</a>';
            }
        ?>
        <!-- <div class="room-card" onclick="navigate('./room.php')">
          <img src="./img/hotel-room.jpg" alt="Room 101" class="room-image" />
          <div class="room-info">
            <h2 class="room-title">Room 101</h2>
            <div class="room-amenities">
              <span><i class="fas fa-wifi"></i> WiFi</span>
              <span><i class="fas fa-door-open"></i> Terasz</span>
            </div>
            <div class="room-capacity">
              <span>Férőhely: 2 </span>
            </div>
            <div class="room-price">
              <span>42.000 HUF/Éjszaka</span>
            </div>
          </div>
        </div>
        <div class="room-card" onclick="navigate('./room.php')">
          <img src="./img/hotel-room.jpg" alt="Room 102" class="room-image" />
          <div class="room-info">
            <h2 class="room-title">Room 102</h2>
            <div class="room-amenities">
              <span><i class="fas fa-sun"></i> Terasz </span>
              <span
                ><i class="fas fa-temperature-low"></i> Légkondícionáló</span
              >
            </div>
            <div class="room-capacity">
              <span>Férőhely: 3 </span>
            </div>
            <div class="room-price">
              <span>65.000 HUF/Éjszaka</span>
            </div>
          </div>
        </div>

        <div class="room-card" onclick="navigate('./room.php')">
          <img src="./img/hotel-room.jpg" alt="Room 102" class="room-image" />
          <div class="room-info">
            <h2 class="room-title">Room 103</h2>
            <div class="room-amenities">
              <span><i class="fas fa-sun"></i> Terasz </span>
              <span
                ><i class="fas fa-temperature-low"></i> Légkondícionáló</span
              >
            </div>
            <div class="room-capacity">
              <span>Férőhely: 3 </span>
            </div>
            <div class="room-price">
              <span>65.000 HUF/Éjszaka</span>
            </div>
          </div>
        </div>
        <div class="room-card" onclick="navigate('./room.php')">
          <img src="./img/hotel-room.jpg" alt="Room 102" class="room-image" />
          <div class="room-info">
            <h2 class="room-title">Room 104</h2>
            <div class="room-amenities">
              <span><i class="fas fa-wifi"></i> WiFi</span>
              <span><i class="fas fa-sun"></i> Terasz </span>
              <span
                ><i class="fas fa-temperature-low"></i> Légkondícionáló</span
              >
            </div>
            <div class="room-capacity">
              <span>Férőhely: 3 </span>
            </div>
            <div class="room-price">
              <span>65.000 HUF/Éjszaka</span>
            </div>
          </div>
        </div>
        <div class="room-card" onclick="navigate('./room.php')">
          <img src="./img/hotel-room.jpg" alt="Room 102" class="room-image" />
          <div class="room-info">
            <h2 class="room-title">Room 105</h2>
            <div class="room-amenities">
              <span><i class="fas fa-wifi"></i> WiFi</span>
              <span
                ><i class="fas fa-temperature-low"></i> Légkondícionáló</span
              >
            </div>
            <div class="room-capacity">
              <span>Férőhely: 3</span>
            </div>
            <div class="room-price">
              <span>65.000 HUF/Éjszaka</span>
            </div>
          </div>
        </div>
        <div class="room-card" onclick="navigate('./room.php')">
          <img src="./img/hotel-room.jpg" alt="Room 102" class="room-image" />
          <div class="room-info">
            <h2 class="room-title">Room 106</h2>
            <div class="room-amenities">
              <span><i class="fas fa-wifi"></i> WiFi</span>
              <span
                ><i class="fas fa-temperature-low"></i> Légkondícionáló</span
              >
            </div>
            <div class="room-capacity">
              <span>Férőhely: 3 </span>
            </div>
            <div class="room-price">
              <span>65.000 HUF/Éjszaka</span>
            </div>
          </div>
        </div>
        <div class="room-card" onclick="navigate('./room.php')">
          <img src="./img/hotel-room.jpg" alt="Room 102" class="room-image" />
          <div class="room-info">
            <h2 class="room-title">Room 107</h2>
            <div class="room-amenities">
              <span><i class="fas fa-wifi"></i> WiFi</span>
              <span
                ><i class="fas fa-temperature-low"></i> Légkondícionáló</span
              >
            </div>
            <div class="room-capacity">
              <span>Férőhely: 3 </span>
            </div>
            <div class="room-price">
              <span>65.000 HUF/Éjszaka</span>
            </div>
          </div>
        </div>
      </div> -->
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
            ><i class="fab fa-facebook-f"></i
          ></a>
          <a href="http://twitter.com/mdnhotel"
            ><i class="fab fa-twitter"></i
          ></a>
          <a href="http://instagram.com/mdnhotel"
            ><i class="fab fa-instagram"></i
          ></a>
        </div>
        <div class="awards">
          <p>Awarded Best City Hotel 2024</p>
        </div>
      </div>
    </footer>
  </body>
</html>
