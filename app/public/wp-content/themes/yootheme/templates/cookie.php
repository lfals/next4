<?php

// Config
$config->addAlias('~cookie', '~theme.cookie');

?>
<?php if ($config('~cookie.type') === 'bar') : ?>

    <div class="tm-cookie-banner uk-section uk-section-xsmall uk-section-<?= $config('~cookie.bar_style') ?><?= $config('~cookie.bar_position') === 'bottom' ? ' uk-position-bottom uk-position-fixed' : ' uk-position-relative' ?>">
        <div class="uk-container uk-container-expand uk-text-center">

            <?= __($config('~cookie.message'), 'yootheme')?>

            <?php if ($config('~cookie.button_consent_style') === 'icon') : ?>
                <button type="button" class="js-accept uk-close uk-position-center-right uk-position-medium" data-uk-close data-uk-toggle="target: !.uk-section; animation: true"></button>
            <?php else : ?>
                <button type="button" class="js-accept uk-button uk-button-<?= $config('~cookie.button_consent_style') ?> uk-margin-small-left" data-uk-toggle="target: !.uk-section; animation: true"><?= __($config('~cookie.button_consent_text'), 'yootheme')?></button>
            <?php endif ?>

            <?php if ($config('~cookie.mode') === 'consent') : ?>
            <button type="button" class="js-reject uk-button uk-button-<?= $config('~cookie.button_reject_style') ?> uk-margin-small-left" data-uk-toggle="target: !.uk-section; animation: true"><?= __($config('~cookie.button_reject_text'), 'yootheme')?></button>
            <?php endif ?>

        </div>
    </div>

<?php else : ?>

    <div class="tm-cookie-banner uk-notification uk-notification-<?= $config('~cookie.notification_position') ?>">
        <div class="uk-notification-message<?= $config('~cookie.notification_style') ? " uk-notification-message-{$config('~cookie.notification_style')}" : ''?> uk-panel">

            <?= __($config('~cookie.message'), 'yootheme')?>

            <?php if ($config('~cookie.button_consent_style') === 'icon') : ?>
                <button type="button" class="js-accept uk-notification-close uk-close" data-uk-close data-uk-toggle="target: !.uk-notification; animation: uk-animation-fade"></button>
            <?php endif ?>

            <?php if ($config('~cookie.button_consent_style') !== 'icon' || $config('~cookie.mode') === 'consent') : ?>
            <p class="uk-margin-small-top">

                <?php if ($config('~cookie.button_consent_style') !== 'icon') : ?>
                <button type="button" class="js-accept uk-button uk-button-<?= $config('~cookie.button_consent_style') ?>" data-uk-toggle="target: !.uk-notification; animation: uk-animation-fade"><?= __($config('~cookie.button_consent_text'), 'yootheme')?></button>
                <?php endif ?>

                <?php if ($config('~cookie.mode') === 'consent') : ?>
                <button type="button" class="js-reject uk-button uk-button-<?= $config('~cookie.button_reject_style') ?> uk-margin-small-left" data-uk-toggle="target: !.uk-notification; animation: uk-animation-fade"><?= __($config('~cookie.button_reject_text'), 'yootheme')?></button>
                <?php endif ?>

            </p>
            <?php endif ?>

        </div>
    </div>

<?php endif ?>