<?php
require_once '../_common.php';
login();

### REQ-1: two-table join
$query = <<<SQL
SELECT itemid, item_name, name cat_name
  FROM items
  JOIN item_categories USING(catid)
SQL;

# Items found:
$items = sql($query);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Raver</title>
    <meta charset="utf-8">
  </head>
  <body>
    <?php main(); ?>
    <h2>Items</h2>
    <form action="<?=url('items/manage.php')?>" method="post">
      <table border=1 cellpadding=5 style="border-collapse: collapse; margin-bottom: 1ex;">
        <tr>
          <th>ID</th>
          <th>Item</th>
          <th>Category</th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>
<?php foreach ($items as $item): extract($item); ?>
        <tr>
          <th><?=$itemid?></th>
          <td><?=$item_name?></td>
          <td><?=$cat_name?></td>
          <th><input type="radio" name="itemid" value="u-<?=$itemid?>"></th>
          <th><input type="radio" name="itemid" value="d-<?=$itemid?>"></th>
        </tr>
<?php endforeach; ?>
      </table>
      <input type="submit" value="Edit / Delete">
      <button formaction="<?=url('items/add.php')?>">Add new item</button>
    </form>
  </body>
</html>
