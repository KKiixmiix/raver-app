<?php
require_once '../_common.php';
login();

/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
if (!empty($_POST['venueid'] ?? '')) {
  $venueid = sanitize('venueid');
  [$type, $venueid] = explode('-', $venueid) + [null, null];
  if (!(in_array($type, ['u', 'd']) && is_numeric($venueid))) {
    main();
    exit('<h2>Something is not right</h2>');
  }

  require_once('../DBconfig.php');

  # Perform DELETE and exit
  if ($type == 'd') {
    main();
    $query = "DELETE FROM venues WHERE venueid = ?";
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt, "i", $venueid);
    if (!mysqli_stmt_execute($stmt)) {
      $echo = '<h2>We were unable to delete the venue at this time.</h2>';
    } else {
      $echo = '<h2>The venue was successfully deleted.</h2>';
    }
    mysqli_close($dbc);
    exit($echo);
  }

  # Prepare UPDATE
  $query = "SELECT name, address, contact FROM venues WHERE venueid=?";
  $stmt = mysqli_prepare($dbc, $query);
  mysqli_stmt_bind_param($stmt, "i", $venueid);
  if (!mysqli_stmt_execute($stmt)) {
    mysqli_close($dbc);
    main();
    exit('<h2>Oh no! Something went wrong!</h2>' . mysqli_error($dbc));
  }
  $result = mysqli_stmt_get_result($stmt);
  $venues = mysqli_fetch_assoc($result);
  extract($venues);
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
    <h2>Edit your venue (ID <?=$venueid?>):</h2>
    <form action="<?=$url?>/venues/update.php" method="post">
      <h3>Name:  <input type="text" name="name" value="<?=$name?>"></h3>
      <h3>Address: <input type="text" name="address" value="<?=$address?>"></h3>
      <h3>Contact: <input type="text" name="contact" value="<?=$contact?>"></h3>
      <input type="hidden" name="venueid" value="<?=$venueid?>">
      <input type="submit" value="Update">
    </form>
  </body>
</html>
