<?php

namespace YOOtheme\Builder;

class UpdateTransform
{
    /**
     * @var string
     */
    protected $version;

    /**
     * @var array
     */
    protected $updates = [];

    /**
     * @var array
     */
    protected $globals = [];

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
     * Transform callback.
     *
     * @param object $node
     * @param array  $params
     */
    public function __invoke($node, array &$params)
    {
        if (isset($node->transient)) {
            return;
        }

        if (isset($node->version)) {
            $params['version'] = $node->version;
        } elseif (empty($params['version'])) {
            $params['version'] = '1.0.0';
        }

        if ($node->type === 'layout') {
            $node->version = $this->version;
        } else {
            unset($node->version);
        }

        /**
         * @var $type
         * @var $version
         */
        extract($params);

        // check node version
        if (version_compare($version, $this->version, '>=')) {
            return;
        }

        // apply update callbacks
        foreach ($this->resolveUpdates($type, $version) as $update) {
            $update($node, $params);
        }
    }

    /**
     * Adds global updates for any type.
     *
     * @param array $globals
     *
     * @return $this
     */
    public function addGlobals(array $globals)
    {
        $this->globals[] = $globals;

        return $this;
    }

    /**
     * Resolves updates for a type and current version.
     *
     * @param object $type
     * @param string $version
     *
     * @return array
     */
    protected function resolveUpdates($type, $version)
    {
        if (isset($this->updates[$type->name][$version])) {
            return $this->updates[$type->name][$version];
        }

        $updates = $this->globals;

        if (isset($type->updates)) {
            $updates[] = $type->updates;
        }

        $resolved = [];

        foreach ($updates as $update) {
            foreach ($update as $ver => $func) {
                if (version_compare($ver, $version, '>') && is_callable($func)) {
                    $resolved[$ver][] = $func;
                }
            }
        }

        uksort($resolved, 'version_compare');

        return $this->updates[$type->name][$version] = $resolved ? array_merge(...array_values($resolved)) : [];
    }
}
