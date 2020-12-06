<?php
require_once '../_common.php';
login();

# Get required parameters, redirect to the list if no number of attendees was given:
redirect_unless(strlen($number_attendees = sanitize('number_attendees')), 'events/list.php');

### REQ-5: query with GROUP BY and HAVING
### REQ-7: query with subquery
$query = <<<SQL
SELECT e.eventid, hostuserid, eventNo, theme, datetime_start, datetime_end, IF(datetime_end<NOW(),1,0) ended,
       getNumUsers(e.eventid) attendees, v.name, u.first_name, u.last_name, a.userid
  FROM      events          e
       JOIN venues          v USING (venueid)
       JOIN users           u ON (u.userid = hostuserid)
  LEFT JOIN event_attendees a ON (a.eventid = e.eventid AND a.userid=?)
 WHERE e.eventid IN (SELECT eventid
                       FROM event_attendees
                      GROUP BY eventid
                     HAVING COUNT(*) >= ?)
 ORDER BY last_name, first_name, datetime_start DESC, eventNo DESC
SQL;

# Events found
$events = sql($query, 'ii', $loggedIn, $number_attendees);
?>
    <h2>Events with at least <?=$number_attendees?> attendee<?=1==$number_attendees?'':'s'?></h2>
<?php include_once 'list-template.php'; ?>
