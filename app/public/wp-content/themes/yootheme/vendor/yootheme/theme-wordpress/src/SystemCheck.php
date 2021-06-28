<?php

namespace YOOtheme\Theme\Wordpress;

use YOOtheme\Config;
use YOOtheme\Path;

class SystemCheck extends \YOOtheme\Theme\SystemCheck
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * SystemCheck constructor.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function getRecommendations()
    {
        $res = [];

        if (!$this->config->get('~theme.yootheme_apikey')) {
            $res[] = 'wp_apikey';
        }

        if (Path::basename('~theme') !== 'yootheme') {
            $res[] = 'wp_theme_path';
        }

        return array_merge($res, parent::getRecommendations());
    }
}
