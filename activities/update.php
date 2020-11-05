<?php
require_once '../_common.php';
login();

/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
if (!empty($_POST['actid'] ?? '')) {
  $actid = sanitize('actid');
  $act_name  = sanitize('act_name');
  require_once('../DBconfig.php');
  $message = "$actid/$act_name";

  # UPDATE
  $query = "UPDATE activities SET act_name = ? WHERE actid = ?";
  $stmt = mysqli_prepare($dbc, $query);
  mysqli_stmt_bind_param($stmt, "si", $act_name, $actid);
  if (!mysqli_stmt_execute($stmt)) {
    $message = "We were unable to update the activity at this time.";
  } else {
    $message = "The activity \"$act_name\" was successfully updated.";
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
