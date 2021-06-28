<?php

namespace YOOtheme\Theme;

use YOOtheme\Builder;
use YOOtheme\Config;
use YOOtheme\Metadata;
use YOOtheme\Path;
use YOOtheme\Translator;
use YOOtheme\Url;

class CustomizerListener
{
    public static function initCustomizer(Config $config, Metadata $metadata, Translator $translator, Builder $builder)
    {
        // load builder
        $config->update('~theme.footer.content', function ($footer) use ($builder) {
            return $builder->load($footer ? json_encode($footer) : '{}');
        });

        // add config
        $config->addFile('customizer', Path::get('../../config/customizer.json'));

        // add locale
        $translator->addResource(Path::get("../../languages/{$config('locale.code')}.json"));

        // add uikit
        $debug = $config('app.debug') ? '' : '.min';
        $metadata->set('script:uikit', ['src' => "~assets/uikit/dist/js/uikit{$debug}.js"]);
        $metadata->set('script:uikit-icons', ['src' => "~assets/uikit/dist/js/uikit-icons{$debug}.js"]);

        $config = [
            'url' => rtrim(Url::base(), '/'),
            'route' => Url::route(),
            'csrf' => $config('session.token'),
            'locale' => $config('locale.code'),
            'locales' => $translator->getResources(),
        ];

        $metadata->set('script:config', sprintf('var $config = %s;', json_encode($config)));
    }

    public static function lateInitCustomizer(Config $config, Metadata $metadata, Translator $translator)
    {
        $config = [
            'url' => rtrim(Url::base(), '/'),
            'route' => Url::route(),
            'csrf' => $config('session.token'),
            'locale' => $config('locale.code'),
            'locales' => $translator->getResources(),
        ];

        $metadata->set('script:config', sprintf('var $config = %s;', json_encode($config)));
    }

    public static function handleRequest(Config $config, $request, callable $next)
    {
        // Prevent image caching in customizer mode
        $request->setAttribute('save', !$config->get('app.isCustomizer'));

        return $next($request);
    }
}
