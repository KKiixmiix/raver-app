<?php
require_once '../_common.php';
login();

/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
if (!empty($_POST['userid'] ?? '')) {
  $userid = sanitize('userid');
  $last_name  = sanitize('last_name');
  $first_name  = sanitize('first_name');
  $email  = sanitize('email');
  $phone = sanitize('phone');
  $password = sanitize('password');
  require_once('../DBconfig.php');
  $message = "$userid/$last_name/$first_name/$email/$phone/$password";

  # UPDATE
  $query = "UPDATE items SET last_name=?, first_name=?, email=?, phone=?, password=? FROM users WHERE userid=?";
  $stmt = mysqli_prepare($dbc, $query);
  mysqli_stmt_bind_param($stmt, "sssisi", $last_name, $first_name, $email, $phone, $password, $userid);
  if (!mysqli_stmt_execute($stmt)) {
    $message = "We were unable to update the profile at this time.";
  } else {
    $message = "The profile for\"$first_name $last_name\" was successfully updated.";
  }
  $message .= mysqli_error($dbc);
} else {
  $message = "You have reached this page in error";
}
mysqli_close($dbc);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Raver App</title>
    <meta charset="utf-8">
  </head>
  <body>
    <?php main(); ?>
    <h2><?=$message?></h2>
  </body>
</html>
