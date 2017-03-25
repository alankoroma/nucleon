<?php

namespace App\Controller\Auth;

use App\Controller\WebController;
use App\Application\Auth\LogOut\LogOut;
use App\Application\Auth\LogOut\LogOutCommand;

class LogoutController extends WebController
{
    /**
     * @var Logout
     */
    private $logOut;

    /**
     * Creates a new Logout in controller.
     *
     * @param Logout $log_out
     */
    function __construct(Logout $log_out)
    {
        $this->logOut = $log_out;
    }

    public function get()
    {
        $user = $this->request->getAttribute('user');

        $command = new LogOutCommand();

        if ($user) {
            $command = new LogOutCommand();
            $command->id = $user->id;
        }

        $this->logOut->execute($command);

        return $this
            ->response
            ->withStatus(302)
            ->withHeader('Location', SITE_PATH);
    }

}
