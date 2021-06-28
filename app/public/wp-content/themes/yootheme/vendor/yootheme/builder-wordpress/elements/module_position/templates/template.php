<?php

use function YOOtheme\app;
use YOOtheme\Theme\WidgetsListener;

app(WidgetsListener::class)->position = $props;

$el = $this->el('div');

?>

<?= $el($props, $attrs) ?>
    <?php dynamic_sidebar("{$props['content']}:grid" . ($props['layout'] === 'stack' ? '-stack' : '')) ?>
</div>
