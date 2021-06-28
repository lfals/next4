<?php

namespace YOOtheme;

use YOOtheme\Http\Request;
use YOOtheme\Http\Response;

class CsrfMiddleware
{
    /**
     * Current token.
     *
     * @var string
     */
    protected $token;

    /**
     * Verify callable.
     *
     * @var callable
     */
    protected $verify;

    /**
     * Constructor.
     *
     * @param string   $token
     * @param callable $verify
     */
    public function __construct($token, callable $verify = null)
    {
        $this->token = $token;
        $this->verify = $verify ?: [$this, 'verify'];
    }

    /**
     * Handles CSRF token from request.
     *
     * @param Request  $request
     * @param callable $next
     *
     * @return Response
     */
    public function handle($request, callable $next)
    {
        $csrf = $request->getAttribute('csrf', $request->isMethod('POST'));

        if ($csrf && !call_user_func($this->verify, $request->getHeaderLine('X-XSRF-Token'))) {
            $request->abort(401, 'Invalid CSRF token.');
        }

        return $next($request);
    }

    /**
     * Verifies a CSRF token.
     *
     * @param string $token
     *
     * @return bool
     */
    public function verify($token)
    {
        return $this->token === $token;
    }
}
