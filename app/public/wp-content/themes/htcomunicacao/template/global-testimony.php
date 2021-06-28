<?
    $testimonials =  get_field('ht__testimony', 'option');
?>

<div class="ht__testimony-wrapper">
    <h1>Depoimentos</h1>
    <p>Profissionais da Refrigeração aprovam o Pró-Ozônio:</p>
    <div class="ht__testimony-cards-wrapper">
        <? foreach($testimonials as $tes): ?>
            <div class="card">
            <div class="img">
                <? if(!empty($tes['ht__testimony-pp'])): ?>
                    <img src="<? print $tes['ht__testimony-pp'] ?>" alt="">
                <? else: ?>
                    <img src="<? print ht_get_theme_image('image/pph.png') ?>" style="width: 100%;" alt="">
                <? endif; ?>
            </div>
            <div class="info">
                <p class="text">
                    <? print $tes['ht__testimony-text'] ?>
                </p>
                <h1 class="name">
                    <? print $tes['ht__testimony-name'] ?>
                </h1>
                <h1 class="position">
                    <? print $tes['ht__testimony-position'] ?>
                </h1>
                <h1 class="locale">
                    <? print $tes['ht__testimony-locale'] ?>
                </h1>
            </div>
        </div>
        <? endforeach; ?>
    </div>
</div>