<?php
require_once '../_common.php';
login();

/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
if (!empty($_POST['venueid'] ?? '')) {
  $venueid = sanitize('venueid');
  $name  = sanitize('name');
  $address = sanitize('address');
  $contact = sanitize('contact');
  require_once('../DBconfig.php');
  $message = "$venueid/$name/$address/$contact";

  # UPDATE
  $query = "UPDATE venues SET name = ?, address = ?, contact = ? WHERE venueid = ?";
  $stmt = mysqli_prepare($dbc, $query);
  mysqli_stmt_bind_param($stmt, "sssi", $name, $address, $contact, $venueid);
  if (!mysqli_stmt_execute($stmt)) {
    $message = "We were unable to update the venue at this time.";
  } else {
    $message = "The venue location \"$name\" was successfully updated.";
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
