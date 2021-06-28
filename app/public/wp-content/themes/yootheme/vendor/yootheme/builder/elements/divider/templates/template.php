<?php

$el = $this->el($props['divider_element'], [

    'class' => [
        'uk-divider-{divider_style}',
        'uk-hr {!divider_style} {@divider_element: div}',
        'uk-text-{divider_align}[@{divider_align_breakpoint} [uk-text-{divider_align_fallback}] {@!divider_align: justify}] {@divider_style: small}',
        'uk-margin-remove {position: absolute}',
    ],

]);

echo $el($props, $attrs, '');
