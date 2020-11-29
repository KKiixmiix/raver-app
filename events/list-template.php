    <!-- BEGIN events/list-template.php (common for events/list.php and events/index.php) -->
    <form action="<?=url('events/manage.php')?>" method="post">
      <table border=1 cellpadding=5 style="border-collapse: collapse; margin-bottom: 1ex;">
        <tr>
<?php if ($showID = isset($events)): ?>
          <th>ID</th>
<?php endif; ?>
          <th>Event</th>
          <th>Host</th>
          <th>Theme</th>
          <th>Location</th>
          <th>Attendees</th>
          <th>Start Date/Time</th>
          <th>End Date/Time</th>
          <th>Edit</th>
          <th>Delete</th>
          <th>Attend</th>
        </tr>
<?php foreach ($events ?? array_filter([$event ?? null]) as $currentEvent): extract($currentEvent); ?>
        <tr>
<?php if ($showID): ?>
          <th><?=$eventid?></th>
<?php endif; ?>
          <th><?=$eventNo?></th>
          <td><?=$last_name?>, <?=$first_name?></td>
<?php if ($showID): ?>
          <td><a href="<?=url("events?id=$eventid")?>"><?=$theme?></a></td>
<?php else: ?>
          <td><?=$theme?></td>
<?php endif; ?>
          <td><?=$name?></td>
          <th><?=$attendees?></th>
          <td><?=$datetime_start?></td>
          <td><?=$datetime_end?></td>
<?php if ($ended && 1): ?>
          <th emoticon>❌️</th>
<?php else: ?>
          <th><input type="radio" name="eventid" value="u-<?=$eventid?>"></th>
<?php endif; ?>
<?php if ($loggedIn == $hostuserid): ?>
<?php if ($ended): ?>
          <th emoticon>❌️</th>
<?php else: ?>
          <th><input type="radio" name="eventid" value="d-<?=$eventid?>"></th>
<?php endif; ?>
          <th emoticon>☑</th>
<?php elseif ($loggedIn == $userid): ?>
          <th emoticon>⛔️</th><!-- &#x1F42d;&#x1F321; -->
          <th emoticon>✅</th>
<?php else: ?>
          <th emoticon>⛔️</th>
<?php if ($ended): ?>
          <th emoticon>❌️</th>
<?php else: ?>
          <th><input type="radio" name="eventid" value="a-<?=$eventid?>"></th>
<?php endif; ?>
<?php endif; ?>
        </tr>
<?php endforeach; ?>
      </table>
      <input type="submit" value="Edit / Delete / Attend"<?=disabled($events??$event)?>>
      <button formaction="<?=url('events/add.php')?>">Add new event</button>
    </form>
    <!-- END events/list-template.php -->
