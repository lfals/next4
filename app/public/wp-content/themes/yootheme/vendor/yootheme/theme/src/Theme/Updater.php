<?php

namespace YOOtheme\Theme;

class Updater
{
    /**
     * @var string
     */
    public $version;

    /**
     * @var string[]
     */
    public $updates = [];

    /**
     * Constructor.
     *
     * @param string $version
     */
    public function __construct($version)
    {
        $this->version = $version;
    }

    /**
     * Add update files.
     *
     * @param string $file
     */
    public function add($file)
    {
        $this->updates[] = $file;
    }

    /**
     * Updates a config.
     *
     * @param array $config
     * @param mixed $params
     *
     * @return array
     */
    public function update($config, $params)
    {
        $version = empty($config['version']) ? '1.0.0' : $config['version'];

        // check node version
        if (version_compare($version, $this->version, '>=')) {
            return $config;
        }

        $config['version'] = $this->version;

        // apply update callbacks
        foreach ($this->resolveUpdates($version) as $updates) {
            foreach ($updates as $update) {
                $config = $update($config, $params);
            }
        }

        return $config;
    }

    /**
     * Resolves updates for the current version.
     *
     * @param string $version
     *
     * @return array
     */
    protected function resolveUpdates($version)
    {
        $resolved = [];

        foreach ($this->updates as $file) {

            $updates = require $file;

            foreach ($updates as $ver => $update) {
                if (version_compare($ver, $version, '>') && is_callable($update)) {
                    $resolved[$ver][] = $update;
                }
            }

        }

        uksort($resolved, 'version_compare');

        return $resolved;
    }
}
