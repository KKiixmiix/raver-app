<?php
require_once '../_common.php';
login();

# Get type of action and entity id:
[$type, $venueid] = getTypeAndId(sanitize('venueid'), $entity = 'venue');

# Perform DELETE and exit with corresponding message:
if ($type == 'd') {
  delete($entity, 'venues', 'venueid', $venueid);
}

# Prepare UPDATE
if ($type == 'u') {
  $query = 'SELECT name, address, contact FROM venues WHERE venueid=?';
  extract(manage($entity, $query, 'i', $venueid));
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
    <h2>Edit your venue (ID <?=$venueid?>):</h2>
    <form action="<?=url('venues/update.php')?>" method="post">
      <table border=1 cellpadding=5 style="border-collapse: collapse; margin-bottom: 1ex;">
        <tr><th>Name:</th>
            <td><input type="text" name="name" value="<?=$name?>"></td></tr>
        <tr><th>Address:</th>
            <td><input type="text" name="address" value="<?=$address?>"></td></tr>
        <tr><th>Contact:</th>
            <td><input type="text" name="contact" value="<?=$contact?>"></td></tr>
      </table>
      <input type="hidden" name="venueid" value="<?=$venueid?>">
      <input type="submit" value="Update">
    </form>
  </body>
</html>
