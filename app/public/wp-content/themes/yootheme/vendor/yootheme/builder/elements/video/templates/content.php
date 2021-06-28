<?php if ($props['video'] && $this->iframeVideo($props['video'], [], false)) : ?>
<iframe src="<?= $props['video'] ?>"></iframe>
<?php elseif($props['video']) : ?>
<video src="<?= $props['video'] ?>" poster="<?= $props['video_poster'] ?>"></video>
<?php endif ?>
