<?php

namespace YOOtheme;

use YOOtheme\Util\Arr;
use YOOtheme\Util\Path;

class ConfigManager
{
    const REGEX_PATH = '/^(~~?|\.\.?)\/.+/';

    const REGEX_REPLACE = '/\${((?:\w+:)+)?([^}]+)}/';

    /**
     * @var string
     */
    protected $file;

    /**
     * @var string
     */
    protected $cache;

    /**
     * @var int
     */
    protected $ctime;

    /**
     * @var array
     */
    protected $params;

    /**
     * @var \ArrayObject
     */
    protected $filters;

    /**
     * @var \ArrayObject
     */
    protected $configs;

    /**
     * Constructor.
     *
     * @param string $cache
     * @param array  $params
     */
    public function __construct($cache = null, array $params = [])
    {
        $configs = [
            'env' => $_ENV,
            'server' => $_SERVER,
            'globals' => $GLOBALS,
        ];

        $filters = [
            'load' => [$this, 'resolveLoad'],
            'path' => [$this, 'resolvePath'],
        ];

        if (is_dir($cache)) {
            $this->cache = $cache;
            $this->ctime = filectime(__FILE__);
        }

        $this->params = $params;
        $this->filters = new \ArrayObject($filters);
        $this->configs = new \ArrayObject($configs);
    }

    /**
     * Gets a config value.
     *
     * @param string $index
     * @param mixed  $default
     *
     * @return mixed
     */
    public function get($index, $default = null)
    {
        $parts = explode('.', $index, 2);

        // get value from params
        if ($parts[0] === '' && isset($parts[1])) {
            return self::getValue($this->params, $parts[1], $default);
        }

        return self::getValue($this->configs, $index, $default);
    }

    /**
     * Sets a config value.
     *
     * @param string $index
     * @param mixed  $value
     *
     * @return self
     */
    public function set($index, $value)
    {
        Arr::set($this->configs, $index, $value);

        return $this;
    }

    /**
     * Removes a config value.
     *
     * @param string $index
     *
     * @return self
     */
    public function remove($index)
    {
        Arr::remove($this->configs, $index);

        return $this;
    }

    /**
     * Adds a config array.
     *
     * @param string $name
     * @param array  $config
     *
     * @return self
     */
    public function add($name, array $config)
    {
        $this->configs[$name] = isset($this->configs[$name]) ? array_replace_recursive($this->configs[$name], $config) : $config;

        return $this;
    }

    /**
     * Adds a config file.
     *
     * @param string $name
     * @param string $file
     * @param array  $params
     *
     * @throws \RuntimeException
     *
     * @return self
     */
    public function addFile($name, $file, array $params = [])
    {
        return $this->add($name, $this->load($file, $params));
    }

    /**
     * Adds a config filter callback.
     *
     * @param string   $name
     * @param callable $filter
     *
     * @return self
     */
    public function addFilter($name, callable $filter)
    {
        $this->filters[$name] = $filter;

        return $this;
    }

    /**
     * Applies filters to a value.
     *
     * @param mixed $value
     * @param array $filters
     *
     * @throws \RuntimeException
     *
     * @return mixed
     */
    public function applyFilter($value, array $filters)
    {
        foreach ($filters as $name) {

            if (!isset($this->filters[$name])) {
                throw new \RuntimeException("Undefined filter '{$name}' in '{$this->file}'");
            }

            $value = $this->filters[$name]($value, $this->file, $this);
        }

        return $value;
    }

    /**
     * Loads a config.
     *
     * @param string $file
     * @param array  $params
     * @param object $context
     *
     * @throws \RuntimeException
     *
     * @return array
     */
    public function load($file, array $params = [], $context = null)
    {
        // parse file info
        $file = strtr($file, '\\', '/');
        $file = pathinfo($file) + ['pathname' => $file, 'extension' => ''];

        // create clone
        $clone = clone $this;
        $clone->file = $file['pathname'];
        $clone->params = array_replace($this->params, $params, compact('file'));

        // create context
        if (!$context) {
            $context = new \ArrayObject();
            $context->setFlags(\ArrayObject::ARRAY_AS_PROPS);
        }

        // load config file
        $config = $clone->loadFile($file, $context);
        $config = $clone->resolveImport($config, $context);

        // exchange context array
        if ($context instanceof \ArrayObject) {
            $context->exchangeArray($config);
        }

        return $config;
    }

