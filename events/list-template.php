<?php $radios = 0; ?>
    <!-- BEGIN events/list-template.php (common for events/list.php and events/index.php) -->
    <form action="<?=url('events/manage.php')?>" method="post" id="manage-event">
      <table border=1>
        <tr>
<?php if ($showID = isset($events)): ?>
          <th>ID</th>
<?php endif; ?>
          <th>Event</th>
          <th>Host</th>
          <th>Theme</th>
          <th>Venue</th>
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
          <td><?=local($datetime_start, ' ')?></td>
          <td><?=local($datetime_end, ' ')?></td>
<?php if ($ended): ?>
          <th emoticon title="This event is in the past and cannot be edited">❌️</th>
<?php else: $radios++; ?>
          <th><input type="radio" required name="eventid" value="u-<?=$eventid?>"></th>
<?php endif; ?>
<?php if ($loggedIn == $hostuserid): /* Current user is hosting this event */ ?>
<?php   if ($ended): ?>
          <th emoticon title="This event is in the past and cannot be deleted">❌️</th>
<?php   else: $radios++; ?>
          <th><input type="radio" required name="eventid" value="d-<?=$eventid?>"></th>
<?php   endif; ?>
          <th emoticon title="You are the host of this event, so you attend it by default">☑</th>
<?php else: ?>
          <th emoticon title="You're not the host of this event, deletion forbidden">⛔️</th>
<?php   if ($loggedIn == $userid): /* Current user is attending this event */ ?>
          <th emoticon title="You signed up to attend this event">✅</th>
<?php   elseif ($ended): /* The event already ended */ ?>
          <th emoticon title="This event ended and cannot be attended anymore">❌️</th>
<?php   else: $radios++; /* User can still sign up to attend the event */ ?>
          <th><input type="radio" required name="eventid" value="a-<?=$eventid?>"></th>
<?php   endif; ?>
<?php endif; ?>
        </tr>
<?php endforeach; ?>
      </table>
    </form>
    <input type="submit" form="manage-event" value="Edit / Delete / Attend"<?=disabled($radios)?>>
    <button form="add-event">Add new event</button>
    <form action="<?=url('events/add.php')?>" method="post" id="add-event"></form>
    <!-- END events/list-template.php -->
