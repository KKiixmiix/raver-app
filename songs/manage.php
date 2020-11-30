<?php
require_once '../_common.php';
login();

# Get type of action and entity id:
[$type, $musicid] = getTypeAndId(sanitize('musicid'), $entity = 'song');

# Perform DELETE and exit with corresponding message:
if ($type == 'd') {
  delete($entity, 'songs', 'musicid', $musicid);
}

# Prepare UPDATE
if ($type == 'u') {
  $query = 'SELECT title, artist, minutes, userid FROM songs WHERE musicid=?';
  extract(manage($entity, $query, 'i', $musicid));
}

# Get a list of all users:
$users = sql('SELECT userid uid, first_name fnm, last_name lnm FROM users ORDER BY userid');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Raver App</title>
    <meta charset="utf-8">
    <style>
      table th{text-align:right;vertical-align:top}
      table td{min-width:20em}
      table td select{width:100%}
      table td input{width:calc(100% - 8px)}
    </style>
  </head>
  <body>
    <?php main(); ?>
    <h2>Edit your song (ID <?=$musicid?>):</h2>
    <form action="<?=url('songs/update.php')?>" method="post">
      <table border=1 cellpadding=5 style="border-collapse: collapse; margin-bottom: 1ex;">
        <tr><th>Title:</th>
            <td><input type="text" name="title"  value="<?=$title?>"></td></tr>
        <tr><th>Artist:</th>
            <td><input type="text" name="artist" value="<?=$artist?>"></td></tr>
        <tr><th>Playtime:</th>
            <td><input type="text" name="minutes" value="<?=$minutes?>"></td></tr>
        <!-- <tr><th>Added By:</th>
            <td>
              <select name="userid">
<?php foreach ($users as $user): extract($user); ?>
                <option value="<?=$uid?>"<?=selected($userid==$uid)?>><?=fullName($lnm, $fnm)?></option>
<?php endforeach; ?>
              </select>
            </td></tr> -->
      </table>
      <input type="hidden" name="musicid" value="<?=$musicid?>">
      <input type="submit" value="Update">
    </form>
  </body>
</html>
