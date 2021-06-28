<?php

namespace YOOtheme\Builder;

use YOOtheme\Builder;
use YOOtheme\Event;
use YOOtheme\Metadata;

class BuilderListener
{
    public static function initCustomizer(Metadata $metadata, Builder $builder)
    {
        $data = json_encode(Event::emit('builder.data|filter', [
            'elements' => $builder->types,
        ]));

        $metadata->set('script:builder-data', "var \$builder = {$data};");
    }
}
