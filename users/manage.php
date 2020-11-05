<?php
require_once '../_common.php';
login();

/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
if (!empty($_POST['userid'] ?? '')) {
  $userid = sanitize('userid');
  [$type, $userid] = explode('-', $userid) + [null, null];
  if (!(in_array($type, ['u', 'd']) && is_numeric($userid))) {
    main();
    exit('<h2>Something is not right</h2>');
  }

  require_once('../DBconfig.php');

  # Perform DELETE and exit
  if ($type == 'd') {
    main();
    $query = "DELETE FROM users WHERE userid = ?";
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt, "i", $userid);
    if (!mysqli_stmt_execute($stmt)) {
      $echo = '<h2>We were unable to delete the user at this time.</h2>';
    } else {
      $echo = '<h2>The user was successfully deleted.</h2>';
    }
    mysqli_close($dbc);
    exit($echo);
  }

  # Prepare UPDATE
  $query = "SELECT last_name, first_name, email, phone, password FROM users WHERE userid=?";
  $stmt = mysqli_prepare($dbc, $query);
  mysqli_stmt_bind_param($stmt, "i", $userid);
  if (!mysqli_stmt_execute($stmt)) {
    mysqli_close($dbc);
    main();
    exit('<h2>Oh no! Something went wrong!</h2>' . mysqli_error($dbc));
  }
  $result = mysqli_stmt_get_result($stmt);
  $users = mysqli_fetch_assoc($result);
  extract($users);
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
    <h2>Edit your profile (ID <?=$userid?>):</h2>
    <form action="<?=$url?>/users/update.php" method="post">
      <h3>Raver patron:  <input type="text" name="first_name" value="<?=$first_name?>"></h3>
      <h3>Last name:  <input type="text" name="last_name" value="<?=$last_name?>"></h3>
      <h3>Contact email: <input type="text" name="email" value="<?=$email?>"></h3>
      <h3>Contact number: <input type="text" name="phone" value="<?=$phone?>"></h3>
      <h3>Password: <input type="text" name="password" value="<?=$password?>"></h3>
      <input type="hidden" name="userid" value="<?=$userid?>">
      <input type="submit" value="Update">
    </form>
  </body>
</html>
