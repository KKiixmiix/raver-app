<?php
require_once '../_common.php';
login();

# All song-related data will be per logged-in user (perhaps temporarily):
$userid = $loggedIn;

### REQ-4: aggregate function
extract(reset(sql('SELECT SUM(minutes) total FROM songs WHERE userid=?', 'i', $userid)));

# Songs found
$songs = sql('SELECT musicid, title, artist, minutes, userid FROM songs WHERE userid=?', 'i', $userid);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Raver</title>
    <meta charset="utf-8">
  </head>
  <body>
    <?php main(); ?>
    <h2>Songs</h2>
    <form action="<?=url('songs/list_by_users.php')?>">
      <input type="submit" id="submit" value="Other User's Songs"><br><br>
    </form>
    <form action="<?=url('songs/manage.php')?>" method="post">
      <table border=1 cellpadding=5 style="border-collapse: collapse; margin-bottom: 1ex;">
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Artist</th>
          <th>Playtime</th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>
<?php foreach ($songs as $song): extract($song); ?>
        <tr>
          <th><?=$musicid?></th>
          <td><?=$title  ?></td>
          <td><?=$artist ?></td>
          <th><?=$minutes?></th>
          <th><input type="radio" name="musicid" value="u-<?=$musicid?>"></th>
          <th><input type="radio" name="musicid" value="d-<?=$musicid?>"></th>
        </tr>
<?php endforeach; ?>
        <tfoot>
          <tr>
            <th colspan="3" align="right">Total Playtime (in minutes)</th>
            <th><?=$total?></th>
            <th colspan="2"></th>
          </tr>
        </tfoot>
      </table>
      <input type="submit" value="Edit / Delete">
      <button formaction="<?=url('songs/add.php')?>">Add new song</button>
    </form>
  </body>
</html>
