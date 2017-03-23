<?php

namespace App\Application\User\UpdateUser;

use App\Domain\User\UserId;
use App\Domain\User\User;
use App\Domain\User\UserPassword;
use App\Domain\EmailAddress;
use App\Domain\User\UserRepository;
use App\Application\User\UpdateUser\UpdateUserCommand;
use DateTime;

class UpdateUserTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->userRepository = $this->getMockBuilder(UserRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->updateUser = new UpdateUser($this->userRepository);
    }

    /**
     * Test Updating a new User
     */
    public function testUpdateUser()
    {
        $date = new DateTime();
        $last_log_in = $date->format('Y-m-d H:i:s');
        $email = new EmailAddress('test@test.com');
        $password = UserPassword::create('password');

        $user = User::restore(
            UserId::restore('5aef6312-b908-11e6-8ea1-23d4bf410863'),
            $email,
            $password,
            'Test',
            'Doe',
            $last_log_in
        );

        $this
            ->userRepository
            ->method('findById')
            ->willReturn($user);

        $this
            ->userRepository
            ->expects($this->once())
            ->method('add')
            ->with($this->callback(function ($updated_user) {
                return
                    $updated_user->emailAddress()->get() == 'test22@test.com'
                    && $updated_user->password()->matches('password')
                    && $updated_user->firstName() == 'John'
                    && $updated_user->lastName() == 'Doe';
            })
        );

        $command = new UpdateUserCommand();
        $command->email = 'test22@test.com';
        $command->password = 'password';
        $command->firstName = 'John';
        $command->lastName = 'Doe';

        $this->updateUser->execute($command);
    }

    /**
     * Test that a user is return with the given Id
     */
    public function testCommandFor()
    {
        $user_id = '5aef6312-b908-11e6-8ea1-23d4bf410863';
        $date = new DateTime();
        $last_log_in = $date->format('Y-m-d H:i:s');
        $email = new EmailAddress('test@test.com');
        $password = UserPassword::create('password');

        $user = User::restore(
            UserId::restore('5aef6312-b908-11e6-8ea1-23d4bf410863'),
            $email,
            $password,
            'Test',
            'Doe',
            $last_log_in
        );

        $this
            ->userRepository
            ->method('findById')
            ->willReturn($user);

        $command = $this->updateUser->commandFor($user_id);

        $this->assertEquals($command->email, 'test@test.com');
        $this->assertEquals($command->firstName, 'Test');
        $this->assertEquals($command->lastName, 'Doe');
        $this->assertEquals($command->lastLogin, $last_log_in);
    }
}
