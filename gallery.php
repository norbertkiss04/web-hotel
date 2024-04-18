<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galéria</title>
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./css/gallery_style.css">
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"
      rel="stylesheet"
    />
    <script
    src="https://kit.fontawesome.com/e8a7f12e99.js"
    crossorigin="anonymous"
  ></script>
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
    </header>
    <section>
        <div class="gallery-container">
            <div class="gallery">
                <img class="img" id="main-img" src="./img/hotel-room.jpg" alt="Main Image">
            </div>
            <div class="gallery-small">
                <div class="gallery-small-img">
                    <img class="img" src="./img/hotel-room.jpg" alt="Image" onclick="changeImg(this.src)">
                </div>
                <div class="gallery-small-img">
                    <img class="img" src="./img/hotel-room.jpg" alt="Image" onclick="changeImg(this.src)">
                </div>
                <div class="gallery-small-img">
                    <img class="img" src="./img/hero.jpg" alt="Image" onclick="changeImg(this.src)">
                </div>
                <div class="gallery-small-img">
                    <img class="img" src="./img/hero.jpg" alt="Image" onclick="changeImg(this.src)">
                </div>
                <div class="gallery-small-img">
                    <img class="img" src="./img/hero2.jpg" alt="Image" onclick="changeImg(this.src)">
                </div>
                <div class="gallery-small-img">
                    <img class="img" src="./img/hero2.jpg" alt="Image" onclick="changeImg(this.src)">
                </div>
                <div class="gallery-small-img">
                    <img class="img" src="./img/hero2.jpg" alt="Image" onclick="changeImg(this.src)">
                </div>
                <div class="gallery-small-img">
                    <img class="img" src="./img/hotel-room.jpg" alt="Image" onclick="changeImg(this.src)">
                </div>
                <div class="gallery-small-img">
                    <img class="img" src="./img/hotel-room.jpg" alt="Image" onclick="changeImg(this.src)">
                </div>
                <div class="gallery-small-img">
                    <img class="img" src="./img/hotel-room.jpg" alt="Image" onclick="changeImg(this.src)">
                </div>
                <div class="gallery-small-img">
                    <img class="img" src="./img/hotel-room.jpg" alt="Image" onclick="changeImg(this.src)">
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