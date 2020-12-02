<?php
require_once '../_common.php';
login($loggedIn);

$action = $action ?? 'insert';
$create = in_array($action, ['insert', 'insert_newuser']);

$signUp = $action == 'insert_newuser';

$userid = $userid ?? 0;
$invitedby = $invitedby ?? $loggedIn;

# Get a list of all users for invitors list:
$query = 'SELECT userid uid, first_name fnm, last_name lnm FROM users WHERE userid<>? ORDER BY userid';
$invitors = sql($query, 'i', $userid);
?>
    <h2><?=action($create, $signUp)?> User:</h2>
    <form action="<?=url("users/$action.php")?>" method="post">
      <table border=1 edit>
<?php if (!$create): ?>
        <tr><th><label for="i">ID:</label></th>
            <td><input id="i" type="number" name="userid" value="<?=$userid??0?>" readonly required></td></tr>
<?php endif; ?>
        <tr><th><label for="f">First Name:</label></th>
            <td><input id="f" type="text" name="first_name" value="<?=$first_name??''?>" required maxlength="50" autocomplete="given-name"></td></tr>
        <tr><th><label for="l">Last Name:</label></th>
            <td><input id="l" type="text" name="last_name" value="<?=$last_name??''?>" required maxlength="50" autocomplete="family-name"></td></tr>
        <tr><th><label for="e">Contact Email:</label></th>
            <td><input id="e" type="email" name="email" value="<?=$email??''?>" required maxlength="50" autocomplete="username"></td></tr>
        <tr><th><label for="p">Phone Number:</label></th>
            <td><input id="p" type="tel" name="phone" value="<?=$phone??''?>" maxlength="50" autocomplete="tel"></td></tr>
<?php if (!$signUp): ?>
        <tr><th><label for="v">Invited By User:</label></th>
            <td>
              <select id="v" name="invitedby">
                <option value="">&nbsp; &nbsp;<[nobody]></option>
<?php foreach ($invitors as $invitor): extract($invitor); ?>
                <option value="<?=$uid?>"<?=selected($invitedby==$uid)?>><?=fullName($lnm, $fnm)?></option>
<?php endforeach; ?>
              </select>
            </td></tr>
<?php endif; ?>
<?php if ($create || ($loggedIn == $userid)): ?>
        <tr><th><label for="w">Password:</label></th>
            <td><input id="w" type="password" name="password"<?=required($create)?> minlength="8" autocomplete="<?=$create?'new':'current'?>-password">
<?php if (!$create): ?>
                <br>Leave blank to keep current password.
<?php endif; ?>
            </td></tr>
<?php endif; ?>
      </table>
      <input type="submit" value="<?=submit($create, $signUp)?>">
    </form>
