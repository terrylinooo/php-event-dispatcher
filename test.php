<?php

include_once('class.event.php');

addListener('event_send_message', 'send_message');

function send_message() {
    echo '<p>A message has been sent!!</p>';
    echo '<p>Current Running Event is called: <strong>' . nowListener('event_name') . '</strong></p>';
}

doDispatch('event_send_message');

$event_name = 'event_send_message';

if ( hasListener($event_name) ) {
    echo '<p>Listener <strong>' . $event_name . '</strong> is existed.<p>';
}
else {
  echo '<p>Listener <strong>' . $event_name . '</strong> is not existed.<p>';
}

?>
