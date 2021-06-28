<?php

namespace YOOtheme\GraphQL\Plugin;

use GraphQL\Type\Definition\Type;
use YOOtheme\Container;
use YOOtheme\GraphQL\Directive\BindDirective;
use YOOtheme\GraphQL\Directive\CallDirective;
use YOOtheme\GraphQL\SchemaBuilder;

class ContainerPlugin
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * Constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Register directives.
     *
     * @param SchemaBuilder $schema
     */
    public function onLoad(SchemaBuilder $schema)
    {
        $schema->setDirective(new BindDirective($this->container));
        $schema->setDirective(new CallDirective($this->container));
    }

    /**
     * Add directives on type.
     *
     * @param Type $type
     */
    public function onLoadType(Type $type)
    {
        $extensions = isset($type->config['extensions']) ? $type->config['extensions'] : [];

        if ($extensions and $directives = $this->getDirectives($extensions)) {

            if (!isset($type->config['directives'])) {
                $type->config['directives'] = [];
            }

            $type->config['directives'] = array_merge($type->config['directives'], $directives);
        }
    }

    /**
     * Add directives on field.
     *
     * @param Type  $type
     * @param array $field
     *
     * @return array
     */
    public function onLoadField(Type $type, array $field)
    {
        $extensions = isset($field['extensions']) ? $field['extensions'] : [];

        if ($extensions and $directives = $this->getDirectives($extensions)) {

            if (!isset($field['directives'])) {
                $field['directives'] = [];
            }

            $field['directives'] = array_merge($field['directives'], $directives);
        }

        return $field;
    }

    /**
     * Get directives.
     *
     * @param array $extensions
     *
     * @return array
     */
    protected function getDirectives(array $extensions)
    {
        $directives = [];

        if (isset($extensions['bind'])) {
            foreach ($extensions['bind'] as $id => $params) {
                $directives[] = $this->bindDirective($id, $params);
            }
        }

        if (isset($extensions['call'])) {
            $directives[] = $this->callDirective($extensions['call']);
        }

        return $directives;
    }

    /**
     * Get @bind directive.
     *
     * @param string       $id
     * @param string|array $params
     *
     * @return array
     */
    protected function bindDirective($id, $params)
    {
        if (is_string($params)) {
            $params = ['class' => $params];
        }

        if (isset($params['args'])) {
            $params['args'] = json_encode($params['args']);
        }

        return [
            'name' => 'bind',
            'args' => array_filter(compact('id') + $params),
        ];
    }

    /**
     * Get @call directive.
     *
     * @param string|array $params
     *
     * @return array
     */
    protected function callDirective($params)
    {
        if (is_string($params)) {
            $params = ['func' => $params];
        }

        if (isset($params['args'])) {
            $params['args'] = json_encode($params['args']);
        }

        return [
            'name' => 'call',
            'args' => $params,
        ];
    }
}
