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
    <h2>Items</h2>
    <form action="<?=url('items/manage.php')?>" method="post" id="manage-item">
      <table border=1>
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
          <th><input type="radio" required name="itemid" value="u-<?=$itemid?>"></th>
          <th><input type="radio" required name="itemid" value="d-<?=$itemid?>"></th>
        </tr>
<?php endforeach; ?>
      </table>
    </form>
    <input type="submit" form="manage-item" value="Edit / Delete"<?=disabled($items)?>>
    <button form="add-item">Add new item</button>
    <form action="<?=url('items/add.php')?>" method="post" id="add-item"></form>
