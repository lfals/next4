<?php

namespace YOOtheme\Wordpress;

use YOOtheme\Storage as AbstractStorage;

class Storage extends AbstractStorage
{
    /**
     * Constructor.
     *
     * @param string $name
     */
    public function __construct($name = 'yootheme')
    {
        $this->addJson(get_option($name));

        add_action('shutdown', function () use ($name) {
            if ($values = json_encode($this)) {
                update_option($name, $values);
            }
        });
    }
}
