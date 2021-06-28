<?php

namespace YOOtheme\Application;

use YOOtheme\File;

trait LoaderTrait
{
    /**
     * @var array
     */
    protected $loaders = [];

    /**
     * Loads a bootstrap file.
     *
     * @param string $files
     *
     * @return $this
     */
    public function load($files)
    {
        $configs = [];

        foreach (File::glob($files) as $file) {
            $configs = static::loadFile($file, ['app' => $this, 'configs' => $configs]);
        }

        if (isset($configs['loaders'])) {
            $this->loaders = array_merge($this->loaders, ...$configs['loaders']);
        }

        foreach (array_intersect_key($this->loaders, $configs) as $name => $loader) {
            $loader($this, $configs[$name]);
        }

        return $this;
    }

    /**
     * Loads a bootstrap config.
     *
     * @param string $file
     * @param array  $parameters
     *
     * @return array
     */
    protected static function loadFile($file, array $parameters = [])
    {
        extract($parameters, EXTR_SKIP);

        if (!is_array($config = require $file)) {
            throw new \RuntimeException("Unable to load file '{$file}'");
        }

        foreach ($config as $key => $value) {
            $configs[$key][] = $value;
        }

        return $configs;
    }
}
