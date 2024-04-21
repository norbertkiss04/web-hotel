<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content=
      "width=device-width, initial-scale=1.0">
      <title>MDN Hotel</title>
      <link rel="stylesheet" href="./css/global.css">
      <link rel="stylesheet" href="./css/homepage.css">
      <link rel="stylesheet" href=
      "https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&amp;display=swap">
      <link rel="stylesheet" href=
      "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

      <script src="./js/global.js"></script>
  </head>
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
                    echo '<a class="my-account-text" href="./functions/sign_out.php">Kijelentkezés</a>';
                } else {
                    echo '<a class="my-account-text" href="./sign_in.php">Bejelentkezés</a>';
                    echo '<a class="book-now-text" href="./sign_up.php">Regisztráció</a>';
                }
            ?>
          </div>
          <div class="hamburger-menu-icon" onclick="showHamburgerMenu()">
            <i class="fa-solid fa-bars">&nbsp;</i>
          </div>
            <div class="hamburger-menu" id="hamburger-menu">
              <div class="hamburger-menu-close-icon" onclick="hideHamburgerMenu()">
                <i class="fa-solid fa-times">&nbsp;</i>
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
      <div class="hero">
        <div class="hero-content">
          <div class="col1">
            <span class="tagline"> ÉLJEN ÁT EGY FELEJTHETETLEN ÉLMÉNYT</span>
            <div class="ta">
              <p>MERÜLJÖN EL</p>
              <p>A KÉNYELEMBEN</p>
            </div>
            <a href="./reservation.php" class="btn-view-rooms">Tekintsd meg szobáinkat</a>
          </div>
          <div class="col2"></div>
        </div>
      </div>
    </header>
    <section class="our-story">
      <div class="col1">
        <div class="text">
          <div>
            <h1>Az MDN Hotel</h1>
            <h1>Világa</h1>
          </div>
          <p>
              Az MDN Hotel modern stílusával és fejlett technológiai
              szolgáltatásaival a jelenkori utazók igényeit szolgálja ki. Elegáns,
              kényelmes szobáinkkal és testreszabott vendégszolgáltatásainkkal
              garantáljuk, hogy minden tartózkodás felejthetetlen élmény legyen.
          </p>
          <p>
            Az MDN Hotel ideális választás azok számára, akik modern
            környezetben keresik a kényelmet és minőségi pihenést, legyen szó
            üzleti vagy szabadidős utazásról. Kifinomult szállodánk az elegáns
            design és a legújabb technológiák harmonikus ötvözetével kínál
            kivételes szálláshelyet, ahol minden vendég igényeit magas
            színvonalon elégítjük ki.</p>
        </div>
      </div>
      <div class="col2">
        <img src="./img/hero2.jpg" alt="hero img" height="700">
        <div class="info">
          <div>
            <p>50</p>
            <span>HOTEL SZOBA</span>
          </div>
          <div>
            <p>15</p>
            <span>TEVÉKENYSÉG</span>
          </div>
          <div>
            <p>6</p>
            <span>ÉTTEREM</span>
          </div>
        </div>
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
            ><i class="fab fa-facebook-f">&nbsp;</i
          ></a>
          <a href="http://twitter.com/mdnhotel"
            ><i class="fab fa-twitter">&nbsp;</i
          ></a>
          <a href="http://instagram.com/mdnhotel"
            ><i class="fab fa-instagram">&nbsp;</i
          ></a>
        </div>
        <div class="awards">
          <p>Awarded Best City Hotel 2024</p>
        </div>
      </div>
    </footer>
  </body>
</html>
