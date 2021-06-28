<?php

use YOOtheme\Arr;

$text_fields = ['title', 'meta', 'content'];

switch ($props['table_order']) {
    case 1:
        $fields = ['meta', 'image', 'title', 'content', 'link'];
        break;
    case 2:
        $fields = ['title', 'image', 'meta', 'content', 'link'];
        break;
    case 3:
        $fields = ['image', 'title', 'content', 'meta', 'link'];
        break;
    case 4:
        $fields = ['image', 'title', 'meta', 'content', 'link'];
        break;
    case 5:
        $fields = ['title', 'meta', 'content', 'link', 'image'];
        break;
    case 6:
        $fields = ['meta', 'title', 'content', 'link', 'image'];
        break;
}

// Find empty fields
$filtered = array_values(Arr::filter($fields, function ($field) use ($props, $children) {
    return $props["show_{$field}"] && Arr::some($children, function ($child) use ($field) {
        return $child->props[$field];
    });
}));

$el = $this->el('div', [

    // Responsive
    'class' => [
        'uk-overflow-auto {@table_responsive: overflow}',
    ],

]);

$table = $this->el('table', [

    'class' => [

        // Style
        'uk-table',
        'uk-table-{table_style}',
        'uk-table-hover {@table_hover}',
        'uk-table-justify {@table_justify}',

        // Size
        'uk-table-{table_size}',

        // Vertical align
        'uk-table-middle {@table_vertical_align}',

        // Responsive
        'uk-table-responsive {@table_responsive: responsive}',
    ],

]);

?>

<?php if ($props['table_responsive'] == 'overflow') : ?>
<?= $el($props, $attrs) ?>
    <?= $table($props) ?>
<?php else : ?>
    <?= $table($props, $attrs) ?>
<?php endif ?>

        <?php if (Arr::some($filtered, function ($field) use ($props) { return $props["table_head_{$field}"]; })) : ?>
        <thead>
            <tr>

                <?php foreach ($filtered as $i => $field) {

                    $lastColumn = $i !== 0 && !isset($filtered[$i + 1]);

                    echo $this->el('th', [

                        'class' => [
                            // Last column alignment
                            'uk-text-{table_last_align}[@m {@table_responsive: responsive}]' => $lastColumn,

                            // Text align need to be set for table heading
                            'uk-text-{text_align}[@{text_align_breakpoint} [uk-text-{text_align_fallback}] {@!text_align: justify}]' => !$lastColumn || !$props['table_last_align'],

                            // Text nowrap
                            'uk-text-nowrap' => $field == 'link' || in_array($field, $text_fields) && $props["table_width_{$field}"] == 'shrink',
                        ],

                    ], $props["table_head_{$field}"])->render($props);

                } ?>

            </tr>
        </thead>
        <?php endif ?>

        <tbody>
        <?php foreach ($children as $i => $child) : ?>
        <tr class="el-item"><?= $builder->render($child, ['i' => $i, 'element' => $props, 'fields' => $fields, 'text_fields' => $text_fields, 'filtered' => $filtered]) ?></tr>
        <?php endforeach ?>
        </tbody>

    </table>

<?php if ($props['table_responsive'] == 'overflow') : ?>
</div>
<?php endif ?>
