<?php

namespace App\Application\User\RegisterUser;

use App\Domain\EmailAddress;
use App\Domain\Users\User;
use App\Domain\Users\UserPassword;
use App\Domain\Users\UserRepository;

class RegisterUser
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * Creates a new service.
     *
     * @param UserRepository $repository
     */
    function __construct(UserRepository $repository)
    {
        $this->userRepository = $repository;
    }

    /**
     * Attempts to register a new user.
     *
     * @param  RegisterUserCommand $command
     * @throws UserExistsException when email in use
     * @return null
     */
    public function execute(RegisterUserCommand $command)
    {
        $email = new EmailAddress($command->email);

        $user = $this->userRepository->findByEmail($email);

        if ($user) {
            throw new UserExistsException('Email address already in use.');
        }

        $user = User::createWith(
            EmailAddress::create($command->email),
            UserPassword::create($command->password),
            $command->firstName,
            $command->lastName
        );

        $this->userRepository->add($user);
    }
}
