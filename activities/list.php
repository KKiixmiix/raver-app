<?php
require_once '../_common.php';
login();

# Activities found:
$activities = sql('SELECT actid, act_name FROM activities');
?>
    <h2>Activities</h2>
    <form action="<?=url('activities/manage.php')?>" method="post" id="manage-activity">
      <table border=1>
        <tr>
          <th>ID</th>
          <th>Activity</th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>
<?php foreach ($activities as $activity): extract($activity); ?>
        <tr>
          <th><?=$actid?></th>
          <td><?=$act_name?></td>
          <th><input type="radio" required name="actid" value="u-<?=$actid?>"></th>
          <th><input type="radio" required name="actid" value="d-<?=$actid?>"></th>
        </tr>
<?php endforeach; ?>
      </table>
    </form>
    <input type="submit" form="manage-activity" value="Edit / Delete"<?=disabled($activities)?>>
    <button form="add-activity">Add new activity</button>
    <form action="<?=url('activities/add.php')?>" method="post" id="add-activity"></form>
