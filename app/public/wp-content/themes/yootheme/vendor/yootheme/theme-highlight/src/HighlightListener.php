<?php

namespace YOOtheme\Theme;

use Joomla\CMS\Application\CMSApplication;
use YOOtheme\Config;
use YOOtheme\Metadata;
use YOOtheme\Path;

class HighlightListener
{
    public static function checkContent(Config $config, Metadata $metadata, $content)
    {
        if ($highlight = $config('~theme.highlight') and strpos($content, '</code>')) {
            $metadata->set('style:highlight', ['href' => Path::get("../assets/styles/{$highlight}.css"), 'defer' => true]);
            $metadata->set('script:highlight', ['src' => Path::get('../assets/highlight.js'), 'defer' => true]);
            $metadata->set('script:highlight-init', 'document.addEventListener("DOMContentLoaded", function() {hljs.initHighlightingOnLoad()});');
        }

        return $content;
    }

    public static function beforeRender(Config $config, Metadata $metadata, CMSApplication $application)
    {
        static::checkContent($config, $metadata, $application->getDocument()->getBuffer('component'));
    }
}
