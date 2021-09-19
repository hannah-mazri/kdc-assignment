<?php
  include_once 'functions.inc.php';
  if (isset($_SESSION["is_logged_in"])) {
    header("location: ../index.php");
    exit();
  }

  if (isset($_POST["submit"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) && empty($password)) {
      header("location: ../login.php?error=empty_inputs");
      exit();
    } elseif (empty($username)) {
      header("location: ../login.php?error=required_username");
      exit();
    } elseif (empty($password)) {
      header("location: ../login.php?error=required_password");
      exit();
    } else {
      login($username, $password);
    }
  }