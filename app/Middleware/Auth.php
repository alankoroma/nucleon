<?php

namespace App\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Session\Session;
use App\Application\User\SetupUser\SetupUser;

class Auth
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @var SetupUser
     */
    private $setupUser;

    function __construct(Session $session, SetupUser $setup_user)
    {
        $this->session = $session;
        $this->setupUser = $setup_user;
    }

    public function __invoke(Request $request, Response $response, $next)
    {
        if ($this->session->get('user_id')) {
            $user_id = $this->session->get('user_id');
            $GLOBALS['USER_ID'] = $user_id;
            $request = $request->withAttribute(
                'user',
                $this->setupUser->commandFor($user_id)
            );
        }

        return $next($request, $response);
    }
}
