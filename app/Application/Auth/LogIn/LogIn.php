<?php

namespace App\Application\Auth\LogIn;

use App\Domain\EmailAddress;
use App\Domain\User\UserRepository;
use App\Session\Session;

class LogIn
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var Session
     */
    private $session;

    /**
     * LogIn Constructor.
     * @param UserRepository $repository
     * @param Session        $session
     */
    function __construct(UserRepository $repository, Session $session)
    {
        $this->userRepository = $repository;
        $this->session = $session;
    }

    /**
     * Signs a user into the application.
     *
     * @param  SignInCommand $command
     * @throws IncorrectCredentialsException
     */
    public function execute(LogInCommand $command)
    {
        $email = new EmailAddress($command->email);

        $user = $this->userRepository->findByEmail($email);

        if ($user) {

            if ($user->authenticatesWith($command->password)) {
                $this->session->set('user_id', $user->id()->get());
                $this->session->set('user_email', $user->emailAddress()->get());

                return;
            }
        }

        throw new IncorrectCredentialsException();
    }
}
