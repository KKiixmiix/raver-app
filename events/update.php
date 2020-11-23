<?php
require_once '../_common.php';
login();

/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
if (!empty($_POST['eventid'] ?? '')) {
  $eventid        = sanitize('eventid');
  $theme          = sanitize('theme');
  $datetime_start = sanitize('datetime_start') ?: null;
  $datetime_end   = sanitize('datetime_end')   ?: null;
  $venueid        = sanitize('venueid');
  require_once('../DBconfig.php');
  $message = "$theme/$datetime_start/$datetime_end/$venueid";

  # UPDATE
  $query = "UPDATE events SET theme=?, datetime_start=?, datetime_end=?, venueid=? WHERE eventid = ?";
  $stmt = mysqli_prepare($dbc, $query);
  mysqli_stmt_bind_param($stmt, "sssii", $theme, $datetime_start, $datetime_end, $venueid, $eventid);
  if (!mysqli_stmt_execute($stmt)) {
    $message = "We were unable to update the event at this time.";
  } else {
    $message = "The event was successfully updated.";
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
