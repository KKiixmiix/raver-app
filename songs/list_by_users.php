<?php
require_once '../_common.php';
login();

# All song-related data will be per logged-in user (perhaps temporarily):
$userid = $loggedIn;

### REQ-4: aggregate function
#extract(reset(sql('SELECT SUM(minutes) total FROM songs WHERE userid=?', 'i', $userid)));
#SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));
# Songs found
$songs = sql('SELECT musicid, title, artist, first_name, last_name, songs.userid
  FROM songs, users WHERE songs.userid = users.userid GROUP BY artist');
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
    <form action="<?=url('songs/manage.php')?>" method="post">
      <table border=1 cellpadding=5 style="border-collapse: collapse; margin-bottom: 1ex;">
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Artist</th>
          <th>User</th>
        </tr>
<?php foreach ($songs as $song): extract($song); ?>
        <tr>
          <th><?=$musicid?></th>
          <td><?=$title  ?></td>
          <td><?=$artist ?></td>
          <th><?=$first_name?> <?=$last_name?></th>
        </tr>
<?php endforeach; ?>
      </table>
    </form>
  </body>
</html>
