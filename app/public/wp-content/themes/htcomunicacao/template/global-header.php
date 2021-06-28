<?php
/** Header do tema. Desktop e mobile */
$logo = ht_get_logo();
$contatos = ht_get_contact();
$social = ht_get_social();
$nav = ht_get_nav();
?>
<div class="ht-header-wrapper">
  <div class="ht-header">
    <div class="ht-header__mobile ht-nav__mobile--js">
      <i class="fas fa-bars ht-header__mobile--menu"></i>
    </div>
    <div class="ht-header__logo">
      <a href="<?php print get_home_url("/"); ?>">
        <?php if(!empty($logo["main"])): ?>
        <img src="<?php print $logo["main"]["url"]; ?>" class="ht-header__logo--image"
          alt="Logo <?php print bloginfo("name"); ?>">
        <?php else: ?>
        <span class="ht-header__logo--text"><?php print bloginfo("name"); ?></span>
        <?php endif; ?>
      </a>
    </div>

    <div class="ht-header__nav">
      <?php if(!empty($nav["nav"])): ?>
      <?php foreach($nav["nav"] as $n): ?>
      <div class="ht-nav__item<?php if(!empty($n["sub_item"])): ?> ht-header__nav--dropdown<?php endif; ?>">

        <? if($n["label"] == 'Login'): ?>
        <div>
          <div class="ht-header__social">
            <?php if(!empty($social)): ?>
            <?php if(!empty($social["facebook"])): ?>
            <a href="<?php print $social["facebook"]; ?>" class="ht-header__social--item">
              <i class="fab fa-facebook-square ht-header__social--icon"></i>
            </a>
            <?php endif; ?>
            <?php if(!empty($social["instagram"])): ?>
            <a href="<?php print $social["instagram"]; ?>" class="ht-header__social--item">
              <i class="fab fa-instagram ht-header__social--icon"></i>
            </a>
            <?php endif; ?>
            <?php if(!empty($social["youtube"])): ?>
            <a href="<?php print $social["instagram"]; ?>" class="ht-header__social--item">
              <i class="fab fa-youtube ht-header__social--icon"></i>
            </a>
            <?php endif; ?>
            <?php endif; ?>
          </div>

          <a href="<?php print $n["url"] ?>" class="ht-nav__label">
            <?php print $n["label"] ?>
          </a>
        </div>
        <? else: ?>
        <a href="<?php print $n["url"] ?>" class="ht-nav__label login">
          <?php print $n["label"] ?>
        </a>
        <? endif; ?>
      </div>
      <?php endforeach; ?>
      <?php endif; ?>
    </div>



    <div class="ht-header__mobile ht-header__mobile--right">
      <i class="fab fa-whatsapp ht-header__mobile--wpp"></i>
    </div>
  </div>
</div>

<div class="ht-header__nav--mobile">
  <div class="ht-nav__control">
    <div class="ht-nav__control--item ht-nav__mobile--js">
      <div class="ht-nav__control--right">
        <i class="fas fa-times ht-nav__control--close"></i>
      </div>
    </div>
    <div class="ht-nav__control--item">
      <?php if(!empty($logo["secound"])): ?>
      <img src="<?php print $logo["secound"]["url"]; ?>" class="ht-header__logo--image"
        alt="Logo <?php print bloginfo("name"); ?>">
      <?php else: ?>
      <span class="ht-header__logo--text"><?php print bloginfo("name"); ?></span>
      <?php endif; ?>
    </div>
    <div class="ht-nav__control--item">
      <div class="ht-nav__control--right">
        <i class="fab fa-whatsapp ht-nav__control--wpp"></i>
      </div>
    </div>
  </div>
  <div class="ht-nav__wrapper--menu">
    <?php if(!empty($nav["nav"])): ?>
    <?php foreach($nav["nav"] as $n): ?>
    <div class="ht-nav__mobile<?php if(!empty($n["sub_item"])): ?> ht-nav__mobile--dropdown<?php endif; ?>">
      <a <?php if(empty($n["sub_item"])): ?>href="<?php print $n["url"] ?>" <?php endif; ?>
        class="ht-nav__mobile--label">
        <?php print $n["label"] ?>
        <?php if(!empty($n["sub_item"])): ?>
        <i class="fas fa-chevron-down ht-nav__mobile--icon"></i>
        <div class="ht-mobile__subitem">
          <?php foreach($n["sub_item"] as $si): ?>
          <a href="<?php print $si["url"] ?>" class="ht-mobile__subitem--item">
            <?php print $si["label"]; ?>
          </a>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </a>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
  </div>
  <div class="ht-social__mobile">
    <?php if(!empty($social)): ?>
    <?php if(!empty($social["facebook"])): ?>
    <a href="<?php print $social["facebook"]; ?>" class="ht-social__mobile--item">
      <i class="fab fa-facebook-square ht-header__social--icon"></i>
    </a>
    <?php endif; ?>
    <?php if(!empty($social["instagram"])): ?>
    <a href="<?php print $social["instagram"]; ?>" class="ht-social__mobile--item">
      <i class="fab fa-instagram ht-header__social--icon"></i>
    </a>
    <?php endif; ?>
    <?php if(!empty($social["youtube"])): ?>
    <a href="<?php print $social["instagram"]; ?>" class="ht-social__mobile--item">
      <i class="fab fa-youtube ht-header__social--icon"></i>
    </a>
    <?php endif; ?>
    <?php endif; ?>
  </div>
  <div class="ht-cta__mobile">

    <?php if(!empty($nav["contact"]["url"])): ?>
    <a href="<?= $nav["contact"]["url"] ?>" class="ht-cta__mobile--botton">
      <?= $nav["contact"]["cta"] ?>
    </a>
    <?php endif; ?>
  </div>
</div>