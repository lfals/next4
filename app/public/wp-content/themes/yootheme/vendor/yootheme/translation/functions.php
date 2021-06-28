<?php

namespace YOOtheme;

/**
 * Translates the given message.
 *
 * @param string $id
 * @param array  $parameters
 * @param string $locale
 *
 * @return string
 */
function trans($id, array $parameters = [], $locale = null) {

    $app = Application::getInstance();

    return $app(Translator::class)->trans($id, $parameters, $locale);
}

/**
 * Translates the given choice message by choosing a translation according to a number.
 *
 * @param string      $id         The message id (may also be an object that can be cast to string)
 * @param int         $number     The number to use to find the indice of the message
 * @param array       $parameters An array of parameters for the message
 * @param string|null $locale     The locale or null to use the default
 *
 * @return string The translated string
 */
function transChoice($id, $number, array $parameters = [], $locale = null) {

    $app = Application::getInstance();

    return $app(Translator::class)->trans($id, $number, $parameters, $locale);
}
