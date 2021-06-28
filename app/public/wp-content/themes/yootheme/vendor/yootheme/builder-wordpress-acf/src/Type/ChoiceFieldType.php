<?php

namespace YOOtheme\Builder\Wordpress\Acf\Type;

class ChoiceFieldType
{
    /**
     * @return array
     */
    public static function config()
    {
        return [

            'fields' => [

                'label' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Label',
                    ],
                ],

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
