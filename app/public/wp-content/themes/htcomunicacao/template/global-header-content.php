<?
    $headerInfo = get_field('ht__header');

?>

<div class="ht__header-content" style="background-image: url(<? print ht_get_theme_image('image/bg.png') ?>);     background-position: center;
    background-size: cover;">
    <div class="info">
        <div class="text">
            <h1><? print $headerInfo['ht__title'] ?></h1>
            <p><? print $headerInfo['ht__text'] ?></p>
            <a href="<? print $headerInfo['ht__cta']['ht__link'] ?>"><? print $headerInfo['ht__cta']['ht__text'] ?></a>
        </div>
        <img src="<? print $headerInfo['ht__img'] ?>" alt="">

    </div>
    <div class="details">

    </div>
</div>