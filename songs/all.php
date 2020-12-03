<?php
require_once '../_common.php';
login();

### REQ-4: aggregate function
extract(head(sql('SELECT SUM(minutes) total FROM songs')));

$query = <<<SQL
SELECT musicid, title, artist, minutes, first_name fnm, last_name lnm
  FROM songs
  JOIN users USING(userid)
 ORDER BY lnm, fnm, artist
SQL;

# Songs found
$songs = sql($query);
?>
    <h2>All Users' Songs</h2>
    <table border=1>
      <tr>
        <th>User</th>
        <th>ID</th>
        <th>Title</th>
        <th>Artist</th>
        <th>Playtime</th>
      </tr>
<?php foreach ($songs as $song): extract($song); ?>
      <tr>
        <td><?=fullName($lnm, $fnm)?></td>
        <th><?=$musicid?></th>
        <td><?=$title?></td>
        <td><?=$artist?></td>
        <th><?=$minutes?></th>
      </tr>
<?php endforeach; ?>
      <tfoot>
        <tr>
          <th colspan="4" align="right">Total Playtime (in minutes)</th>
          <th><?=$total?></th>
        </tr>
      </tfoot>
    </table>
