<?php

if ($props['link_target'] != 'modal') {
    return;
}

$link = $this->el('image', [
    'src' => $props['link'],
    'width' => $props['lightbox_width'],
    'height' => $props['lightbox_height'],
]);

if ($this->isImage($props['link'])) {

    $lightbox = $link($element, ['thumbnail' => true]);

} else {

    $video = $this->isVideo($props['link']);
    $iframe = $this->iframeVideo($props['link'], [], false);
    $lightbox = $video && !$iframe ? $link($element, [

        // Video
        'controls' => true,
        'uk-video' => true,

    ], '', 'video') : $link($element, [

        // Iframe
        'src' => $iframe ?: $props['link'],
        'frameborder' => 0,
        'uk-video' => $video || $iframe,
        'uk-responsive' => true,

    ], '', 'iframe');

}

?>

<?php // uk-flex-top is needed to make vertical margin work for IE11 ?>
<div id="<?= $props['id'] ?>" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-width-auto uk-margin-auto-vertical">
        <button class="uk-modal-close-outside" type="button" uk-close></button>
        <?= $lightbox ?>
    </div>
</div>
