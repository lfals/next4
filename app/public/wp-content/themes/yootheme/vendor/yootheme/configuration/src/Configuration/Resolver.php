<?php

namespace YOOtheme\Configuration;

class Resolver
{
    /**
     * @var int
     */
    protected $ctime;

    /**
     * @var string
     */
    protected $cache;

    /**
     * @var string
     */
    protected $key = false;

    /**
     * @var array
     */
    protected $path = [];

    /**
     * @var array
     */
    protected $params = [];

    /**
     * @var array
     */
    protected $callbacks = [];

    /**
     * Constructor.
     *
     * @param string $cache
     * @param array  $params
     * @param array  $callbacks
     */
    public function __construct($cache, array $params = [], array $callbacks = [])
    {
        if (is_dir($cache)) {
            $this->cache = $cache;
            $this->ctime = filectime(__FILE__);
        }

        $this->params = $params;
        $this->callbacks = $callbacks;
    }

    /**
     * Resets the key and path.
     */
    public function __clone()
    {
        $this->key = false;
        $this->path = [];
    }

    /**
     * Resolves value and evaluates it after applying callbacks.
     *
     * @param mixed $value
     * @param array $params
     *
     * @return mixed
     */
    public function resolve($value, array $params = [])
    {
        $resolve = function ($value) use ($params) {
            return $value instanceof Node ? $value->resolve($params + $this->params) : $value;
        };

        return $this->resolveValue($value, array_merge($this->callbacks, [$resolve]));
    }

    /**
     * Resolves value recursively.
     *
     * @param mixed $value
     * @param array $callbacks
     *
     * @return mixed
     */
    public function resolveValue($value, array $callbacks)
    {
        // apply callbacks
        foreach ($callbacks as $callback) {
            $value = $callback($value, $this->key, $this->path);
        }

        if (is_array($value) && !empty($value)) {

            $array = [];
            $depth = count($this->path);

            // update path, if key was changed
            if ($this->key !== end($this->path)) {
                array_splice($this->path, -1, 1, $this->key);
            }

            foreach ($value as $key => $val) {

                // update key and path
                $this->key = $key;
                $this->path[$depth] = $key;

                // resolve recursively
                $val = $this->resolveValue($val, $callbacks);
                $array[$this->key] = $val;
            }

            // set key to last path part
            array_pop($this->path);
            $this->key = end($this->path);

            return $array;
        }

        return $value;
    }

    /**
     * Compiles a parsable string of a value after applying callbacks.
     *
     * @param mixed $value
     * @param array $params
     *
     * @return mixed
     */
    public function compile($value, array $params = [])
    {
        $compile = function ($value) use ($params) {
            return $value instanceof Node ? $value->compile($params + $this->params) : var_export($value, true);
        };

        return $this->compileValue($this->resolveValue($value, $this->callbacks), $compile);
    }

    /**
     * Compiles a parsable string representation of a value.
     *
     * @param mixed    $value
     * @param callable $callback
     * @param int      $indent
     *
     * @return string
     */
    public function compileValue($value, callable $callback = null, $indent = 0)
    {
        if (is_array($value)) {

            $array = [];
            $assoc = array_values($value) !== $value;
            $indention = str_repeat('  ', $indent);
            $indentlast = $assoc ? "\n" . $indention : '';

            foreach ($value as $key => $val) {
                $array[] = ($assoc ? "\n  " . $indention . var_export($key, true) . ' => ' : '') . $this->compileValue($val, $callback, $indent + 1);
            }

            return '[' . join(', ', $array) . $indentlast . ']';
        }

        return $callback ? $callback($value) : var_export($value, true);
    }

    /**
     * Loads a file.
     *
     * @param string $file
     * @param array  $params
     *
     * @throws \RuntimeException
     *
     * @return array|null
     */
    public function loadFile($file, array $params = [])
    {
        $params = array_merge($this->params, $params, compact('file'));
        $extension = pathinfo($file, PATHINFO_EXTENSION);

        if ($extension === 'php') {
            return $this->loadPhpFile($file, $params);
        }

        if ($extension === 'json') {
            return $this->loadJsonFile($file, $params);
        }

        throw new \RuntimeException("Unable to load file '{$file}'");
    }

    /**
     * Loads a PHP file.
     *
     * @param string $file
     * @param array  $params
     *
     * @throws \RuntimeException
     *
     * @return array
     */
    protected function loadPhpFile($file, array $params = [])
    {
        extract($params, EXTR_SKIP);

        if (!is_array($value = @include($file))) {
            throw new \RuntimeException("Unable to load file '{$file}'");
        }

        return $value;
    }

    /**
     * Loads a JSON config file.
     *
     * @param string $file
     * @param array  $params
     *
     * @throws \RuntimeException
     *
     * @return array
     */
    protected function loadJsonFile($file, array $params = [])
    {
        extract($params, EXTR_SKIP);

        $cache = sprintf('%s/%s-%s.php', $this->cache, pathinfo($file, PATHINFO_FILENAME), hash('crc32b', $file));

        if ($this->cache && is_file($cache) && filectime($cache) > max($this->ctime, filectime($file))) {
            return include $cache;
        }

        if (!$content = @file_get_contents($file)) {
            throw new \RuntimeException("Unable to load file '{$file}'");
        }

        if (!is_array($value = @json_decode($content, true))) {
            throw new \RuntimeException("Invalid JSON format in '{$file}'");
        }

        if ($this->cache && $this->writeCacheFile($cache, $value, $params)) {
            return include $cache;
        }

        return $this->resolve($value, $params);
    }

    /**
     * Writes a cache file.
     *
     * @param string $cache
     * @param array  $value
     * @param array  $params
     *
     * @return bool
     */
    protected function writeCacheFile($cache, array $value, array $params = [])
    {
        $temp = uniqid("{$this->cache}/temp-", true);
        $data = "<?php // \$file = {$params['file']}\n\nreturn {$this->compile($value, $params)};\n";

        return file_put_contents($temp, $data) && @rename($temp, $cache);
    }
}
