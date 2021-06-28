<?php

namespace YOOtheme\GraphQL;

use GraphQL\Error\InvariantViolation;
use GraphQL\Executor\Executor;
use GraphQL\Executor\Values;
use GraphQL\Language\AST\NodeList;
use GraphQL\Language\Parser;
use GraphQL\Type\Definition\Directive;
use GraphQL\Type\Definition\FieldDefinition;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Schema;
use GraphQL\Utils\BuildSchema;
use YOOtheme\GraphQL\Utils\AST;
use YOOtheme\GraphQL\Utils\Middleware;

class SchemaBuilder
{
    /**
     * @var array
     */
    protected $hooks = [];

    /**
     * @var array
     */
    protected $types = [];

    /**
     * @var array
     */
    protected $loadedTypes = [];

    /**
     * @var array
     */
    protected $directives = [];

    /**
     * Constructor.
     *
     * @param array $plugins
     */
    public function __construct(array $plugins = [])
    {
        $this->hooks = [
            'onLoad' => [],
            'onLoadType' => [],
            'onLoadField' => [],
        ];

        foreach ($plugins as $plugin) {
            $this->loadPlugin($plugin);
        }

        foreach ($this->hooks['onLoad'] as $hook) {
            $hook($this);
        }
    }

    /**
     * @param string $file
     * @param string $cache
     *
     * @return Schema
     */
    public function loadSchema($file, $cache = null)
    {
        if (is_file($cache) && filectime($cache) > filectime($file)) {

            $document = AST::fromArray(require $cache);

        } else {

            $document = Parser::parse(file_get_contents($file));

            if ($cache) {
                file_put_contents($cache, "<?php\n\nreturn {$this->exportValue(AST::toArray($document))};");
            }
        }

        return BuildSchema::build($document, function (array $config) {
            return ['resolveField' => [$this, 'resolveField']] + $config;
        });
    }

    /**
     * @param array $config
     *
     * @return Schema
     */
    public function buildSchema(array $config = [])
    {
        $config = array_replace_recursive([
            'query' => 'Query',
            'mutation' => 'Mutation',
            'subscription' => 'Subscription',
            'directives' => $this->directives,
            'typeLoader' => [$this, 'getType'],
        ], $config);

        if (is_string($config['query'])) {
            $config['query'] = $this->getType($config['query']);
        }

        if (is_string($config['mutation'])) {
            $config['mutation'] = $this->getType($config['mutation']);
        }

        if (is_string($config['subscription'])) {
            $config['subscription'] = $this->getType($config['subscription']);
        }

        return new Schema($config);
    }

    /**
     * @param array $config
     *
     * @return string
     */
    public function printSchema(array $config = [])
    {
        return SchemaPrinter::doPrint($this->buildSchema($config));
    }

    /**
     * @param string $name
     *
     * @return Directive
     */
    public function getDirective($name)
    {
        return isset($this->directives[$name]) ? $this->directives[$name] : null;
    }

    /**
     * @param Directive $directive
     */
    public function setDirective(Directive $directive)
    {
        $this->directives[$directive->name] = $directive;
    }

    /**
     * @param string $name
     *
     * @return Type|void
     */
    public function getType($name)
    {
        if (empty($this->loadedTypes)) {
            $this->loadedTypes = Type::getInternalTypes();
        }

        if (isset($this->loadedTypes[$name])) {
            return $this->loadedTypes[$name];
        }

        if (isset($this->types[$name])) {
            return $this->loadType($this->loadedTypes[$name] = $this->types[$name]);
        }

        return;
    }

    /**
     * @param Type $type
     */
    public function setType(Type $type)
    {
        $this->types[$type->name] = $type;
    }

    /**
     * @param array|callable $config
     *
     * @return ObjectType
     */
    public function queryType($config = [])
    {
        return $this->objectType('Query', $config);
    }

    /**
     * @param string         $name
     * @param array|callable $config
     *
     * @return ObjectType
     */
    public function objectType($name, $config = [])
    {
        $type = isset($this->types[$name]) ? $this->types[$name] : new ObjectType([
            'name' => $name, 'resolveField' => [$this, 'resolveField'],
        ]);

        if (is_callable($config)) {
            $config = $config($type, $this);
        }

        if (is_array($config)) {
            $type->config = array_replace_recursive($type->config, $config);
        }

        return $this->types[$name] = $type;
    }

    /**
     * @param Type $type
     *
     * @return Type
     */
    public function loadType(Type $type)
    {
        foreach ($this->hooks['onLoadType'] as $hook) {
            $hook($type, $this);
        }

        if (isset($type->config['description'])) {
            $type->description = $type->config['description'];
        }

        if (isset($type->config['resolveField'])) {
            $type->resolveFieldFn = $type->config['resolveField'];
        }

        if (isset($type->config['fields'])) {
            $type->config['fields'] = $this->loadFields($type, $type->config['fields']);
        }

        if ($type instanceof ObjectType) {
            $type->astNode = AST::objectType($type);
        }

        return $type;
    }

