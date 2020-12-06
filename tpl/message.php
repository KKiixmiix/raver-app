<?php
global $debug;
?>
<?php if (isset($h1)): ?>
  <h1<?=$hxAttr??''?>><?=$h1?></h1>
<?php elseif (isset($h2)): ?>
  <h2<?=$hxAttr??''?>><?=$h2?></h2>
<?php elseif (isset($h3)): ?>
  <h3<?=$hxAttr??''?>><?=$h3?></h3>
<?php endif; ?>
<?php if (isset($ol) && is_array($ol) && $ol): ?>
  <ol<?=$hxAttr??''?>>
<?php foreach ($ol as $value): ?>
    <li><?=$value?></li>
<?php endforeach; ?>
  </ol>
<?php endif; ?>
<?php if (isset($ul) && is_array($ul) && $ul): ?>
  <ul<?=$hxAttr??''?>>
<?php foreach ($ul as $key => $value): ?>
    <li><?=is_string($key)?"<b>$key</b>: ":''?><?=$value?></li>
<?php endforeach; ?>
  </ul>
<?php endif; ?>
<?php if (isset($sql) && $sql && $debug): ?>
  <h3><?=$sql?></h3>
<?php endif; ?>
