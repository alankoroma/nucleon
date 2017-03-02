<?php

namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class BaseController
{
    /**
     * @var ServerRequestInterface
     */
    protected $request;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var array
     */
    protected $segments;

    /**
     * Handles a HTTP request and delegates to either the
     * HTTP verb method, or 'handle' if such a method does
     * not exist.
     *
     * @param  ServerRequestInterface $request
     * @param  ResponseInterface      $response
     * @return ResponseInterface      $response
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface      $response,
        $segments = []
    ) {

        $this->request = $request;
        $this->response = $response;
        $this->segments = $segments;

        $method = strtolower($request->getMethod());

        if (method_exists($this, $method)) {
            return call_user_func([$this, $method]);
        }

        if (method_exists($this, 'handle')) {
            return $this->handle();
        }
        
        /* Fall back to doing nothing */
        return $this->response;
    }
}
