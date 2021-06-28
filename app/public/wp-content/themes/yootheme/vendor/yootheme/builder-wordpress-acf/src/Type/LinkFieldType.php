<?php

namespace YOOtheme\Builder\Wordpress\Acf\Type;

class LinkFieldType
{
    /**
     * @return array
     */
    public static function config()
    {
        return [

            'fields' => [

                'title' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Text',
                    ],
                ],

                'url' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Url',
                    ],
                ],

            ],

        ];
    }
}
