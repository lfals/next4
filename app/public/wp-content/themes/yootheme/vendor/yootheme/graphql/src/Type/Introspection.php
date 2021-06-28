<?php

namespace YOOtheme\GraphQL\Type;

use GraphQL\Type\Introspection as BaseIntrospection;

class Introspection extends BaseIntrospection
{
    public static function getIntrospectionQuery($options = [])
    {
        $value = function ($value) {
            return is_callable($value) ? $value() : $value;
        };

        $options += [
            'defaults' => ['description'],
        ];

        foreach (static::getTypes() as $name => $type) {
            if (isset($options[$name])) {
                $type->config['fields'] = $value($type->config['fields']) + $options[$name];
                $fields[$name] = join(' ', array_merge($options['defaults'], array_keys($options[$name])));
            } else {
                $fields[$name] = join(' ', $options['defaults']);
            }
        }

        return <<<EOD
  query IntrospectionQuery {
    __schema {
      queryType { name }
      mutationType { name }
      subscriptionType { name }
      types {
        ...FullType
      }
      directives {
        name
        {$fields['__Directive']}
        locations
        args {
          ...InputValue
        }
      }
    }
  }

  fragment FullType on __Type {
    kind
    name
    {$fields['__Type']}
    fields(includeDeprecated: true) {
      name
      {$fields['__Field']}
      args {
        ...InputValue
      }
      type {
        ...TypeRef
      }
    }
    inputFields {
      ...InputValue
    }
    interfaces {
      ...TypeRef
    }
    enumValues(includeDeprecated: true) {
      name
      {$fields['__EnumValue']}
    }
    possibleTypes {
      ...TypeRef
    }
  }

  fragment InputValue on __InputValue {
    name
    {$fields['__InputValue']}
    type { ...TypeRef }
    defaultValue
  }

  fragment TypeRef on __Type {
    kind
    name
    ofType {
      kind
      name
      ofType {
        kind
        name
        ofType {
          kind
          name
          ofType {
            kind
            name
            ofType {
              kind
              name
              ofType {
                kind
                name
                ofType {
                  kind
                  name
                }
              }
            }
          }
        }
      }
    }
  }
EOD;
    }
}
