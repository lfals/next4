<?php

// Config
$config->addAlias('~header', '~theme.header');

// Blank
if (empty($style)) {

    if ($center = $name === 'navbar' && in_array($config('~header.layout'), ['offcanvas-center-a', 'modal-center-a'])) {
        echo '<div class="uk-margin-auto-vertical">';
    }

    foreach ($items as $index => $item) {
        echo $view('~theme/templates/module', ['index' => $index, 'module' => $item, 'position' => $name]);
    }

    if ($center) {
        echo '</div>';
    }

    return;
}

// Cell
if ($style == 'cell') {

    foreach ($items as $index => $item) {
        echo "<div>{$view('~theme/templates/module', ['index' => $index, 'module' => $item, 'position' => $name])}</div>";
    }

    return;
}

// Section
if ($style == 'section') {

    $section = [];

    foreach ($items as $index => $item) {

        if (preg_match('/<!-- ({.*}) -->/si', $item->content, $matches)) {

            if ($section) {
                echo $view('~theme/templates/section', ['name' => $name, 'items' => $section]); $section = [];
            }

            $content = preg_replace('/<div class="uk-text-danger(.*?)<\/div>/si', '', $item->content);

            echo str_replace($matches[0], $view->builder($matches[1], ['prefix' => is_numeric($item->id) ? "module-{$item->id}" : $item->id]), $content);

        } else {
            $section[] = $item;
        }
    }

    if ($section) {
        echo $view('~theme/templates/section', ['name' => $name, 'items' => $section]);
    }

    return;
}

// Grid
$grid = isset($position) ? $position : $config("~theme.{$name}", []);
$visibilities = ['xs', 's', 'm', 'l', 'xl'];
$visible = 4;

// Widgets/Modules
$widgets = [];

foreach ($items as $index => $item) {

    $visibility = $config("~theme.modules.{$item->id}.visibility");
    $visible = min(array_search($visibility, $visibilities), $visible);
    $widget = $view('~theme/templates/module', ['index' => $index, 'module' => $item, 'position' => $name]);

    if (empty($widget)) {
        continue;
    }

    $widgets[] = $this->el(
        'div',
        [
            'class' => [
                'uk-width-{0}@{breakpoint}' => $config("~theme.modules.{$item->id}.width"),
                'uk-visible@{0}' => $visibility,
            ],
        ],
        $widget
    );
}

$el = $this->el('div', [
    'class' => [
        'uk-child-width-1-1' => $style == 'grid-stack',
        'uk-child-width-expand@{breakpoint}' => $style != 'grid-stack',
        isset($grid['column_gap'], $grid['row_gap']) && $grid['column_gap'] == $grid['row_gap'] ? 'uk-grid-{column_gap}' : '[uk-grid-column-{column_gap}] [uk-grid-row-{row_gap}]',
        'uk-grid-divider {@divider} {@!column_gap:collapse} {@!row_gap:collapse}',
        'uk-flex-middle {@vertical_align}',
        'uk-visible@{0}' => $visible ? $visibilities[$visible] : false,
    ],
    'uk-grid' => true,
    'uk-height-match' => ['target: .uk-card; row: false {@match}'],
]);

?>

<?= $el($grid) ?>
<?php foreach ($widgets as $widget) : ?>
    <?= $widget($grid) ?>
<?php endforeach ?>
<?= $el->end() ?>
