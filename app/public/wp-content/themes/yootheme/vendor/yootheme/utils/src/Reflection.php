<?php

namespace YOOtheme;

/**
 * A static class which provides utilities for working with class reflections.
 */
abstract class Reflection
{
    const REGEX_ANNOTATION = '/@(?<name>[\w\\\\]+)(?:\s*(?:\(\s*)?(?<value>.*?)(?:\s*\))?)??\s*(?:\n|\*\/)/';

    /**
     * @var array
     */
    public static $annotations = [];

    /**
     * Gets reflector string representation.
     *
     * @param \Reflector $reflector
     *
     * @return string
     */
    public static function toString(\Reflector $reflector)
    {
        $string = $reflector->getName();

        if ($reflector instanceof \ReflectionMethod) {
            $string = "{$reflector->getDeclaringClass()->getName()}::{$string}()";
        }

        if (ini_get('display_errors') && method_exists($reflector, 'getFileName')) {
            $string .= " in {$reflector->getFileName()}:{$reflector->getStartLine()}-{$reflector->getEndLine()}";
        }

        return $string;
    }

    /**
     * Gets caller info using backtrace.
     *
     * @param string $key
     * @param int    $index
     *
     * @return mixed
     */
    public static function getCaller($key = null, $index = 1)
    {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $index + 1);

        return $key ? $backtrace[$index][$key] : $backtrace[$index];
    }

    /**
     * Gets reflection class for given classname.
     *
     * @param \ReflectionClass|object|string $class
     *
     * @throws \ReflectionException
     *
     * @return \ReflectionClass
     *
     * @example
     * Reflection::getClass('ClassName');
     */
    public static function getClass($class)
    {
        return $class instanceof \ReflectionClass ? $class : new \ReflectionClass($class);
    }

    /**
     * Gets the parent reflection classes for a given class.
     *
     * @param \ReflectionClass|object|string $class
     *
     * @return \ReflectionClass[]
     *
     * @example
     * Reflection::getParentClasses('ClassName');
     */
    public static function getParentClasses($class)
    {
        $class = static::getClass($class);

        do {
            $classes[] = $class;
        } while ($class = $class->getParentClass());

        return $classes;
    }

    /**
     * Gets the reflection properties for given class.
     *
     * @param \ReflectionClass|object|string $class
     *
     * @return \ReflectionProperty[]
     *
     * @example
     * Reflection::getProperties('ClassName');
     */
    public static function getProperties($class)
    {
        $properties = [];

        foreach (static::getClass($class)->getProperties() as $property) {
            $property->setAccessible(true);
            $properties[$property->name] = $property;
        }

        return $properties;
    }

    /**
     * Gets the reflection function for given callback.
     *
     * @param callable|string $callback
     *
     * @throws \ReflectionException
     *
     * @return \ReflectionFunctionAbstract
     *
     * @example
     * Reflection::getFunction('ClassName::methodName');
     */
    public static function getFunction($callback)
    {
        if (is_string($callback) && strpos($callback, '::')) {
            $callback = explode('::', $callback);
        }

        if (is_array($callback)) {
            return new \ReflectionMethod($callback[0], $callback[1]);
        }

        if (is_object($callback) && !$callback instanceof \Closure) {
            return (new \ReflectionObject($callback))->getMethod('__invoke');
        }

        return new \ReflectionFunction($callback);
    }

    /**
     * Gets the reflection parameters for given callback.
     *
     * @param callable|string $callback
     *
     * @throws \ReflectionException
     *
     * @return \ReflectionParameter[]
     *
     * @example
     * Reflection::getParameters('ClassName::methodName');
     */
    public static function getParameters($callback)
    {
        return static::getFunction($callback)->getParameters();
    }

    /**
     * Gets a annotation by name for given reflector.
     *
     * @param \Reflector $reflector
     * @param string     $name
     *
     * @return object|null
     *
     * @example
     * $reflector = Reflection::getAnnotation('ClassName');
     * Reflection::getAnnotation($reflector, 'tag');
     */
    public static function getAnnotation(\Reflector $reflector, $name)
    {
        if ($annotations = static::getAnnotations($reflector, $name)) {
            return $annotations[0];
        }
    }

    /**
     * Gets all annotations for given reflector.
     *
     * @param \Reflector $reflector
     * @param string     $name
     *
     * @return array
     *
     * @example
     * $reflector = Reflection::getClass('ClassName');
     * Reflection::getAnnotations($reflector);
     */
    public static function getAnnotations(\Reflector $reflector, $name = null)
    {
        if ($reflector instanceof \ReflectionClass) {
            $key = $reflector->name;
        } elseif ($reflector instanceof \ReflectionProperty) {
            $key = "{$reflector->class}.{$reflector->name}";
        } elseif ($reflector instanceof \ReflectionMethod) {
            $key = "{$reflector->class}:{$reflector->name}";
        }

        if (!isset(static::$annotations[$key])) {

            $comment = $reflector->getDocComment() ?: '';

            if (!$name || strpos($comment, "@{$name}")) {
                static::$annotations[$key] = static::parseAnnotations($comment);
            } elseif (!$comment || !strpos($comment, '@')) {
                return static::$annotations[$key] = [];
            } else {
                return [];
            }
        }

        return $name ? static::filterAnnotations(static::$annotations[$key], $name) : static::$annotations[$key];
    }

    /**
     * Parses all annotations from given string.
     *
     * @param string $string
     *
     * @return array
     */
    protected static function parseAnnotations($string)
    {
        $annotations = [];

        if (preg_match_all(static::REGEX_ANNOTATION, $string, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $match) {
                $annotations[] = (object) [
                    'name' => $match['name'],
                    'value' => isset($match['value']) ? $match['value'] : null,
                ];
            }
        }

        return $annotations;
    }

    /**
     * Filters annotations by given name.
     *
     * @param array  $annotations
     * @param string $string
     * @param mixed  $name
     *
     * @return array
     */
    protected static function filterAnnotations(array $annotations, $name)
    {
        $results = [];

        foreach ($annotations as $annotation) {
            if ($annotation->name == $name) {
                $results[] = $annotation;
            }
        }

        return $results;
    }
}
