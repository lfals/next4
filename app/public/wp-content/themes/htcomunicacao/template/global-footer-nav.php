<?

$nav = ht_get_nav();
$img = get_field('ht-footer_content', 'option');
?>

<div class="ht-footer__nav">
    <div>
        <div class="footer__nav-menu">
            <p>Menu</p>
            <?php if(!empty($nav["nav"])): ?>
                <?php foreach($nav["nav"] as $n): ?>
                    <a href="<?php print $n["url"] ?>" class="ht-footer__label">
                        <?php print $n["label"] ?>
                    </a>
                <? endforeach; ?>
            <? endif; ?>
        </div>
        <div class="patrocinadores">
            <div class="agencia">
                <p>Agência Implementadora:</p>
                <a href="#">
                    <img src="<? print $img['ht__agency']; ?>" alt="">
                </a>
            </div>
            <div class="agencia">
                <p>Coordenação:</p>
                <a href="#">
                    <img src="<? print $img['ht__coord']; ?>" alt="">
                </a>
            </div>
        </div>
    </div>
    <h1>2021@Todos os Direitos Reservados</h1>
</div>