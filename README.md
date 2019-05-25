# PHP Event Dispatcher

PHP Event Dispatcher is the most easy-to-use and simple Event Dispatcher PHP Class (Singleton Pattern).

The original idea is from **Symfony's event listener system.** 
http://symfony.com/doc/current/components/event_dispatcher/index.html

But I think it is a bit complex to me, I just want a simple Event Dispatcher for my project. Therefore I made this for myself, and someone else needs the simple EventDispatcher.

### Installation

Download class.event.php to your project folder, and then include it anywhere.

```php
include_once('class.event.php');
```

PHP Event Dispatcher is designed as Singleton Pattern, you can not call it by **New EventDispatcher()** Just because to make sure that only an Event Dispatcher to handle all events.

Use the following **global** functions to use PHP Event Dispatcher, you can put it anywhere and easily inject in any framework.

### How to use

Add a listener function to an event

```php
addListener('event_name', 'function_name');
```

Run this event

```php
doDispatch('event_name');
```

Remove a listener function from an envet

Return: true / false

```php
removeListener('event_name', 'function_name');
```

Check out if there is any listener defined by an event

Return: true / false

```php
hasListener('event_name');
```

Check if an event Listener actually exists

Return: true / false

```php
isListening('event_name');
```

Check current running event Listener

```php
nowListener();
```

## Examples

test.php

```php
<?php

include_once('class.event.php');

addListener('event_send_message', 'send_message');

function send_message() {
    echo '<p>A message has been sent!!</p>';
    echo '<p>Current Running Event is called: <strong>' . nowListener() . '</strong></p>';
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
```

