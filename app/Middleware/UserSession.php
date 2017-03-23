<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Dflydev\FigCookies\FigRequestCookies;
use Dflydev\FigCookies\FigResponseCookies;
use Dflydev\FigCookies\SetCookie;
use App\Session\Session;
use App\Session\SessionStorage;

/**
 * Session middleware.
 */
class UserSession
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @var SessionStorage
     */
    private $storage;

    /**
     * @var string
     */
    private $key;

    function __construct(Session $session, SessionStorage $storage, $key)
    {
        $this->session = $session;
        $this->storage = $storage;
        $this->key = $key;
    }

    protected function generateSessionId()
    {
        return bin2hex(openssl_random_pseudo_bytes(16));
    }

    public function __invoke(Request $request, Response $response, $next)
    {
        /* Get an exiting session ID */
        $session_cookie = FigRequestCookies::get($request, $this->key);

        if (!empty($session_cookie->getValue())) {
            $session = $this->storage->read($session_cookie->getValue());

            /* Load session data from storage */
            foreach ($session->data() as $key => $value) {
                $this->session->set($key, $value);
            }
        }

        /* Run application */
        $response = $next($request, $response);

        if (empty($this->session->data())) {
            /* Expire the current session and clear the storage */
            if (!empty($session_cookie->getValue())) {
                $this->storage->remove($session_cookie->getValue());
                $GLOBALS['USER_ID'] = '';
                $response = FigResponseCookies::expire($response, $this->key);
            }
        } else {
            if (!empty($session_cookie->getValue())) {
                $this->storage->write($session_cookie->getValue(), $this->session);
            } else {
                $session_id = $this->generateSessionId();
                $response = FigResponseCookies::set($response, SetCookie::create($this->key)
                    ->withValue($session_id)
                    ->withExpires(time() + 3600)
                    ->withPath('/')
                );
                $this->storage->write($session_id, $this->session);
            }
        }

        return $response;
    }
}
