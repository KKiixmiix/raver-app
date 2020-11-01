<?php
require_once '_common.php';
login();

/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
if (!empty($_POST['musicid'] ?? '')) {
  $musicid = sanitize('musicid');
  $title   = sanitize('title');
  $artist  = sanitize('artist');
  require_once('DBconfig.php');
  $message = "$musicid/$title/$artist";

  # UPDATE
  $query = "UPDATE songs SET title = ?, artist = ? WHERE musicid = ?";
  $stmt = mysqli_prepare($dbc, $query);
  mysqli_stmt_bind_param($stmt, "ssi", $title, $artist, $musicid);
  if (!mysqli_stmt_execute($stmt)) { 
    $message = "We were unable to update the song at this time.";
  } else {
    $message = "The song \"$title\" (by $artist) was successfully updated.";
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
