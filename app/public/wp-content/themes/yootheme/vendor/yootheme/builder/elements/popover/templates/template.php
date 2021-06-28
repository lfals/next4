<?php

$el = $this->el('div', [

    // Fix stacking context for drops if parallax is enabled
    'class' => ['uk-position-relative uk-position-z-index {@animation: parallax}'],

]);

// Image
$image = $this->el('image', [
    'class' => [
        'uk-text-{image_svg_color}' => $props['image_svg_inline'] && $props['image_svg_color'] && $this->isImage($props['background_image']) == 'svg',
    ],
    'src' => $props['background_image'],
    'alt' => $props['background_image_alt'],
    'width' => $props['background_image_width'],
    'height' => $props['background_image_height'],
    'uk-svg' => $props['image_svg_inline'],
    'thumbnail' => true,
]);

// Swicher
$switcher = $this->el('ul', [
    'id' => "js-{$this->uid()}",
    'class' => 'uk-switcher',
]);

// Switcher nav
$switcher_nav = $this->el('ul', [
    'class' => 'uk-dotnav uk-flex-center uk-margin',
    'uk-switcher' => "connect: #{$switcher->attrs['id']}; animation: uk-animation-fade;",
]);

?>

<?= $el($props, $attrs) ?>
    <div class="uk-inline">

        <?= $props['background_image'] ? $image($props) : '' ?>

        <div class="tm-popover-items uk-visible@s">
            <?php foreach ($children as $child) : ?>
            <?= $this->render("{$__dir}/template-marker", ['child' => $child, 'props' => $child->props, 'element' => $props]) ?>
            <?php endforeach ?>
        </div>

    </div>
    <div class="tm-popover-items uk-margin uk-hidden@s">

        <?= $switcher() ?>
            <?php foreach ($children as $child) : ?>
            <li><?= $builder->render($child, ['element' => $props]) ?></li>
            <?php endforeach ?>
        </ul>

        <?= $switcher_nav() ?>
            <?php foreach ($children as $child) : ?>
            <li><a href="#"></a></li>
            <?php endforeach ?>
        </ul>

    </div>
</div>
