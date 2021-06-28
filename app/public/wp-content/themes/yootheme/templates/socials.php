<?php

// Config
$config->addAlias('~header', '~theme.header');

// Attrs
$attrs['class'] = $config('~header.social_style') ? 'uk-icon-button' : 'uk-icon-link';

// Grid
$attrs_grid = [];
$attrs_grid['class'][] = 'uk-flex-inline uk-flex-middle uk-flex-nowrap';
$attrs_grid['class'][] = $config('~header.social_gap') ? "uk-grid-{$config('~header.social_gap')}" : '';
$attrs_grid['uk-grid'] = true;

// Links
$links = array_filter(array_slice((array) $config('~theme.social_links'), 0, 5));

?>

<?php if (count($links)) : ?>
    <ul<?= $this->attrs($attrs_grid) ?>>
        <?php foreach ($links as $link) :
            $attrs['target'] = $config('~header.social_target') && (preg_match('/(tel:|mailto:)/', $link) == 0) ? '_blank' : false;

            $attrs_icon = [
                'uk-icon' => json_encode(array_filter([
                    'icon' => $this->e($link, 'social'),
                    'width' => $config('~header.social_width'),
                ])),
            ];

            ?>
            <li>
                <a<?= $this->attrs(['href' => $link], $attrs) ?> <?= $this->attrs($attrs_icon) ?>></a>
            </li>
        <?php endforeach ?>
    </ul>
<?php endif ?>
