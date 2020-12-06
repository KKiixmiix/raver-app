<?php
require_once '../_common.php';
login();

$action = $action ?? 'insert';
$create = $action == 'insert';
?>
    <h2><?=action($create)?> Venue:</h2>
    <form action="<?=url("venues/$action.php")?>" method="post">
      <table border=1 edit>
<?php if (!$create): ?>
        <tr><th><label for="i">ID:</label></th>
            <td><input id="i" type="number" name="venueid" value="<?=$venueid??0?>" readonly required></td></tr>
<?php endif; ?>
        <tr><th><label for="n">Venue Name:</label></th>
            <td><input id="n" type="text" name="name" value="<?=$name??''?>" maxlength="100" required></td></tr>
        <tr><th><label for="a">Address:</label></th>
            <td><input id="a" type="text" name="address" value="<?=$address??''?>" maxlength="250"></td></tr>
        <tr><th><label for="c">Contact:</label></th>
            <td><input id="c" type="text" name="contact" value="<?=$contact??''?>" maxlength="100"></td></tr>
      </table>
      <input type="submit" value="<?=submit($create)?>">
    </form>
