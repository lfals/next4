<?
    $frstAbout = get_field('ht__frts-about-div');
    $scndAbout = get_field('ht__scnd-about-div');
    $i = 0;
?>

<div class="ht__about-wrapper">
    <div class="about-cta">
        <img src="<? print $frstAbout['ht__image'] ?>" alt="">
        <div class="cta">
            <h1><? print $frstAbout['ht__title'] ?></h1>
            <p><? print $frstAbout['ht__text'] ?></p>
            <a href="<? print $frstAbout['ht__cta'] ?>">
                <? print $frstAbout['ht__cta'] ?>
            </a>
        </div>
    </div>
</div>

<div class="ht__second-about">
    <div class="about-area">
        <h1><? print $scndAbout['ht__title'] ?></h1>
        <p><? print $scndAbout['ht__subtitle'] ?></p>
        <div class="collapse">
           <? foreach($scndAbout['ht__cards'] as $card): ?>
                <? if(!empty($card['ht__title'])):?>
                    <? $i = $i + 1 ;?>
                    <button type="button" class="collapsible"><? print $i ?>. <? print $card['ht__title'] ?></button>
                    <div class="content">
                        <p><? print $card['ht__text'] ?></p>
                    </div>
                <? endif; ?>
            <?endforeach;?>
        </div> 
    </div>
    <img src="<? print $scndAbout['ht__image'] ?>" alt="">
</div>