    /**
     * @param mixed       $value
     * @param mixed       $args
     * @param mixed       $context
     * @param ResolveInfo $info
     *
     * @return mixed
     */
    public function resolveField($value, $args, $context, ResolveInfo $info)
    {
        $resolver = new Middleware([Executor::class, 'defaultFieldResolver']);

        foreach ($this->resolveDirectives($info) as $directiveNode) {
            if (is_callable($directiveDef = $this->getDirective($directiveNode->name->value))) {
                if (is_callable($directive = $directiveDef(Values::getArgumentValues($directiveDef, $directiveNode, $info->variableValues), $resolver))) {
                    $resolver->push($directive);
                }
            }
        }

        return $resolver($value, $args, $context, $info);
    }

    /**
     * @param ResolveInfo $info
     *
     * @return NodeList
     */
    public function resolveDirectives(ResolveInfo $info)
    {
        $nodes = new NodeList([]);
        $field = $info->parentType->getField($info->fieldName);

        // type directives
        if (isset($info->parentType->astNode->directives)) {
            $nodes = $nodes->merge($info->parentType->astNode->directives);
        }

        // field directives
        if (isset($field->astNode->directives)) {
            $nodes = $nodes->merge($field->astNode->directives);
        }

        // query field directives
        foreach ($info->fieldNodes as $node) {
            if ($info->fieldName === $node->name->value) {
                return $nodes->merge($node->directives ?: []);
            }
        }

        return $nodes;
    }

    /**
     * @param Type  $type
     * @param array $field
     *
     * @return array
     */
    protected function loadField(Type $type, array $field)
    {
        $field += ['type' => null];

        if (is_string($field['type'])) {
            $field['type'] = $this->getType($field['type']);
        }

        if (is_array($field['type'])) {
            $field['type'] = $this->loadModifiers($field['type']);
        }

        if (empty($field['type'])) {
            throw new InvariantViolation("Field '{$field['name']}' on '{$type->name}' does not have a Type.");
        }

        return $field;
    }

    /**
     * @param Type  $type
     * @param array $fields
     *
     * @return array
     */
    protected function loadFields(Type $type, array $fields)
    {
        $result = [];

        foreach ($fields as $name => $field) {

            $field = $this->loadField($type, $field + [
                'name' => lcfirst($name), 'args' => [],
            ]);

            foreach ($field['args'] as $key => $arg) {
                $field['args'][$key] = $this->loadField($type, $arg);
            }

            foreach ($this->hooks['onLoadField'] as $hook) {
                $field = $hook($type, $field, $this);
            }

            $fieldDef = FieldDefinition::create($field);
            $fieldDef->astNode = AST::field($fieldDef);

            $result[$name] = $fieldDef;
        }

        return $result;
    }

    /**
     * @param array $type
     *
     * @return Type|array
     */
    protected function loadModifiers(array $type)
    {
        if (isset($type['nonNull'])) {

            if (is_string($type['nonNull'])) {
                $nonNull = $this->getType($type['nonNull']);
            } elseif (is_array($type['nonNull'])) {
                $nonNull = $this->loadModifiers($type['nonNull']);
            }

            $type = Type::nonNull(isset($nonNull) ? $nonNull : Type::string());

        } elseif (isset($type['listOf'])) {

            if (is_string($type['listOf'])) {
                $listOf = $this->getType($type['listOf']);
            } elseif (is_array($type['listOf'])) {
                $listOf = $this->loadModifiers($type['listOf']);
            }

            $type = Type::listOf(isset($listOf) ? $listOf : Type::string());
        }

        return $type;
    }

    /**
     * @param array $type
     * @param mixed $plugin
     *
     * @return Type|array
     */
    protected function loadPlugin($plugin)
    {
        foreach ($this->hooks as $method => &$hooks) {

            $hook = [$plugin, $method];

            if (is_callable($hook)) {
                $hooks[] = $hook;
            }
        }
    }

    /**
     * Export a parsable string representation of a value.
     *
     * @param mixed $value
     * @param int   $indent
     *
     * @return string
     */
    protected function exportValue($value, $indent = 0)
    {
        if (is_array($value)) {

            $array = [];
            $assoc = array_values($value) !== $value;
            $indention = str_repeat('  ', $indent);
            $indentlast = $assoc ? "\n" . $indention : '';

            foreach ($value as $key => $val) {
                $array[] = ($assoc ? "\n  " . $indention . var_export($key, true) . ' => ' : '') . $this->exportValue($val, $indent + 1);
            }

            return '[' . join(', ', $array) . $indentlast . ']';
        }

        return var_export($value, true);
    }
}
