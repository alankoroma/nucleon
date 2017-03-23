<?php

namespace App\Application\Auth\LogIn;

use App\Domain\EmailAddress;
use App\Domain\User\User;
use App\Domain\User\UserId;
use App\Domain\User\UserPassword;
use App\Domain\User\UserRepository;
use App\Session\Session;
use DateTime;

class LogInTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->userRepository = $this->getMockBuilder(UserRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->session = $this->getMockBuilder(Session::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->login = new LogIn(
            $this->userRepository,
            $this->session
        );
    }

    /**
     * @expectedException App\Application\Auth\LogIn\IncorrectCredentialsException
     */
    public function testSignInWithIncorrectCredentials()
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
            ->method('findByEmail')
            ->willReturn($user);

        $command = new LogInCommand();
        $command->email = 'test@test.com';
        $command->password = 'Passw0rd';

        $this->login->execute($command);
    }

    public function testSignIn()
    {
        $date = new DateTime();
        $last_log_in = $date->format('Y-m-d H:i:s');

        $user = User::restore(
            UserId::restore('5aef6312-b908-11e6-8ea1-23d4bf410863'),
            new EmailAddress('test@test.com'),
            UserPassword::create('Passw0rd'),
            'Test',
            'Doe',
            $last_log_in
        );

        $this
            ->userRepository
            ->method('findByEmail')
            ->willReturn($user);

        $this
            ->session
            ->expects($this->any())
            ->method('set')
            ->withConsecutive(
                [$this->equalTo('user_id')],
                [$this->equalTo('user_email'), $this->equalTo('test@test.com')]
            );

        $command = new LogInCommand();
        $command->email = 'test@test.com';
        $command->password = 'Passw0rd';

        $this->login->execute($command);
    }
}
