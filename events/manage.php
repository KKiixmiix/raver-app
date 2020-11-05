<?php
require_once '../_common.php';
login();

/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
if (!empty($_POST['eventid'] ?? '')) {
  $eventid = sanitize('eventid');
  [$type, $eventid] = explode('-', $eventid) + [null, null];
  if (!(in_array($type, ['u', 'd']) && is_numeric($eventid))) {
    main();
    exit('<h2>Something is not right</h2>');
  }

  require_once('../DBconfig.php');

  # Perform DELETE and exit
  if ($type == 'd') {
    main();
    $query = "DELETE FROM events WHERE eventid = ?";
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt, "i", $eventid);
    if (!mysqli_stmt_execute($stmt)) {
      $echo = '<h2>We were unable to delete the event at this time.</h2>';
    } else {
      $echo = '<h2>The event was successfully deleted.</h2>';
    }
    mysqli_close($dbc);
    exit($echo);
  }

  # Prepare UPDATE
  $query = "SELECT hostuserid, eventNo, theme, datetime_start, datetime_end, venueid FROM events WHERE eventid=?";  //
  $stmt = mysqli_prepare($dbc, $query);
  mysqli_stmt_bind_param($stmt, "i", $eventid);  //
  if (!mysqli_stmt_execute($stmt)) {
    mysqli_close($dbc);
    main();
    exit('<h2>Oh no! Something went wrong!</h2>' . mysqli_error($dbc));
  }
  $result = mysqli_stmt_get_result($stmt);
  $events = mysqli_fetch_assoc($result);
  extract($events);
  mysqli_close($dbc);
}
else {
  main();
  exit('<h2>You have reached this page in error</h2>');
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
    <h2>Edit events (ID <?=$eventid?>):</h2>
    <form action="<?=$url?>/events/update.php" method="post">
      <h3>Theme:  <input type="text" name="theme" value="<?=$theme?>"></h3>
      <input type="hidden" name="eventid" value="<?=$eventid?>">
      <input type="submit" value="Update">
    </form>
  </body>
</html>
