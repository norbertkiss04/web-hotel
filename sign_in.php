<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/sign_in_style.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap"
      rel="stylesheet"
    />
    <title>Bejelentkezés</title>
  </head>
  <?php
    session_start();
    if (isset($_SESSION['id'])) {
      header("Location: ./index.php");
    }
    if (isset($_POST["email"])) {
        if (!isset($_POST["email"]) || trim($_POST["email"]) === "" || !isset($_POST["password"]) || trim($_POST["password"]) === "") {
          header("Location: ./sign_in.php?error=emptyfields");
          return;
        }
        $email = $_POST["email"];
        $password = $_POST["password"];
        $conn = new mysqli("localhost", "root", "", "mdnhotel");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM users WHERE Email='$email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row["Password"])) {
                session_start();
                $_SESSION['id'] = $row["Id"];
                header("Location: ./index.php");
            } else {
                header("Location: ./sign_in.php?error=wrongpassword");
            }
        } else {
            header("Location: ./sign_in.php?error=nouser");
        }
        $conn->close();
    }

    $errormsg;
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "wrongpassword") {
          $errormsg = "Hibás jelszó!";
        } else if ($_GET["error"] == "nouser") {
          $errormsg = "Nincs ilyen email cím!";
        } else if ($_GET["error"] == "emptyfields") {
          $errormsg = "Minden mezőt ki kell tölteni!";
        } else if ($_GET["error"] == "notloggedin") {
          $errormsg = "Be kell jelentkezni!";
        }
    }
    $successmsg;
    if (isset($_GET["msg"])) {
      if ($_GET["msg"] == "success") {
        $successmsg = "Sikeres regisztráció, mostmár bejelentkezhetsz";
      }
    }
  ?>
  <body>
    <div class="sing_in_content_container">
      <div class="sing_in_container">
        <?php
          if (isset($successmsg)) {
            echo "<div class='loginsuccmess'>$successmsg</div>";
          }
        ?>
        <div class="logo">
          <p class="x">MDN</p>
          <p>Hotel</p>
        </div>
        <form action="sign_in.php" method="POST">
          <h1>Bejelentkezés</h1>
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
              type="password"
              id="password"
              name="password"
              placeholder="Jelszó"
            />
          </div>
          <div class="input-container">
            <input class="input-form-btn" type="submit" value="Bejelentkezés" />
          </div>
          <?php
            if (isset($errormsg)) {
              echo "<div class='loginerrmsg'>$errormsg</div>";
            }
          ?>
          <div class="input-container">
            <p>Nincs fiókja? <a href="./sign_up.php">Regisztráljon</a></p>
          </div>
        </form>
      </div>
    </div>
  </body>
</html>
