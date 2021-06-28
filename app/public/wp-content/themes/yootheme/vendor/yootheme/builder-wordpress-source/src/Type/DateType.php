<?php

namespace YOOtheme\Builder\Wordpress\Source\Type;

class DateType
{
    /**
     * @return array
     */
    public static function config()
    {
        return [

            'fields' => [

                'date' => [
                    'type' => 'String',
                    'metadata' => [
                        'label' => 'Date',
                        'filters' => ['date'],
                    ],
                    'extensions' => [
                        'call' => __CLASS__ . '::date',
                    ],
                ],

            ],

            'metadata' => [
                'type' => true,
                'label' => 'Date',
            ],

        ];
    }

    public static function date()
    {
        return get_the_date();
    }
}
