<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Adminpanel</title>
    <link rel="stylesheet" href="./css/global.css" />
    <link rel="stylesheet" href="./css/adminpanel_style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
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
    <div class="section-title">Szobák hozzáadása</div>
    <form class="admin-panel-form" id="addRoomForm" method="post" action="./functions/add_room.php">
        <input class="admin-panel-form-input" type="text" id="roomNumber" name="roomNumber" required placeholder="Szobaszám" />
        <input class="admin-panel-form-input" type="number" id="capacity" name="capacity" required placeholder="Férőhely" />
        <input class="admin-panel-form-input" type="number" id="price" name="price" min="0" required placeholder="Ár / Éjszaka" />
        <div class="admin-panel-spec-input">
            <input type="checkbox" id="freewifi" name="freewifi" value="FreeWifi" />
            <label for="freewifi">Ingyenes internet</label><br />
        </div>
        <div class="admin-panel-spec-input">
            <input type="checkbox" id="balcony" name="balcony" value="Balcony" />
            <label for="balcony">Terasz</label><br />
        </div>
        <div class="admin-panel-spec-input">
            <input type="checkbox" id="airconditioning" name="airconditioning" value="AirConditioning" />
            <label for="airconditioning">Légkonícionáló</label><br />
        </div>
        <button class="input-form-btn" type="submit">Add Room</button>
    </form>
</section>
<section>
    <div class="section-title">Meglévő szobák:</div>
    <div class="overflow">
        <table>
            <tr>
                <th>Szobaszám</th>
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
                    echo "<td>" . htmlspecialchars($row['RoomNumber']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Capacity']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['Price']) . "</td>";
                    echo "<td>" . ($row['Wifi'] ? 'Igen' : 'Nincs') . "</td>";
                    echo "<td>" . ($row['Balcony'] ? 'Igen' : 'Nincs') . "</td>";
                    echo "<td>" . ($row['AirConditioning'] ? 'Igen' : 'Nincs') . "</td>";
                    echo '<td><button onclick="deleteRoom(' . $row['RoomNumber'] . ')">Delete</button></td>';
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
