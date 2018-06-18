<?php
/**
* PHP EventDispatcher
*
* @author Terry Lin
* @copyright Copyright (c) 2015 - Terry Lin
* @license http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
* @since Version 1.0
*/
namespace eventDispatcher;

class EventDispatcher
{
    // Instance of this class
    public static $instance;
    
    // Action statics
    public static $events;
    public static $current_event;
    public static $happened_events;

    private $error_message = '';
    
    /**
     * Constructer
     */
    private function __construct()
    {
        self::$instance = null;
        self::$events = array();
        self::$current_event = '';
        self::$happened_events = array();
    }

    /**
    * Instance()
    * Singleton pattern
    * The instance is made for easy use the function call.
    */
    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new EventDispatcher();
        }

        return self::$instance;
    }

    /**
    * addListener()
    *
    * Add a new trigger
    *
    * @param mixed $name
    * @param mixed $function
    * @param mixed $priority
    */
    public function addListener($name, $function, $priority = 10)
    {
        // return true if event has been registered
        if (isset(self::$events[$name][$priority][$function])) {
            return true;
        }

        /**
        * Allows us to iterate through multiple event hooks.
        */
        if (is_array($name)) {
            foreach ($name as $name) {
                self::$events[$name][$priority][$function] = array("function" => $function);
            }
        } else {
            self::$events[$name][$priority][$function] = array("function" => $function);
        }
        
        return true;
    }

    /**
    * doDispatch()
    *
    * Trigger an event Listener
    *
    * @param mixed $name
    * @param mixed $arguments
    * @return mixed
    */
    public function doDispatch($name, $arguments = "")
    {
        if (!isset(self::$events[$name])) {
            return $arguments;
        }
        
        // Set the current running event Listener
        self::$current_event = $name;

        ksort(self::$events[$name]);
        
        foreach (self::$events[$name] as $priority => $actions) {
            if (is_array($actions)) {
                foreach ($actions as $action) {
                    // run Listener and store the value returned by registered functions
                    if (function_exists($action['function'])) {
                        $return_arguments = call_user_func_array($action['function'], array(&$arguments));

                        if ($return_arguments) {
                            $arguments = $return_arguments;
                        }
                        // Store called Listeners
                        self::$happened_events[$name][$priority] = $action['function'];
                    } else {
                        $this->error_message = 'Event Dispatcher: Function "' . $action['function'] . '" not found. (' . $name . ')';
                        $this->hasError();
                    }
                }
            }
        }

        // This listener is finished its job
        self::$current_event = '';
        
        return $arguments;
    }
      
    /**
    * removeListener()
    *
    * Remove the event Listener from event array
    *
    * @param mixed $name
    * @param mixed $function
    * @param mixed $priority
    */
    public function removeListener($name, $function, $priority = 10)
    {
        unset(self::$events[$name][$priority][$function]);

        if (!isset(self::$events[$name][$priority][$function])) {
            return true;
        }
    }

    /**
    * nowListener()
    *
    * Get the currently running event Listener
    *
    */
    public function nowListener()
    {
        return self::$current_event;
    }

    /**
    * isListening()
    *
    * Check if a particular Listener has been called
    *
    * @param mixed $name
    * @param mixed $priority
    */
    public function isListening($name, $priority = 10)
    {
        if (isset(self::$events[$name][$priority])) {
            return true;
        }
        return false;
    }

    /**
    * hasListener()
    *
    * @param mixed $name
    */
    public function hasListener($name)
    {
        if (isset(self::$events[$name])) {
            return true;
        }
        return false;
    }

    /**
     * Debug
     *
     * @return void
     */
    public static function debug()
    {
        if (isset(self::$events)) {
            echo "<h2>Listeners</h2>";
            echo "<pre>";
            print_r(self::$events);
            echo "</pre>";
        }

        if (isset(self::$happened_events)) {
            echo "<h2>Listeners Called</h2>";
            echo "<pre>";
            print_r(self::$happened_events);
            echo "</pre>";
        }
    }

    private function hasError()
    {
        die($this->error_message);
    }
}

/**
* Add a new event Listener
*
* @param mixed $name
* @param mixed $function
* @param mixed $priority
*/
function addListener($name, $function, $priority = 10)
{
    return EventDispatcher::instance()->addListener($name, $function, $priority);
}

/**
* Run an event
*
* @param mixed $name
* @param mixed $arguments
* @return mixed
*/
function doDispatch($name, $arguments = "")
{
    return EventDispatcher::instance()->doDispatch($name, $arguments);
}

/**
* Remove an event Listener
*
* @param mixed $name
* @param mixed $function
* @param mixed $priority
*/
function removeListener($name, $function, $priority = 10)
{
    return EventDispatcher::instance()->removeListener($name, $function, $priority);
}

/**
* Check if an event Listener actually exists
*
* @param mixed $name
*/
function hasListener($name)
{
    return EventDispatcher::instance()->hasListener($name);
}

/**
* Check if a particular Listener has been called
*
* @param mixed $name
*/
function isListening($name, $priority = 10)
{
    return EventDispatcher::instance()->isListening($name, $priority);
}

/**
* Get current lister
*/
function nowListener()
{
    return EventDispatcher::instance()->nowListener();
}
