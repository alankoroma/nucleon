<?php

namespace App\Application\User\RegisterUser;

use App\Domain\Users\UserId;
use App\Domain\Users\User;
use App\Domain\Users\UserPassword;
use App\Domain\EmailAddress;
use App\Domain\User\UserRepository;
use App\Application\User\RegisterUser\RegisterUserCommand;

class RegisterUserTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        // Mock UserRepository
        $this->userRepository = $this->getMockBuilder(UserRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        // Register a user with the above Repository
        $this->registerUser = new RegisterUser($this->userRepository);
    }

    /**
     * Test Registering a new User
     */
    public function testRegisterUser()
    {
        $this
            ->userRepository
            ->method('findByEmail')
            ->willReturn(null);

        $this
            ->userRepository
            ->expects($this->once())
            ->method('add')
            ->with($this->callback(function ($user) {
                return
                    $user->emailAddress()->get() == 'test@test.com'
                    && $user->password()->matches('password')
                    && $user->firstName() == 'John'
                    && $user->lastName() == 'Doe';
            })
        );

        $command = new RegisterUserCommand();
        $command->email = 'test@test.com';
        $command->password = 'password';
        $command->firstName = 'John';
        $command->lastName = 'Doe';

        $this->registerUser->execute($command);
    }

}
