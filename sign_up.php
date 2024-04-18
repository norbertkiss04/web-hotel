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
    session_start();
    if (isset($_SESSION['id'])) {
      header("Location: ./index.php");
    }
    if (isset($_POST["email"])) {
        if (!isset($_POST["email"]) || trim($_POST["email"]) === "" || !isset($_POST["lastname"]) || trim($_POST["lastname"]) === "" || !isset($_POST["firstname"]) || trim($_POST["firstname"]) === "" || !isset($_POST["password"]) || trim($_POST["password"]) === "") {
            header("Location: sign_up.php?error=emptyfields");
            return;
        }
        $email = $_POST["email"];
        $lastname = $_POST["lastname"];
        $firstname = $_POST["firstname"];
        $password = $_POST["password"];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: sign_up.php?error=wrongemail");
            return;
        }
        if (strlen($password) < 8) {
            header("Location: sign_up.php?error=minpasswordlength");
            return;
        }
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
        header("Location: sign_in.php?msg=success");
    }

    $errormsg;
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "minpasswordlength") {
          $errormsg = "A jelszónak legalább 8 karakter hosszúnak kell lennie!";
        } else if ($_GET["error"] == "wrongemail") {
          $errormsg = "Hibás email cím formátum!";
        } else if ($_GET["error"] == "emptyfields") {
          $errormsg = "Minden mezőt ki kell tölteni!";
        }
    }
  ?>
  <body>
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
              placeholder="Jelszó (Min. 8 karakter)"
            />
          </div>
          <div class="input-container">
            <input class="input-form-btn" type="submit" value="Regisztráció" />
          </div>
          <?php
            if (isset($errormsg)) {
              echo "<div class='loginerrmsg'>$errormsg</div>";
            }
          ?>
          <div class="input-container">
            <p>Már regisztrált? <a href="./sign_in.php">Bejelentkezés</a></p>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
