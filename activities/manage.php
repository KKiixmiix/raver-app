<?php
require_once '../_common.php';
login();

/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
if (!empty($_POST['actid'] ?? '')) {
  $actid = sanitize('actid');
  [$type, $actid] = explode('-', $actid) + [null, null];
  if (!(in_array($type, ['u', 'd']) && is_numeric($actid))) {
    main();
    exit('<h2>Something is not right</h2>');
  }

  require_once('../DBconfig.php');

  # Perform DELETE and exit
  if ($type == 'd') {
    main();
    $query = "DELETE FROM activities WHERE actid = ?";
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt, "i", $actid);
    if (!mysqli_stmt_execute($stmt)) {
      $echo = '<h2>We were unable to delete the venue at this time.</h2>';
    } else {
      $echo = '<h2>The venue was successfully deleted.</h2>';
    }
    mysqli_close($dbc);
    exit($echo);
  }

  # Prepare UPDATE
  $query = "SELECT act_name FROM activities WHERE actid=?";
  $stmt = mysqli_prepare($dbc, $query);
  mysqli_stmt_bind_param($stmt, "i", $actid);
  if (!mysqli_stmt_execute($stmt)) {
    mysqli_close($dbc);
    main();
    exit('<h2>Oh no! Something went wrong!</h2>' . mysqli_error($dbc));
  }
  $result = mysqli_stmt_get_result($stmt);
  $venues = mysqli_fetch_assoc($result);
  extract($activities);
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
    <h2>Edit activities (ID <?=$actid?>):</h2>
    <form action="<?=$url?>/activities/update.php" method="post">
      <h3>Name:  <input type="text" name="act_name" value="<?=$act_name?>"></h3>
      <input type="hidden" name="actid" value="<?=$actid?>">
      <input type="submit" value="Update">
    </form>
  </body>
</html>
