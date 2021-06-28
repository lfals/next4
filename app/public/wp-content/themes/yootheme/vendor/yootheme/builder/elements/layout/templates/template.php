<?php

if (isset($prefix)) {
    echo "<!-- Builder #{$prefix} -->";
}

echo $builder->render($children);

// Add elements inline css
if (!empty($props['css'])) {
    $css = preg_replace('/[\r\n\t\h]+/u', ' ', $props['css']);
    echo "<style>{$css}</style>";
}
