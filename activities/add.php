<?php
require_once '../_common.php';
login();

$action = $action ?? 'insert';
$create = $action == 'insert';
?>
    <h2><?=action($create)?> Activity:</h2>
    <form action="<?=url("activities/$action.php")?>" method="post">
      <table border=1 edit>
<?php if (!$create): ?>
        <tr><th><label for="i">ID:</label></th>
            <td><input id="i" type="number" name="actid" value="<?=$actid??0?>" readonly required></td></tr>
<?php endif; ?>
        <tr><th><label for="n">Activity Name:</label></th>
            <td><input id="n" type="text" name="act_name" value="<?=$act_name??''?>" maxlength="100" required></td></tr>
      </table>
      <input type="submit" value="<?=submit($create)?>">
    </form>
