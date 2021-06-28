<?php

use YOOtheme\Arr;

$fields = ['image', 'title', 'meta', 'content', 'link'];

// Find empty fields
$filtered = array_values(Arr::filter($fields, function ($field) use ($props, $children) {
    return Arr::some($children, function ($child) use ($field) {
        return $child->props[$field];
    });
}));

?>

<?php if (count($children)) : ?>
<table>
    <?php if (Arr::some($filtered, function ($field) use ($props) { return $props["table_head_{$field}"]; })) : ?>
    <thead>
        <tr>

            <?php foreach ($filtered as $i => $field) : ?>
            <th><?= $props["table_head_{$field}"] ?></th>
            <?php endforeach ?>

        </tr>
    </thead>
    <?php endif ?>

    <tbody>
        <?php foreach ($children as $i => $child) : ?>
        <tr><?= $builder->render($child, ['element' => $props, 'filtered' => $filtered]) ?></tr>
        <?php endforeach ?>
    </tbody>

</table>
<?php endif ?>
