<?php
require_once '../_common.php';
login();

# Get type of action and entity id:
[$type, $actid] = getTypeAndId(sanitize('actid'), $entity = 'activity');

# Perform DELETE and exit with corresponding message:
if ($type == 'd') {
  delete($entity, 'activities', 'actid', $actid);
}

# Prepare UPDATE
if ($type == 'u') {
  $query = 'SELECT act_name FROM activities WHERE actid=?';
  extract(manage($entity, $query, 'i', $actid));
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Raver App</title>
    <meta charset="utf-8">
    <style>
      table th{text-align:right;vertical-align:top}
      table td{min-width:20em}
      table td input{width:calc(100% - 8px)}
    </style>
  </head>
  <body>
    <?php main(); ?>
    <h2>Edit Activity (ID <?=$actid?>):</h2>
    <form action="<?=url('activities/update.php')?>" method="post">
      <table border=1 cellpadding=5 style="border-collapse: collapse; margin-bottom: 1ex;">
        <tr><th>Activity Name:</th>
            <td><input type="text" name="act_name" value="<?=$act_name?>"></td></tr>
      </table>
      <input type="hidden" name="actid" value="<?=$actid?>">
      <input type="submit" value="Update">
    </form>
  </body>
</html>
