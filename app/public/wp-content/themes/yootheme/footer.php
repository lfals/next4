<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */

namespace YOOtheme;

list($config, $view) = app(Config::class, View::class);

?>
        <?php if (!$config('app.isBuilder')) : ?>

                        <?php if (is_active_sidebar('sidebar')) : ?>
                        </div>

                        <?= $view('~theme/templates/sidebar') ?>

                    </div>
                     <?php endif ?>

                </div>
            </div>
            <?php endif ?>

            <?php dynamic_sidebar("bottom:section") ?>

            <?= $view->builder(json_encode($config('~theme.footer.content')), ['prefix' => 'footer']) ?>

        </div>

        <?php if ($config('~site.layout') == 'boxed') : ?>
        </div>
        <?php endif ?>

        <?php wp_footer() ?>
    </body>
</html>
