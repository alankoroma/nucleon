<?php

namespace App\Application\Auth\LogOut;

use App\Session\Session;
use App\Domain\User\User;
use App\Domain\User\UserId;
use App\Domain\User\UserRepository;
use DateTime;

class LogOut
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * LogOut Constructor.
     * @param Session        $session
     * @param UserRepository $repository
     */
    function __construct(Session $session, UserRepository $repository)
    {
        $this->session = $session;
        $this->userRepository = $repository;
    }

    /**
     * Signs a user out of the application.
     */
    public function execute(LogOutCommand $command)
    {
        if ($command->id) {

            $user = $this->userRepository->findById(
                UserId::restore($command->id)
            );

            $date = new DateTime();
            $logout_date = $date->format('Y-m-d H:i:s');
            $user->updateLogin($logout_date);

            $this->userRepository->add($user);
        }

        $this->session->clear();
    }
}