    /**
     * Loads a config file.
     *
     * @param array  $file
     * @param object $context
     *
     * @throws \RuntimeException
     *
     * @return array|null
     */
    protected function loadFile(array $file, $context)
    {
        if ($file['extension'] === 'php') {
            return $this->loadPhpFile($file, $context);
        }

        if ($file['extension'] === 'json') {
            return $this->loadJsonFile($file, $context);
        }

        throw new \RuntimeException("Unable to load file '{$file['pathname']}'");
    }

    /**
     * Loads a PHP config file.
     *
     * @param array  $file
     * @param object $context
     *
     * @return array
     */
    protected function loadPhpFile(array $file, $context)
    {
        $closure = function ($file, $config, $_params) {

            // extract params to scope
            extract($_params, EXTR_SKIP);

            // include config file
            if (!is_array($data = @include($file['pathname']))) {
                throw new \RuntimeException("Unable to load file '{$file['pathname']}'");
            }

            return $data;
        };

        // bind context object
        $include = $closure->bindTo($context);

        return $include($file, $this, $this->params);
    }

    /**
     * Loads a JSON config file.
     *
     * @param array  $file
     * @param object $context
     *
     * @throws \RuntimeException
     *
     * @return array
     */
    protected function loadJsonFile(array $file, $context)
    {
        $hash = hash('crc32b', $file['pathname']);
        $cache = "{$this->cache}/{$file['filename']}-{$hash}.php";

        if ($this->cache && file_exists($cache) && filectime($cache) > max($this->ctime, filectime($file['pathname']))) {
            return include $cache;
        }

        if (!$content = @file_get_contents($file['pathname'])) {
            throw new \RuntimeException("Unable to load file '{$file['pathname']}'");
        }

        if (!is_array($data = @json_decode($content, true))) {
            throw new \RuntimeException("Invalid JSON format in '{$file['pathname']}'");
        }

        if ($this->cache && $this->writeCacheFile($cache, $data, $file['pathname'])) {
            return include $cache;
        }

        return $this->replaceVariables($data);
    }

    /**
     * Writes a cache file.
     *
     * @param string $cache
     * @param array  $value
     * @param string $filename
     *
     * @return bool
     */
    protected function writeCacheFile($cache, array $value, $filename)
    {
        $temp = uniqid("{$this->cache}/temp-", true);
        $export = [$this, 'exportVariable'];
        $banner = "<?php // @file %s\n\nreturn %s;\n";

        return file_put_contents($temp, sprintf($banner, $filename, self::exportValue($value, $export))) && @rename($temp, $cache);
    }

    /**
     * Resolves "load:dir/myfile.php" filter.
     *
     * @param string $value
     * @param string $file
     *
     * @return mixed
     */
    protected function resolveLoad($value, $file)
    {
        return $this->load($value);
    }

    /**
     * Resolves "path:dir/myfile.php" filter.
     *
     * @param string $value
     * @param string $file
     *
     * @return string
     */
    protected function resolvePath($value, $file)
    {
        $root = rtrim(dirname($file), '/');
        $path = Path::normalize("{$root}/{$value}");

        return $path;
    }

    /**
     * Resolves "@import" in config.
     *
     * @param array  $config
     * @param object $context
     *
     * @throws \RuntimeException
     *
     * @return array
     */
    protected function resolveImport(array $config, $context)
    {
        $imports = isset($config['@import']) ? (array) $config['@import'] : [];

        foreach ($imports as $import) {
            $config = array_replace_recursive($config, $this->load($import, [], $context));
        }

        unset($config['@import']);

        return $config;
    }

