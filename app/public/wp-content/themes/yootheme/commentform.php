<?php

$user = wp_get_current_user();
$user_identity = $user->exists() ? $user->display_name : '';
$commenter = wp_get_current_commenter();

$req = get_option('require_name_email');
$req_attr = $req ? ' required aria-required="true"' : '';
$req_text = sprintf(' ' . __('Required fields are marked %s'), '<span class="required">*</span>');
$consent = empty($commenter['comment_author_email']) ? '' : ' checked="checked"';

comment_form([

    'class_form' => 'uk-form-stacked comment-form',

    'class_submit' => 'uk-button uk-button-primary submit',

    'submit_button' => '<button id="%2$s" class="%3$s" name="%1$s">%4$s</button>',

    'title_reply_before' => '<h3 id="reply-title" class="uk-h4 uk-margin-medium-top comment-reply-title">',

    'cancel_reply_before' => ' <small>',

    'cancel_reply_after' => '</small>',

    'comment_field' => '<p class="comment-form-comment"><label class="uk-form-label" for="comment">' . _x('Comment', 'noun', 'yootheme') . '</label><textarea class="uk-textarea" id="comment" name="comment" cols="45" rows="8" required aria-required="true">' . '</textarea></p>',

    'comment_notes_before' => '<p class="comment-notes">' . __('Your email address will not be published.') . ($req ? $req_text : '') . '</p>',

    'must_log_in' => '<p class="must-log-in">' . sprintf(__('You must be <a href="%s">logged in</a> to post a comment.'), wp_login_url(apply_filters('the_permalink', get_permalink()))) . '</p>',

    'logged_in_as' => '<p class="logged-in-as">' . sprintf(__('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'yootheme'), admin_url('profile.php'), $user_identity, wp_logout_url(apply_filters('the_permalink', get_permalink()))) . '</p>',

    'fields' => [

        'author' => '<p class="comment-form-author"><label class="uk-form-label" for="author">' . __('Name') . ($req ? ' <span class="required">*</span>' : '') . '</label><input class="uk-input" id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $req_attr . ' /></p>',

        'email' => '<p class="comment-form-email"><label class="uk-form-label" for="email">' . __('Email') . ($req ? ' <span class="required">*</span>' : '') . '</label><input class="uk-input" id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $req_attr . ' /></p>',

        'url' => '<p class="comment-form-url"><label class="uk-form-label" for="url">' . __('Website') . '</label><input class="uk-input" id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" /></p>',

        'cookies' => '<p class="comment-form-cookies-consent"><label class="uk-form-label"><input class="uk-checkbox" id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' /> ' . __('Save my name, email, and website in this browser for the next time I comment.') . '</label></p>',

    ],

]);
