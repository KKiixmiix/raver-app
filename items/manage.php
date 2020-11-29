<?php
require_once '../_common.php';
login();

# Get type of action and entity id:
[$type, $itemid] = getTypeAndId(sanitize('itemid'), $entity = 'item');

# Perform DELETE and exit with corresponding message:
if ($type == 'd') {
  delete($entity, 'items', 'itemid', $itemid);
}

# Prepare UPDATE
if ($type == 'u') {
  $query = 'SELECT item_name, catid FROM items WHERE itemid=?';
  extract(manage($entity, $query, 'i', $itemid));
}

# Get a list of all categories for our items:
$categories = sql('SELECT catid cid, name FROM item_categories ORDER BY catid');
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
    <h2>Edit your item (ID <?=$itemid?>):</h2>
    <form action="<?=url('items/update.php')?>" method="post">
      <table border=1 cellpadding=5 style="border-collapse: collapse; margin-bottom: 1ex;">
        <tr><th>Item:</th>
            <td><input type="text" name="item_name" value="<?=$item_name?>"></td></tr>
        <tr><th>Category:</th>
            <td>
              <select name="catid">
<?php foreach ($categories as $category): extract($category); ?>
                <option value="<?=$cid?>"<?=selected($catid==$cid)?>><?=$name?></option>
<?php endforeach; ?>
              </select>
            </td></tr>
      </table>
      <input type="hidden" name="itemid" value="<?=$itemid?>">
      <input type="submit" value="Update">
    </form>
  </body>
</html>
