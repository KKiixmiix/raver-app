<?php
require_once '_common.php';
home();

if (!empty($_POST['username'] ?? '')) {
  $username = sanitize('username');
  $password = sanitize('password');
  $password = md5($password); # hash the password
  require_once('DBconfig.php');
  $query = "SELECT userid FROM users WHERE email = ? AND password = ? LIMIT 1";
  $stmt = mysqli_prepare($dbc, $query);
  mysqli_stmt_bind_param($stmt, "ss", $username, $password);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  if ($result) {
    $result = mysqli_fetch_assoc($result);
    mysqli_close($dbc);
    if ($result) {
      $_SESSION['userid'] = $result['userid'];
      home(1);
    } else {
      main();
      exit('<h2>User not found!</h2>');
    }
  } else {
    mysqli_close($dbc);
    main();
    exit('<h2>Database problem</h2>');
  }
} else {
  main();
  exit('<h2>You have reached this page in error</h2>');
}
