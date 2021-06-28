<?php

namespace YOOtheme\Configuration;

use YOOtheme\Config;
use YOOtheme\Path;

/**
 * A configuration with cache and value resolving.
 *
 * @example
 * ```json
 * {
 *    // config.json
 *   "yoo": "yoo"
 * }
 * ```
 *
 * ```php
 * use YOOtheme\Configuration;
 *
 * $config = new Configuration('/cache/folder');
 * $config->add('app', ['foo' => 'bar', 'woo' => ['baz' => 'baaz']]);
 * $config->get('app.foo');
 * $config->get('app.woo.baz');
 * \\=> baaz
 *
 * $config->add('app', '/config.json');
 * $config->get('app.yoo');
 * \\=> yoo
 * ```
 */
class Configuration extends Repository implements Config
{
    const REGEX_PATH = '/^(\.\.?)\/.*/S';

    const REGEX_STRING = '/\${((?:\w+:)+)?\s*([^}]+)}/S';

    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var Resolver
     */
    protected $resolver;

    /**
     * @var array
     */
    protected $cache = [];

    /**
     * Constructor.
     *
     * @param string $cache
     */
    public function __construct($cache = null)
    {
        $values = [
            'env' => $_ENV,
            'server' => $_SERVER,
            'globals' => $GLOBALS,
        ];

        $filter = [
            'path' => [$this, 'resolvePath'],
            'glob' => [$this, 'resolveGlob'],
            'load' => [$this, 'resolveLoad'],
        ];

        $params = [
            'config' => $this,
            'filter' => $this->filter = new Filter($filter),
        ];

        $this->values = $values;
        $this->resolver = new Resolver($cache, $params, [
            [$this, 'matchPath'],
            [$this, 'matchString'],
        ]);
    }

    /**
     * Adds a filter callback.
     *
     * @param string   $name
     * @param callable $filter
     *
     * @return $this
     */
    public function addFilter($name, callable $filter)
    {
        $this->filter->add($name, $filter);

        return $this;
    }

    /**
     * Adds a config file.
     *
     * @param string $index
     * @param string $file
     * @param bool   $replace
     *
     * @throws \RuntimeException
     *
     * @return $this
     */
    public function addFile($index, $file, $replace = true)
    {
        return $this->add($index, $this->loadFile($file), $replace);
    }

    /**
     * Loads a config file.
     *
     * @param string $file
     *
     * @throws \RuntimeException
     *
     * @return array
     */
    public function loadFile($file)
    {
        // load file config
        $config = $this->resolver->loadFile($file);
        $config = $this->resolveExtend($config);
        $config = $this->resolveImport($config);

        return $config;
    }

    /**
     * Matches paths ./some/path, ~alias/path.
     *
     * @param mixed $value
     *
     * @return mixed|Node
     */
    public function matchPath($value)
    {
        if (!is_string($value) || !preg_match(static::REGEX_PATH, $value, $matches)) {
            return $value;
        }

        if (isset($this->cache[$value])) {
            return $this->cache[$value];
        }

        return $this->cache[$value] = new FilterNode($this->matchString($matches[0]), 'path');
    }

    /**
     * Matches string interpolations ${...}.
     *
     * @param mixed $value
     *
     * @return mixed|Node
     */
    public function matchString($value)
    {
        if (!is_string($value) || !preg_match_all(static::REGEX_STRING, $value, $matches, PREG_SET_ORDER)) {
            return $value;
        }

        if (isset($this->cache[$value])) {
            return $this->cache[$value];
        }

        $replace = $arguments = [];

        foreach ($matches as $match) {

            list($search, $filter, $val) = $match;

            $replace[$search] = '%s';
            $arguments[] = $filter ? new FilterNode($val, rtrim($filter, ':')) : new VariableNode($val);
        }

        $format = strtr($value, $replace + ['%' => '%%']);

        return $this->cache[$value] = $format !== '%s' ? new StringNode($format, $arguments) : $arguments[0];
    }

    /**
     * Resolves and evaluates values.
     *
     * @param mixed $value
     * @param array $params
     *
     * @return mixed
     */
    public function resolve($value, array $params = [])
    {
        return $this->resolver->resolve($value, $params);
    }

    /**
     * Resolves "path: dir/myfile.php" filter.
     *
     * @param string $value
     * @param string $file
     *
     * @return string
     */
    public function resolvePath($value, $file)
    {
        return Path::resolve(dirname($file), $value);
    }

    /**
     * Resolves "glob: dir/file*.php" filter.
     *
     * @param string $value
     * @param string $file
     *
     * @return string[]
     */
    public function resolveGlob($value, $file)
    {
        return glob(Path::resolve(dirname($file), $value)) ?: [];
    }

    /**
     * Resolves "load: dir/file.php" filter.
     *
     * @param string $value
     * @param string $file
     *
     * @return mixed
     */
    public function resolveLoad($value, $file)
    {
        return $this->loadFile(Path::resolve(dirname($file), $value));
    }

    /**
     * Resolves "@extend" in config array.
     *
     * @param array $config
     *
     * @throws \RuntimeException
     *
     * @return array
     */
    protected function resolveExtend(array $config)
    {
        $extends = isset($config['@extend']) ? $config['@extend'] : [];

        foreach ((array) $extends as $extend) {
            $config = array_replace_recursive($this->loadFile($extend), $config);
        }

        unset($config['@extend']);

        return $config;
    }

    /**
     * Resolves "@import" in config array.
     *
     * @param array $config
     *
     * @throws \RuntimeException
     *
     * @return array
     */
    protected function resolveImport(array $config)
    {
        $imports = isset($config['@import']) ? $config['@import'] : [];

        foreach ((array) $imports as $import) {
            $config = array_replace_recursive($config, $this->loadFile($import));
        }

        unset($config['@import']);

        return $config;
    }
}
