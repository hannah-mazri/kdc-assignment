<?php
  include_once 'header.php';

  function get_users()
  {
    $file = fopen('users.txt', 'r');
    $users = array();
    while (!feof($file)) {
      $content = fgets($file);
      $carray = explode(" | ", $content);
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
      $result = ($user[0] == $username && $user[1] == $password);
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

    if (empty($username)) {
      header("location: login.php?error=Username is required");
      exit();
    } elseif (empty($password)) {
      header("location: login.php?error=Password is required");
      exit();
    } else {
      login($username, $password);
    }
  }
?>
  <div class="signup-form-container">
    <h2 class="font-bold text-3xl">Log In</h2>
    <?php if (isset($_GET["error"])) { ?>
      <p class="error"><?php echo $_GET["error"]; ?></p>
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

    <?php
      if (isset($_GET["error"])) {
        if ($_GET["error"] == "empty_input") {
          echo "<p>Fill in all fields!</p>";
        }
        if ($_GET["error"] == "invalid_credentials") {
          echo "<p>Incorrect login information!</p>";
        }
      }
    ?>
  </div>


<?php include_once 'footer.php' ?>