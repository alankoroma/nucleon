<?php

namespace App\Application\User\UpdateUser;

use App\Domain\EmailAddress;
use App\Domain\User\User;
use App\Domain\User\UserId;
use App\Domain\User\UserPassword;
use App\Domain\User\UserRepository;
use App\Application\DoesNotExistException;

class UpdateUser
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UpdateUser Constructor.
     * @param UserRepository $repository
     */
    function __construct(UserRepository $repository)
    {
        $this->userRepository = $repository;
    }

    /**
     * Execute An Update On A User
     * @param  UpdateUserCommand $command
     */
    public function execute(UpdateUserCommand $command)
    {
        $user = $this->userRepository->findById(
            UserId::restore($command->id)
        );

        if (!$user) {
            throw new DoesNotExistException();
        }

        $user->updateWith($command->firstName, $command->lastName);

        if ($command->password) {
            $updated_password = UserPassword::create($command->password);
            $user->updatePassword($updated_password);
        }

        if ($command->email) {
            $email_address = new EmailAddress($command->email);
            $user->updateEmail($email_address);
        }

        $this->userRepository->add($user);
    }

    /**
    * Returns an UpdateUserCommand prefilled with data for
    * an existing user.
    *
    * @param  string $user_id
    * @return UpdateUserCommand
    */
   public function commandFor($user_id)
   {
       $user = $this->userRepository->findById(
           UserId::restore($user_id)
       );

       if (!$user) {
           throw new DoesNotExistException();
       }

       $command = new UpdateUserCommand;

       $command->email = $user->emailAddress()->get();
       $command->firstName = $user->firstName();
       $command->lastName = $user->lastName();
       $command->lastLogin = $user->lastLogIn();

       return $command;
   }
}
