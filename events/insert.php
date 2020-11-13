<?php
ini_set("display_errors", 1);
require_once '../_common.php';
login();

/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
if (!empty($_POST['hostuserid'] ?? '')) { //must have at least a theme and not = NULL   POST
  // $eventid = sanitize('eventid');
  $hostuserid = sanitize('hostuserid');
  // $hostuserid = $_GET['hostuserid'];
  $eventNo  = sanitize('eventNo');
  // $eventNo  = $_GET['eventNo'];
  $theme  = sanitize('theme');
  // $theme  = $_GET['theme'];
  $datetime_start  = sanitize('datetime_start');
  // $datetime_start  = $_GET['datetime_start'];
  $datetime_end  = sanitize('datetime_end');
  // $datetime_end  = $_GET['datetime_end'];
  $venueid = sanitize('venueid');
  // $venueid = $_GET['venueid'];
  $userid = $loggedIn;
  $eventid = $userid*100 + $eventNo;
  require_once('../DBconfig.php');
  $message = "$hostuserid/$eventNo/$theme/$datetime_start/$datetime_end/$venueid";  //
  // exit($message);

  $query = "INSERT INTO events(eventid, hostuserid, eventNo, theme, datetime_start, datetime_end, venueid) VALUES (?,?,?,?,?,?,?)";  //, datetime_start, datetime_end
  $stmt = mysqli_prepare($dbc, $query);

  //second argument one for each ? either i(integer), d(double), b(blob), s(string or anything else)
  mysqli_stmt_bind_param($stmt, "iiisssi", $eventid, $hostuserid, $eventNo, $theme, $datetime_start, $datetime_end, $venueid); //

  if(!mysqli_stmt_execute($stmt)) {
    echo "<h2>Oh no! Your event could not be added!</h2>".mysqli_error($dbc);
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
    <h2>Event activity "<?=$theme?>" was successfully added!</h2>
  </body>
</html>
