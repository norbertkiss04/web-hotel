<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/sign_in_style.css" />
    <title>Regisztáció</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"
      rel="stylesheet"
    />
  </head>
  <?php
    if (isset($_POST["email"])) {
        if (!isset($_POST["email"]) || trim($_POST["email"]) === "" || !isset($_POST["lastname"]) || trim($_POST["lastname"]) === "" || !isset($_POST["firstname"]) || trim($_POST["firstname"]) === "" || !isset($_POST["password"]) || trim($_POST["password"]) === "") {
            header("Location: sign_up.php?error=emptyfields");
            echo "Minden mező kitöltése kötelező!";
            return;
        }
        $email = $_POST["email"];
        $lastname = $_POST["lastname"];
        $firstname = $_POST["firstname"];
        $password = $_POST["password"];
        $hashedpassword = password_hash($password, PASSWORD_DEFAULT);
        $RegDate = date("Y-m-d");
        $conn = new mysqli("localhost", "root", "", "mdnhotel");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "INSERT INTO users (Email, LastNAME, FirstName, Password, RegDate) VALUES ('$email', '$lastname', '$firstname', '$hashedpassword', '$RegDate')";
        if ($conn->query($sql) === FALSE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
            return;
        }
        $conn->close();
        echo "Sikeres regisztráció!";
        header("Location: sign_in.php");
    }
  ?>
  <body>
  <?php
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "emptyfields") {
                echo '<p class="error">Minden mező kitöltése kötelező!</p>';
            }
        }
    ?>
    <div class="sing_in_content_container">
      <div class="sing_in_container">
        <div class="logo">
          <p class="x">MDN</p>
          <p>Hotel</p>
        </div>
        <form action="sign_up.php" method="POST">
          <h1>Regisztráció</h1>
          <div class="input-container">
            <input
              type="email"
              id="email"
              name="email"
              placeholder="Email cím"
            />
          </div>
          <div class="input-container">
            <input
              type="text"
              id="lastname"
              name="lastname"
              placeholder="Név"
            />
          </div>
          <div class="input-container">
            <input
              type="text"
              id="firstname"
              name="firstname"
              placeholder="Vezetéknév"
            />
          </div>
          <div class="input-container">
            <input
              type="password"
              id="password"
              name="password"
              placeholder="Jelszó"
            />
          </div>
          <div class="input-container">
            <input class="input-form-btn" type="submit" value="Regisztráció" />
          </div>
          <div class="input-container">
            <p>Már regisztrált? <a href="./sign_in.html">Bejelentkezés</a></p>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
