<?php

$el = $this->el('pre', [

    'class' => [
        'uk-margin-remove {position: absolute}',
    ],

]);

?>

<?= $el($props, $attrs) ?>
<code class="el-content"><?= $this->e($props['content']) ?></code>
</pre>
