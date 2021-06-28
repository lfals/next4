<?php

namespace YOOtheme\Builder\Templates;

use YOOtheme\Builder;
use YOOtheme\Config;

class TemplateListener
{
    public static function loadTemplates(TemplateHelper $helper, Builder $builder, array $data)
    {
        $templates = array_filter(
            array_map(function ($template) use ($builder) {

                if (isset($template['layout'])) {
                    $template['layout'] = $builder->load(json_encode($template['layout']));
                }

                return $template;

            }, $helper->templates)
        );

        return $data + compact('templates');
    }

    public static function initCustomizer(Config $config)
    {
        $options = [];

        foreach ($config('customizer.templates', []) as $name => $template) {
            if (isset($template['group'])) {
                $options[$template['group']][$template['label']] = $name;
            } else {
                $options[$template['label']] = $name;
            }
        }

        $config->add('customizer.sections.builder-templates.fieldset.default.fields.type.options', $options);
    }
}
