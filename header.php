<?php
  session_start();
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
<nav>
  <div class="wrapper">
    <a href="index.php">
      <!-- <img src="img/logo-white.png" alt="Website logo"> -->
    </a>
    <ul>
      <li><a href="index.php" class="nav-link font-bold">Home</a></li>


      <?php if (isset($_SESSION["is_logged_in"])): ?>
        <li><a href="logout.php" class="nav-link">Log out</a></li>
      <?php else: ?>
        <li><a href="login.php" class="nav-link">Log in</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>


<div class="wrapper body-wrapper">