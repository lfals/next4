<div class="uk-margin-medium">

    <?php if ($page < $numpages) : ?>
        <div class="uk-text-default">
            <?= str_replace('post-page-numbers', 'post-page-numbers uk-button uk-button-secondary', _wp_link_page($page + 1)) ?>
            <?= __('Next Page', 'yootheme') ?>
            </a>
        </div>
    <?php endif ?>

    <div class="uk-grid-small uk-flex-middle uk-child-width-auto uk-text-default uk-margin-top" uk-grid>
        <div>
            <?= __('Page', 'yootheme') ?>
        </div>
        <div>

            <ul class="uk-pagination">
                <?php for ( $i = 1; $i <= $numpages; $i++ ) : ?>
                    <?php if ($i != $page || ! $more && 1 == $page) : ?>
                        <li><?= _wp_link_page($i) . $i ?></a></li>
                    <?php else : ?>
                        <li class="uk-active"><span><?= $i ?></span></li>
                    <?php endif ?>
                <?php endfor ?>
            </ul>

        </div>
    </div>

</div>