<?php
require_once '../_common.php';
login();

/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
if (!empty($_POST['first_name'] ?? '')) { //must have at least a first_name and not = NULL
  $first_name  = sanitize('first_name');
  $last_name  = sanitize('last_name');
  $email = sanitize('email');
  $phone = sanitize('phone') ?: null;
  $password = md5(sanitize('password'));
  $invitedby = $loggedIn;
  require_once('../DBconfig.php');

  $query = "INSERT INTO users(invitedby, last_name, first_name, email, phone, password) VALUES (?,?,?,?,?,?)";
  $stmt = mysqli_prepare($dbc, $query);

  //second argument one for each ? either i(integer), d(double), b(blob), s(string or anything else)
  mysqli_stmt_bind_param($stmt, "isssss", $invitedby, $last_name, $first_name, $email, $phone, $password);

  if(!mysqli_stmt_execute($stmt)) {
    echo "<h2>Oh no! Your profile could not be added!</h2>".mysqli_error($dbc);
    mysqli_close($dbc);
    exit;
  }
  mysqli_close($dbc);
}
else {
  echo "<h2>You have reached this page in error</h2>";
  mysqli_close($dbc);
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Raver App</title>
    <meta charset="utf-8">
  </head>
  <body>
    <?php main(); ?>
    <h2>New profile for "<?=$first_name?> <?=$last_name?>" was successfully added!</h2>
  </body>
</html>
