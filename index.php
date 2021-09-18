<?php
  include_once 'header.php';
  $file = './users.txt';
  $lines = file($file);

  if (!isset($_SESSION["is_logged_in"])) {
    header("location: login.php");
    exit();
  }

?><?php include_once 'footer.php' ?>