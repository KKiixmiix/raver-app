<?php
require_once '../_common.php';
login();

$action = $action ?? 'insert';
$create = $action == 'insert';

$userid = $userid ?? $loggedIn;

# Get a list of all users:
$users = sql('SELECT userid uid, first_name fnm, last_name lnm FROM users ORDER BY userid');
?>
    <h2><?=action($create)?> Song:</h2>
    <form action="<?=url("songs/$action.php")?>" method="post">
      <table border=1 edit>
<?php if (!$create): ?>
        <tr><th><label for="i">ID:</label></th>
            <td><input id="i" type="number" name="musicid" value="<?=$musicid??0?>" readonly required></td></tr>
<?php endif; ?>
        <tr><th><label for="t">Title:</label></th>
            <td><input id="t" type="text" name="title" value="<?=$title??''?>" maxlength="50" required></td></tr>
        <tr><th><label for="a">Artist:</label></th>
            <td><input id="a" type="text" name="artist" value="<?=$artist??''?>" maxlength="50" required></td></tr>
        <tr><th><label for="m">Playtime:</label></th>
            <td><input id="m" type="number" name="minutes" value="<?=$minutes??1?>" min="1" max="300" required></td></tr>
        <tr><th><label for="u">Added By:</label></th>
            <td>
              <select id="u" name="userid">
<?php foreach ($users as $user): extract($user); ?>
                <option value="<?=$uid?>"<?=selected($userid==$uid)?>><?=fullName($lnm, $fnm)?></option>
<?php endforeach; ?>
              </select>
            </td></tr>
      </table>
      <input type="submit" value="<?=submit($create)?>">
    </form>
