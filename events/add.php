<?php
require_once '../_common.php';
login();

$action = $action ?? 'insert';
$create = $action == 'insert';

$venueid = $venueid ?? '';
$hostuserid = $hostuserid ?? $loggedIn;

# Get a list of all users:
$users = sql('SELECT userid uid, first_name fnm, last_name lnm FROM users ORDER BY userid');

# Get a list of all venues:
$venues = sql('SELECT venueid vid, name FROM venues ORDER BY venueid');
?>
    <h2><?=action($create)?> Event:</h2>
    <form action="<?=url("events/$action.php")?>" method="post">
      <table border=1 edit>
<?php if (!$create): ?>
        <tr><th><label for="i">ID:</label></th>
            <td><input id="i" type="number" name="eventid" value="<?=$eventid??0?>" readonly required></td></tr>
<?php endif; ?>
        <tr><th><label for="h">Host:</label></th>
            <td>
              <select id="h" name="hostuserid"<?=disabled($create)?>><!-- Disabled because logic to change the host requires Event ID change. -->
<?php foreach ($users as $user): extract($user); ?>
                <option value="<?=$uid?>"<?=selected($hostuserid==$uid)?>><?=fullName($lnm, $fnm)?></option>
<?php endforeach; ?>
              </select>
            </td></tr>
        <tr><th><label for="t">Theme:</label></th>
            <td><input id="t" type="text" name="theme" value="<?=$theme??''?>" required maxlength="50"></td></tr>
        <tr><th><label for="s">Start Date/Time:</label></th>
            <td><input id="s" type="datetime-local" name="datetime_start" value="<?=local($datetime_start??'')?>" required></td></tr>
        <tr><th><label for="e">End Date/Time:</label></th>
            <td><input id="e" type="datetime-local" name="datetime_end" value="<?=local($datetime_end??'')?>" required></td></tr>
        <tr><th><label for="v">Venue:</label></th>
            <td>
              <select id="v" name="venueid">
                <option value="" disabled<?=selected($create)?>></option>
<?php foreach ($venues as $venue): extract($venue); ?>
                <option value="<?=$vid?>"<?=selected($venueid==$vid)?>><?=$name?></option>
<?php endforeach; ?>
              </select>
            </td></tr>
      </table>
      <input type="submit" value="<?=submit($create)?>">
    </form>
