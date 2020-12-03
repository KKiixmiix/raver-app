<?php
require_once '../_common.php';
login();

### REQ-3: self-join
$query = <<<SQL
SELECT u.userid, u.last_name, u.first_name, u.email, u.phone,
       r.first_name invitor_first, r.last_name invitor_last
  FROM      users u
  LEFT JOIN users r ON (r.userid = u.invitedby)
SQL;

# Users found
$users = sql($query);
?>
    <h2>Users</h2>
    <form action="<?=url('users/manage.php')?>" method="post">
      <table border=1>
        <tr>
          <th>ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Contact Email</th>
          <th>Contact Number</th>
          <th>Invited By User</th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>
<?php foreach ($users as $user): extract($user); ?>
        <tr>
          <th><?=$userid?></th>
          <td><?=$first_name?></td>
          <td><?=$last_name?></td>
          <td><?=$email?></td>
          <td><?=$phone?></td>
          <td><?=fullName($invitor_last, $invitor_first)?></td>
          <th><input type="radio" required name="userid" value="u-<?=$userid?>"></th>
          <th><input type="radio" required name="userid" value="d-<?=$userid?>"></th>
        </tr>
<?php endforeach; ?>
      </table>
      <input type="submit" value="Edit / Delete"<?=disabled($users)?>>
      <button formaction="<?=url('users/add.php')?>">Invite new user</button>
    </form>