    /**
     * Replaces variables in config.
     *
     * @param mixed $value
     *
     * @throws \RuntimeException
     *
     * @return mixed
     */
    protected function replaceVariables($value)
    {
        if (is_string($value)) {

            $value = preg_replace(self::REGEX_PATH, '${path:$0}', $value, 1);

            if (preg_match_all(self::REGEX_REPLACE, $value, $matches, PREG_SET_ORDER)) {

                $replace = [];

                if ($value === $matches[0][0]) {
                    return $matches[0][1] ? $this->applyFilter($matches[0][2], $this->exportFilter($matches[0][1], false)) : $this->get($matches[0][2]);
                }

                foreach ($matches as $match) {
                    $replace[$match[0]] = $match[1] ? $this->applyFilter($match[2], $this->exportFilter($match[1], false)) : $this->get($match[2]);
                }

                return strtr($value, $replace);
            }
        }

        if (is_array($value)) {

            foreach ($value as &$val) {
                $val = $this->replaceVariables($val);
            }

        }

        return $value;
    }

    /**
     * Exports variable as parsable string.
     *
     * @param mixed $value
     *
     * @return string
     */
    protected function exportVariable($value)
    {
        if (is_string($value)) {

            $value = preg_replace(self::REGEX_PATH, '${path:$0}', $value, 1);

            if (preg_match_all(self::REGEX_REPLACE, $value, $matches, PREG_SET_ORDER)) {

                $replace = ['"' => '\"'];

                if ($value == $matches[0][0]) {
                    return $matches[0][1] ? "\$this->applyFilter('{$matches[0][2]}', {$this->exportFilter($matches[0][1])})" : "\$this->get('{$matches[0][2]}')";
                }

                foreach ($matches as $match) {
                    $replace[$match[0]] = $match[1] ? "{\$this->applyFilter('{$match[2]}', {$this->exportFilter($match[1])})}" : "{\$this->get('{$match[2]}')}";
                }

                return '"' . strtr($value, $replace) . '"';
            }
        }

        return var_export($value, true);
    }

    /**
     * Exports "filter1:filter2:..." expression.
     *
     * @param string $filter
     * @param bool   $export
     * @param mixed  $filters
     *
     * @return string|array
     */
    protected function exportFilter($filters, $export = true)
    {
        $filters = array_reverse(explode(':', rtrim($filters, ':')));

        return $export ? self::exportValue($filters) : $filters;
    }

    /**
     * Exports a parsable string representation of a value.
     *
     * @param mixed    $value
     * @param callable $export
     * @param int      $indent
     *
     * @return string
     */
    protected static function exportValue($value, callable $export = null, $indent = 0)
    {
        if (is_array($value)) {

            $assoc = array_values($value) !== $value;
            $indention = str_repeat('  ', $indent);
            $indentlast = $assoc ? "\n" . $indention : '';

            foreach ($value as $key => $val) {
                $array[] = ($assoc ? "\n  " . $indention . var_export($key, true) . ' => ' : '') . self::exportValue($val, $export, $indent + 1);
            }

            return '[' . (isset($array) ? join(', ', $array) . $indentlast : '') . ']';
        }

        return $export ? $export($value) : var_export($value, true);
    }

    /**
     * Gets a value from array or object.
     *
     * @param mixed            $object
     * @param string|array|int $index
     * @param mixed            $default
     *
     * @return mixed
     */
    protected static function getValue($object, $index, $default = null)
    {
        $index = is_array($index) ? $index : explode('.', $index);

        while (!is_null($key = array_shift($index))) {
            if ((is_array($object) || $object instanceof \ArrayAccess) && isset($object[$key])) {
                $object = $object[$key];
            } elseif (is_object($object) && isset($object->$key)) {
                $object = $object->$key;
            } else {
                return $default;
            }
        }

        return $object;
    }
}
