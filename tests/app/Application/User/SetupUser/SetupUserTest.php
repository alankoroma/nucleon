<?php

namespace App\Application\User\SetupUser;

use App\Domain\User\UserRepository;
use App\Application\User\SetupUser\SetupUserCommand;
use App\Domain\User\User;
use App\Domain\User\UserId;
use App\Domain\User\UserPassword;
use App\Domain\EmailAddress;
use DateTime;

class SetupUserTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        // Mock UserRepository
        $this->userRepository = $this->getMockBuilder(UserRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        // Setup user with the above Repository
        $this->setupUser = new SetupUser($this->userRepository);
    }

    /**
     * Test that all users are returned
     */
    public function testSetup()
    {
        $user_array = array();

        $date = new DateTime();
        $last_log_in = $date->format('Y-m-d H:i:s');

        $user_1 = User::restore(
            UserId::restore('5aef6312-b908-11e6-8ea1-23d4bf410863'),
            new EmailAddress('test@test.com'),
            UserPassword::create('password'),
            'John',
            'Doe',
            $last_log_in
        );

        $user_array[] = $user_1;

        $user_2 = User::restore(
            UserId::restore('9980a784-d56f-11e6-9c71-6465cfdff016'),
            new EmailAddress('test2@test.com'),
            UserPassword::create('somepassword'),
            'Susan',
            'Doe',
            $last_log_in
        );

        $user_array[] = $user_2;

        $this
            ->userRepository
            ->method('findAll')
            ->willReturn($user_array);

        $users = $this->setupUser->setup();

        $command_array = array();

        foreach ($users as $user) {
            $command_array[$user->firstName] = $user;
        }

        $this->assertEquals($command_array['John']->email, 'test@test.com');
        $this->assertEquals($command_array['John']->firstName, 'John');
        $this->assertEquals($command_array['John']->lastName, 'Doe');
        $this->assertEquals($command_array['John']->lastLogin, $last_log_in);

        $this->assertEquals($command_array['Susan']->email, 'test2@test.com');
        $this->assertEquals($command_array['Susan']->firstName, 'Susan');
        $this->assertEquals($command_array['Susan']->lastName, 'Doe');
        $this->assertEquals($command_array['Susan']->lastLogin, $last_log_in);
    }

    /**
     * Test that a user is return when an ID is given
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

        $command = $this->setupUser->commandFor($user_id);

        $this->assertEquals($command->email, 'test@test.com');
        $this->assertEquals($command->firstName, 'Test');
        $this->assertEquals($command->lastName, 'Doe');
        $this->assertEquals($command->lastLogin, $last_log_in);
    }
}
