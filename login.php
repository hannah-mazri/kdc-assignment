<?php
  function get_users()
  {
    $file = fopen('users.txt', 'r');
    $users = array();
    while (!feof($file)) {
      $content = fgets($file);
      $carray = explode("|", $content);
      list($username, $password) = $carray;
      array_push($users, $carray);
    }
    fclose($file);
    return $users;
  }

  function verify_username_password($username, $password)
  {
    $users = get_users();
    $result = false;

    foreach ($users as $user) {
      if ((trim($user[0]) == $username) && (trim($user[1]) == $password)) {
        $result = true;
        break;
      } else {
        $result = false;
      }
    }
    return $result;
  }

  function login($username, $password)
  {
    $authorized = verify_username_password($username, $password);

    if (!$authorized) {
      header("location: login.php?error=invalid_credentials");
      exit();
    } else {
      session_start();
      $_SESSION["is_logged_in"] = true;
      header("location: index.php");
    }
    exit();
  }

  if (isset($_SESSION["is_logged_in"])) {
    header("location: index.php");
    exit();
  }

  if (isset($_POST["submit"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) && empty($password)) {
      header("location: login.php?error=empty_inputs");
      exit();
    } elseif (empty($username)) {
      header("location: login.php?error=required_username");
      exit();
    } elseif (empty($password)) {
      header("location: login.php?error=required_password");
      exit();
    } else {
      login($username, $password);
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kiddocare Assignment</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="wrapper body-wrapper">
  <div class="signup-form-container">
    <h2 class="font-bold text-3xl">Log In</h2>
    <?php if (isset($_GET["error"])) { ?>
      <?php
      if (isset($_GET["error"])) {
        if ($_GET["error"] == "empty_inputs") {
          echo "<p class='error'>Fill in all fields!</p>";
        }
        if ($_GET["error"] == "required_username") {
          echo "<p class='error'>Username is required</p>";
        }
        if ($_GET["error"] == "required_password") {
          echo "<p class='error'>Password is required</p>";
        }
        if ($_GET["error"] == "invalid_credentials") {
          echo "<p class='error'>Incorrect login information!</p>";
        }
      }
      ?>
    <?php } ?>
    <div class="signup-form">
      <form method="post">
        <div class="form-control">
          <label for="username">Username</label>
          <input type="text" name="username" value="" placeholder="Email or username...">
        </div>
        <div class="form-control">
          <label for="password">Password</label>
          <input type="password" name="password" value="" placeholder="Password...">
        </div>
        <button type="submit" name="submit">Log In</button>
      </form>
    </div>


  </div>
</div>
</body>
</html>

<script src="js/script.js"></script>