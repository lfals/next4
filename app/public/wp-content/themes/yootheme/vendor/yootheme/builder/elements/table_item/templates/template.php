<?php

foreach ($filtered as $j => $field) {

    echo $this->el('td', [

        'class' => [

            'uk-text-nowrap' => $field === 'link',
            "uk-text-nowrap {@table_width_{$field}: shrink}" => in_array($field, $text_fields),

            // Last column alignment
            'uk-text-{table_last_align}[@m {@table_responsive: responsive}]' => array_search($field, $fields) > 1 && !isset($filtered[$j + 1]),

            // Widths
            "uk-[table {@table_width_{$field}: shrink}][width {@!table_width_{$field}: shrink}]-{table_width_{$field}}" => $i == 0 && in_array($field, $text_fields),
            'uk-table-shrink' => $i == 0 && in_array($field, ['image', 'link']),
        ],

    ], $this->render("{$__dir}/template-{$field}"))->render($element);

}
