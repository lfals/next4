<?php

namespace YOOtheme\Builder\Wordpress\Acf\Type;

class ValueFieldType
{
    /**
     * @return array
     */
    public static function config()
    {
        return [

            'fields' => [

                'value' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Value',
                    ],
                ],

            ],

        ];
    }
}
