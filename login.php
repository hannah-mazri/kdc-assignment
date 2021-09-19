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
      <form action="includes/login.inc.php" method="post">
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