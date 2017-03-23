<?php

namespace App\Application\User\SetupUser;

use App\Domain\EmailAddress;
use App\Domain\Users\User;
use App\Domain\Users\UserId;
use App\Domain\Users\UserPassword;
use App\Domain\Users\UserRepository;
use App\Application\DoesNotExistException;
use DateTime;

class SetupUser
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
     * Returns an SetupUserCommand prefilled with data from
     * all users.
     *
     * @return array $users_array
     */
    public function setup()
    {
        $users = $this->userRepository->findAll();

        if (!$users) {
            throw new DoesNotExistException();
        }

        $users_array = array();

        foreach ($users as $user) {

            $command = new SetupUserCommand;

            $command->email = $user->emailAddress()->get();
            $command->firstName = $user->firstName();
            $command->lastName = $user->lastName();
            $command->lastLogin = $user->lastLogIn();

            $users_array[] = $command;
        }

        return $users_array;
    }

    /**
    * Returns an SetupUserCommand prefilled with data from
    * an existing user.
    *
    * @param  string $user_id
    * @return SetupUserCommand
    */
   public function commandFor($user_id)
   {
       $user = $this->userRepository->findById(
           UserId::restore($user_id)
       );

       if (!$user) {
           throw new DoesNotExistException();
       }

       $command = new SetupUserCommand;

       $command->id = $user->id()->get();
       $command->email = $user->emailAddress()->get();
       $command->firstName = $user->firstName();
       $command->lastName = $user->lastName();

       if ($user->lastLogIn() == '0000-00-00 00:00:00') {
           $command->lastLogin = null;
       } else {
           $date = new DateTime($user->lastLogIn());
           $logout_date = $date->format('l jS F Y \a\t H:i');
           $command->lastLogin = $logout_date;
       }

       return $command;
   }
}
