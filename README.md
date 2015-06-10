# PHP Event Dispatcher

PHP Event Dispatcher is the most easy-to-use and simple Event Dispatcher PHP Class (Singleton Pattern).

Original idea is from **Symfony's event listener system.** 
http://symfony.com/doc/current/components/event_dispatcher/index.html

But I think it is a bit complex to me, I just want a simple Event Dispatcher for my probject. Therefore I made this for myself, and someone esle needs the simple EventDispatcher.

### Installation

Download class.event.php to your probject folder, and then include it anywhere.

### How to use

Add a listener function to an event
```
addListener('event_name', 'function_name');
```

Run this event

```
doDispatch('event_name');
```

Remove a listener function from an envet

Return: true / false

```
removeListener('event_name', 'function_name');
```

Check out if there is any listener defined by an event

Return: true / false

```
hasListener('event_name');
```

Check if an event Listener actually exists

Return: true / false

```
isListening('event_name');
```
