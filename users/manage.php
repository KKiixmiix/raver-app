<?php
require_once '../_common.php';
login();

# Get type of action and entity id:
[$type, $userid] = getTypeAndId(sanitize('userid'), $entity = 'user');

# Perform DELETE and exit with corresponding message:
if ($type == 'd') {
  delete($entity, 'users', 'userid', $userid);
}

# Prepare UPDATE
if ($type == 'u') {
  $query = 'SELECT invitedby, last_name, first_name, email, phone, password FROM users WHERE userid=?';
  extract(manage($entity, $query, 'i', $userid));
}

# Get a list of all users for invitors list:
$query = 'SELECT userid uid, first_name fnm, last_name lnm FROM users WHERE userid<>? ORDER BY userid';
$invitors = sql($query, 'i', $userid);
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
    <h2>Edit User profile (ID <?=$userid?>):</h2>
    <form action="<?=url('users/update.php')?>" method="post">
      <table border=1 cellpadding=5 style="border-collapse: collapse; margin-bottom: 1ex;">
        <tr><th>First Name:</th>
            <td><input type="text" name="first_name" value="<?=$first_name?>"></td></tr>
        <tr><th>Last Name:</th>
            <td><input type="text" name="last_name" value="<?=$last_name?>"></td></tr>
        <tr><th>Contact Email:</th>
            <td><input type="text" name="email" value="<?=$email?>"></td></tr>
        <tr><th>Phone Number:</th>
            <td><input type="text" name="phone" value="<?=$phone?>"></td></tr>
        <tr><th>Invited By User:</th>
            <td>
              <select name="invitedby">
                <option value="">&nbsp; &nbsp;<[nobody]></option>
<?php foreach ($invitors as $invitor): extract($invitor); ?>
                <option value="<?=$uid?>"<?=selected($invitedby==$uid)?>><?=fullName($lnm, $fnm)?></option>
<?php endforeach; ?>
              </select>
            </td></tr>
<?php if ($loggedIn == $userid): ?>
        <tr><th>Password:</th>
            <td><input type="password" name="password" value="">
                <br>Leave blank to keep current password.</td></tr>
<?php endif; ?>
      </table>
      <input type="hidden" name="userid" value="<?=$userid?>">
      <input type="submit" value="Update">
    </form>
  </body>
</html>
