<?php

namespace YOOtheme;

interface Translator
{
    /**
     * Returns the current locale.
     *
     * @return string
     */
    public function getLocale();

    /**
     * Sets the current locale.
     *
     * @param string $locale
     */
    public function setLocale($locale);

    /**
     * Gets all Resources.
     *
     * @return array
     */
    public function getResources();

    /**
     * Adds a Resource.
     *
     * @param mixed  $resource
     * @param string $locale
     *
     * @return $this
     */
    public function addResource($resource, $locale = null);

    /**
     * Translates the given message.
     *
     * @param string $id
     * @param array  $parameters
     * @param string $locale
     *
     * @return string
     */
    public function trans($id, array $parameters = [], $locale = null);

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
    public function transChoice($id, $number, array $parameters = [], $locale = null);
}
