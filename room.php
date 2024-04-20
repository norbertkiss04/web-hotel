<?php
include './functions/utils.php';
session_start();
$roomid = $_GET["id"];
if (isset($_SESSION['id'])) {
    $myid = $_SESSION['id'];
} else {
    $myid = 0;
}
$conn = new mysqli("localhost", "root", "", "mdnhotel");
if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}
$sql = "SELECT * FROM rooms WHERE Id='$roomid'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $roomname = $row['Name'];
    // $roomnumber = $row['RoomNumber'];
    $price = $row['Price'];
    $capacity = $row['Capacity'];
    $wifi = $row['Wifi'];
    $parking = $row['Balcony'];
    $ac = $row['AirConditioning'];
    $image = $row['Image'];
}

$sql = "SELECT users.LastName, users.FirstName, users.ProfileImg, roomrating.Rating, roomrating.Text, roomrating.Date FROM roomrating INNER JOIN users ON users.Id = roomrating.UserId WHERE roomrating.RoomId = '$roomid' ORDER BY roomrating.Date DESC;";
$result = $conn->query($sql);
$reviews = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }
}
$conn->close();

if (isset($_GET['success'])) {
    if ($_GET['success'] == "reviewadded") {
        $reviewmsg = "Sikeres hozzászólás!";
    }
    if ($_GET['success'] == "booked") {
        $msg = "Sikeres foglalás!";
    }
}
if (isset($_GET['error'])) {
    if ($_GET['error'] == "invaliddate") {
        $warmsg = "Érvénytelen dátum!";
    }
    if ($_GET['error'] == "alreadybooked") {
        $warmsg = "Már lefoglaltad ezt a szobát!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/global.css" />
    <link rel="stylesheet" href="./css/room_style.css" />
    <script src="https://kit.fontawesome.com/e8a7f12e99.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
    <title>Hotel szoba</title>
    <script src="./js/global.js"></script>
    <script>
        function closePreview() {
            document.getElementById("room-img-preview").style.display = "none";
        }

        function changePreview(src) {
            document.getElementById("room-img-preview").style.display = "flex";
            document.getElementById("room-img").src = src;
        }
    </script>
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
    <div id="room-img-preview" class="room-img-preview">
        <div class="room-img-preview-close" onclick="closePreview()">
            <i class="fa-solid fa-xmark" style="color: #ffffff"></i>
        </div>
        <div class="room-img-preview-img">
            <img id="room-img" style="width: 100%" src="img/hotel-room.jpg" />
        </div>
    </div>
    <div class="room-container">
        <?php
            if (isset($msg)) {
                echo "<div class='success-msg'>$msg</div>";
            }
            if (isset($warmsg)) {
                echo "<div class='warning-msg'>$warmsg</div>";
            }
        ?>
        <?php
        echo "<div class='section-title'>$roomname</div>"
        ?>
        <div class="room-content">
            <div class="w-48p-l">
                <div class="large-img">
                    <?php
                        echo '<img src="./uploads/'.$image.'" alt="Kép a szobáról" class="img" onclick="changePreview(this.src)" />';
                    ?>
                </div>
                <div class="small-img-container">
                    <div class="small-img">
                        <img
                                class="img"
                                src="img/hotel-room.jpg"
                                onclick="changePreview(this.src)"
                        />
                    </div>
                    <div class="small-img">
                        <img
                                class="img"
                                src="img/hotel-room.jpg"
                                onclick="changePreview(this.src)"
                        />
                    </div>
                    <div class="small-img">
                        <img
                                class="img"
                                src="img/hotel-room.jpg"
                                onclick="changePreview(this.src)"
                        />
                    </div>
                </div>
            </div>
            <div class="w-48p-r">
                <div class="room-details">
                    <!-- <div class="room-details-section">
                        <div class="room-details-section-title">Szoba száma:</div>
                        <?php
                        echo "<div class='room-details-section-value'>$roomnumber</div>"
                        ?>
                    </div> -->
                    <div class="room-details-section">
                        <div class="room-details-section-title">Ár:</div>
                        <?php
                        echo "<div class='room-details-section-value'>".formatPrice($price)." HUF / Éjszaka</div>"
                        ?>
                    </div>
                    <div class="room-details-section">
                        <div class="room-details-section-title">Férőhelyek száma:</div>
                        <?php
                        echo "<div class='room-details-section-value'>$capacity</div>"
                        ?>
                    </div>
                    <div class="room-details-section">
                        <div class="room-details-section-title">Egyéb</div>
                        <div class="room-details-section-value-other">
                            <div class="d-f-j-c-a-c">
                                <i class="fa-solid fa-wifi"></i>
                            </div>
                            <?php
                            if ($wifi == 1) {
                                echo "Ingyenes WIFI";
                            } else {
                                echo "Nincs WIFI";
                            }
                            ?>
                        </div>
                        <div class="room-details-section-value-other">
                            <div class="d-f-j-c-a-c">
                                <i class="fas fa-door-open"></i>
                            </div>
                            <?php
                            if ($parking == 1) {
                                echo "Erkélyes szoba";
                            } else {
                                echo "Nincs erkély";
                            }
                            ?>
                        </div>
                        <div class="room-details-section-value-other">
                            <div class="d-f-j-c-a-c">
                                <i class="fa-solid fa-snowflake"></i>
                            </div>
                            <?php
                            if ($ac == 1) {
                                echo "Ingyenes légkodícionáló";
                            } else {
                                echo "Nincs légkondícionáló";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="room-details-section-btn">
                        <div class="room-reserving-btn">
                            <form action="./functions/book_room.php" method="POST">
                                <input type="hidden" name="roomid" value="<?php echo $roomid;?>" />
                                <input type="hidden" name="userid" value="<?php echo $myid;?>" />
                                <label for="startdate">Érkezés dátum:</label>
                                <input type="date" id="startdate" name="startdate" value="<?php echo date('Y-m-d'); ?>" required />
                                <br >
                                <label for="enddate">Távozás dátum:</label>
                                <input type="date" id="enddate" name="enddate" value="<?php echo date('Y-m-d'); ?>" required />
                                <input class="sendreview" type="submit" value="Foglalás" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="room-container">
        <div class="section-title">
            <h1>Vélemények</h1>
        </div>
        <div class="reviews">
            <?php
            if (isset($reviewmsg)) {
                echo "<div class='success-msg'>$reviewmsg</div>";
            }
            if (count($reviews) == 0) {
                echo "<div class='no-reviews'>Még nincsenek vélemények, légy te az első!</div>";
            }
            foreach ($reviews as $review) {
                $fullname = $review["LastName"]. " ". $review["FirstName"];
                $profilepic = $review["ProfileImg"];
                $rating = $review["Rating"];
                $text = $review["Text"];
                $date = $review["Date"];
                echo "<div class='review'>";
                echo "<div class='review-user'>";
                echo "<div class='review-user-img'>";
                echo '<img class="fullimg" src="./uploads/'.$profilepic.'" alt="Profil kép" class="profile-img" />';
                echo "</div>";
                echo "<div class='review-user-name'>$fullname</div>";
                echo "</div>";
                echo "<div>";
                echo "<div class='review-rating'>";
                echo "<div class='rating'>$rating/5</div>";
                echo "</div>";
                echo "<div>";
                echo "<p class='review-text'>$text</p>";
                echo "<span class='palegray'>".formatDate($date)."</span>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            ?>
            <div class="write-review">
                <div class="section-title">
                    <h1>Vélemény írása</h1>
                </div>
                <div class="review-form">
                    <form action="./functions/add_review.php" method="POST">
                        <div class="review-form-section">
                            <label for="rating">Értékelés:</label>
                            <select name="rating" id="rating" required>
                                <option value="5">5/5</option>
                                <option value="4">4/5</option>
                                <option value="3">3/5</option>
                                <option value="2">2/5</option>
                                <option value="1">1/5</option>
                            </select>
                        </div>
                        <div class="review-form-section">
                            <label for="review">Vélemény:</label>
                            <textarea class="review-textbox" name="review" id="review" required></textarea>
                        </div>
                        <div class="review-form-section">
                            <input type="hidden" name="roomid" value="<?php echo $roomid;?>" />
                            <input type="hidden" name="userid" value="<?php echo $myid;?>" />
                            <input class="sendreview" type="submit" value="Küldés" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>