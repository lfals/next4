<?php

namespace YOOtheme;

$el = $this->el('div');

// Form
$form = $this->el('form', [

    'id' => 'search-' . rand(100, 999),
    'action' => home_url(),
    'method' => 'get',
    'role' => 'search',
    'class' => [
        'uk-search',
        'uk-search-default {@search_style:}',
        'uk-search-{!search_style:}',
        'uk-width-1-1',
    ],

]);

// Search
$search = $this->el('input', [

    'name' => 's',
    'value' => get_search_query(),
    'type' => 'search',
    'placeholder' => _x('Search', 'placeholder', 'yootheme'),
    'class' => [
        'uk-search-input',
        'uk-form-{search_size} {@!search_style}',
    ],
    'required' => true,

]);

// Icon
$icon = $props['search_icon'] ? $this->el($props['search_icon'] == 'right' ? 'button' : 'span', [

    'uk-search-icon' => true,

    'class' => [
        'uk-search-icon-flip {@search_icon: right}',
    ],

]) : null;

?>

<?= $el($props, $attrs) ?>

    <?= $form($props) ?>

        <?php if ($props['search_icon']) : ?>
        <?= $icon($props, '') ?>
        <?php endif ?>

        <?= $search($props) ?>

    <?= $form->end() ?>

<?= $el->end() ?>
