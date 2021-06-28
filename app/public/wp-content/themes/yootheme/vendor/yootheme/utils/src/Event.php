<?php

namespace YOOtheme;

abstract class Event
{
    /**
     * @var EventDispatcher
     */
    protected static $dispatcher;

    /**
     * Adds an event listener.
     *
     * @param string   $event
     * @param callable $listener
     * @param int      $priority
     */
    public static function on($event, $listener, $priority = 0)
    {
        static::getDispatcher()->addListener($event, $listener, $priority);
    }

    /**
     * Removes an event listener.
     *
     * @param string   $event
     * @param callable $listener
     *
     * @return bool
     */
    public static function off($event, $listener = null)
    {
        return static::getDispatcher()->removeListener($event, $listener);
    }

    /**
     * Emits an event with arguments.
     *
     * @param string $event
     * @param array  $arguments
     *
     * @return mixed
     */
    public static function emit($event, ...$arguments)
    {
        return static::getDispatcher()->dispatch($event, ...$arguments);
    }

    /**
     * Gets the event dispatcher instance.
     *
     * @return EventDispatcher
     */
    public static function getDispatcher()
    {
        return static::$dispatcher ?: static::$dispatcher = new EventDispatcher();
    }
}
