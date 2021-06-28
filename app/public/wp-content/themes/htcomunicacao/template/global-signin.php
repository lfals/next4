<?
    $sliders = get_field('ht__slider-group');
?>
<div class="ht__slider-wrapper">
   <? foreach($sliders as $slider): ?>

    <div class="ht_slider" style="background-image: url(<? print $slider['ht__slider']['ht__img'] ?>); 
    background-position: center;
">
            <h1>
                <? print $slider['ht__slider']['ht_text'] ?>
            </h1>
            <? if(!empty($slider['ht__slider']['ht__cta'])): ?>
                <a href="<? print $slider['ht__slider']['ht__cta']['ht__cta-link'] ?>">
                    <? print $slider['ht__slider']['ht__cta']['ht__cta-text'] ?>
                </a>
            <? endif; ?>
        </div>
   <? endforeach; ?>
</div>