<?php
require_once '../_common.php';
login();

# All song-related data will be per logged-in user (perhaps temporarily):
$userid = $loggedIn;

### REQ-4: aggregate function
extract(head(sql('SELECT SUM(minutes) total FROM songs WHERE userid=?', 'i', $userid)));

# Songs found
$songs = sql('SELECT musicid, title, artist, minutes FROM songs WHERE userid=?', 'i', $userid);
?>
    <h2>Your Songs</h2>
    <form action="<?=url('songs/manage.php')?>" method="post" id="manage-song">
      <table border=1>
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
          <td><?=$title?></td>
          <td><?=$artist?></td>
          <th><?=$minutes?></th>
          <th><input type="radio" required name="musicid" value="u-<?=$musicid?>"></th>
          <th><input type="radio" required name="musicid" value="d-<?=$musicid?>"></th>
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
    </form>
    <input type="submit" form="manage-song" value="Edit / Delete"<?=disabled($songs)?>>
    <button form="add-song">Add new song</button>
    <button form="all-songs">All users' songs</button>
    <form action="<?=url('songs/add.php')?>" method="post" id="add-song"></form>
    <form action="<?=url('songs/all.php')?>" method="post" id="all-songs"></form>
