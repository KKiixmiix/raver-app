<?php
require_once '_common.php';
login();

/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
if (!empty($_POST['title'] ?? '')) { //must have at least a title and not = NULL
  $title  = sanitize('title');
  $artist = sanitize('artist');
  $userid = $loggedIn;
  require_once('DBconfig.php');

  $query = "INSERT INTO songs(title, artist, userid) VALUES (?,?,?)";
  $stmt = mysqli_prepare($dbc, $query);

  //second argument one for each ? either i(integer), d(double), b(blob), s(string or anything else)
  mysqli_stmt_bind_param($stmt, "ssi", $title, $artist, $userid);

  if(!mysqli_stmt_execute($stmt)) {
    echo "<h2>Oh no! Your song could not be added!</h2>".mysqli_error($dbc);
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
    <h2>Your music <?php echo "\"$title\" (by $artist)";?> was successfully added!</h2>
  </body>
</html>
