<?php
  function get_users()
  {
    $file = fopen('../users.txt', 'r');
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
      header("location: ../login.php?error=invalid_credentials");
      exit();
    } else {
      session_start();
      $_SESSION["is_logged_in"] = true;
      header("location: ../index.php");
    }
    exit();
  }