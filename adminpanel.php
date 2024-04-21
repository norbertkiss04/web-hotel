<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adminpanel</title>
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./css/adminpanel_style.css">
    <link rel="stylesheet" href=
    "https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&amp;display=swap">
    <script src="./js/global.js"></script>
</head>
<body>
<?php
    if (isset($_GET['msg'])) {
        if ($_GET['msg'] == 'success') {
            $msg = 'Szoba sikeresen hozzáadva.';
        }
        if ($_GET['msg'] == 'roomdeleted') {
            $msg = 'Szoba sikeresen törölve.';
        }
    }
    if (isset($_GET['war'])) {
        if ($_GET['war'] == 'emptyfields') {
            $war = 'Minden mezőt ki kell tölteni!';
        }
    }
?>
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
</header>
<section>
    <h1>&nbsp;</h1>
    <?php
    if (isset($msg)) {
        echo '<div class="success-msg">' . $msg . '</div>';
    }
    if (isset($_GET['war'])) {
        if ($_GET['war'] == 'emptyfields') {
            echo '<div class="error-msg">Minden mezőt ki kell tölteni!</div>';
        }
    }
    ?>
    <div class="section-title">Szobák hozzáadása</div>
    <form class="admin-panel-form" id="addRoomForm" method="post" action="./functions/add_room.php" enctype="multipart/form-data">
        <input class="admin-panel-form-input" type="text" id="roomName" name="roomName" required placeholder="Szoba neve">
        <input class="admin-panel-form-input" type="number" id="capacity" min="0" max="5" name="capacity" required placeholder="Férőhely">
        <input class="admin-panel-form-input" type="number" id="price" name="price" required placeholder="Ár / Éjszaka">
            <label for="roompic">Kép a szobáról:</label>
            <input type="file" name="roompic" id="roompic">
        <div class="admin-panel-spec-input">
            <input type="checkbox" id="freewifi" name="freewifi" value="FreeWifi">
            <label for="freewifi">Ingyenes internet</label><br>
        </div>
        <div class="admin-panel-spec-input">
            <input type="checkbox" id="balcony" name="balcony" value="Balcony">
            <label for="balcony">Terasz</label><br>
        </div>
        <div class="admin-panel-spec-input">
            <input type="checkbox" id="airconditioning" name="airconditioning" value="AirConditioning">
            <label for="airconditioning">Légkonícionáló</label><br>
        </div>
        <button class="input-form-btn" type="submit">Add Room</button>
    </form>
</section>
<section>
    <h1>&nbsp;</h1>
    <div class="section-title">Meglévő szobák:</div>
    <div class="overflow">
        <table>
            <tr>
                <th>Szobanév</th>
                <th>Férőhelyek száma</th>
                <th>Ár / Éjszaka</th>
                <th>Internet</th>
                <th>Terasz</th>
                <th>Légkondícionáló</th>
                <th>Műveletek</th>
            </tr>
            <?php
            $sql = "SELECT * FROM rooms";
            $conn = new mysqli("localhost", "root", "", "mdnhotel");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['Name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Capacity']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Price']) . "</td>";
                    echo "<td>" . ($row['Wifi'] ? 'Igen' : 'Nincs') . "</td>";
                    echo "<td>" . ($row['Balcony'] ? 'Igen' : 'Nincs') . "</td>";
                    echo "<td>" . ($row['AirConditioning'] ? 'Igen' : 'Nincs') . "</td>";
                    echo '<td><button class="editroom" onclick="editRoom(' . $row['Id'] . ')">Módosítás</button><button onclick="deleteRoom(' . $row['Id'] . ')">Delete</button></td>';
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>Nincsenek szobák</td></tr>";
            }
            $conn->close();
            ?>
        </table>
    </div>
</section>

</body>
</html>
