<?php

namespace YOOtheme\Http;

class Exception extends \RuntimeException
{
    /**
     * Constructor.
     *
     * @param int        $code
     * @param string     $message
     * @param \Exception $previous
     */
    public function __construct($code = 0, $message = '', \Exception $previous = null)
    {
        parent::__construct($message ?: (new Response($code))->getReasonPhrase(), $code, $previous);
    }
}
