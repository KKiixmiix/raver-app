<?php
require_once '../_common.php';
login();

$action = $action ?? 'insert';
$create = $action == 'insert';

$catid = $catid ?? '';

# Get a list of all categories:
$categories = sql('SELECT catid cid, name FROM item_categories ORDER BY catid');
?>
    <h2><?=action($create)?> Item:</h2>
    <form action="<?=url("items/$action.php")?>" method="post">
      <table border=1 edit>
<?php if (!$create): ?>
        <tr><th><label for="i">ID:</label></th>
            <td><input id="i" type="number" name="itemid" value="<?=$itemid??''?>" readonly required></td></tr>
<?php endif; ?>
        <tr><th><label for="n">Item Name:</label></th>
            <td><input id="n" type="text" name="item_name" value="<?=$item_name??''?>" maxlength="50" required></td></tr>
        <tr><th><label for="c">Category:</label></th>
            <td>
              <select id="c" name="catid">
                <option value="" disabled<?=selected($create)?>></option>
<?php foreach ($categories as $category): extract($category); ?>
                <option value="<?=$cid?>"<?=selected($catid==$cid)?>><?=$name?></option>
<?php endforeach; ?>
              </select>
            </td></tr>
      </table>
      <input type="submit" value="<?=submit($create)?>">
    </form>
