<?php
require_once '_common.php';
login();

/*This code assumes user input is valid and correct only for demo purposes - it does NOT validate form data.*/
if (!empty($_POST['musicid'] ?? '')) {
  $musicid = sanitize('musicid');
  [$type, $musicid] = explode('-', $musicid) + [null, null];
  if (!(in_array($type, ['u', 'd']) && is_numeric($musicid))) {
    main();
    exit('<h2>Something is not right</h2>');
  }

  require_once('DBconfig.php');

  # Perform DELETE and exit
  if ($type == 'd') {
    main();
    $query = "DELETE FROM songs WHERE musicid = ?";
    $stmt = mysqli_prepare($dbc, $query);
    mysqli_stmt_bind_param($stmt, "i", $musicid);
    if (!mysqli_stmt_execute($stmt)) { 
      $echo = '<h2>We were unable to delete the song at this time.</h2>';
    } else {
      $echo = '<h2>The song was successfully deleted.</h2>';
    }
    mysqli_close($dbc);
    exit($echo);
  }

  # Prepare UPDATE
  $query = "SELECT title, artist FROM songs WHERE musicid = ?";
  $stmt = mysqli_prepare($dbc, $query);
  mysqli_stmt_bind_param($stmt, "i", $musicid);
  if (!mysqli_stmt_execute($stmt)) {
    mysqli_close($dbc);
    main();
    exit('<h2>Oh no! Something went wrong!</h2>' . mysqli_error($dbc));
  }
  $result = mysqli_stmt_get_result($stmt);
  $song = mysqli_fetch_assoc($result);
  extract($song);
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
    <h2>Edit your song (ID <?=$musicid?>):</h2>
    <form action="<?=$url?>/update_music.php" method="post">
      <h3>Title:  <input type="text" name="title"  value="<?=$title?>"></h3>
      <h3>Artist: <input type="text" name="artist" value="<?=$artist?>"></h3>
      <input type="hidden" name="musicid" value="<?=$musicid?>">
      <input type="submit" value="Update">
    </form>
  </body>
</html>
