<?php

namespace App\Domain\Users;

use App\Domain\User\User;
use App\Domain\User\UserId;
use App\Domain\User\UserPassword;
use App\Domain\EmailAddress;
use DateTime;
use DateTimeZone;

class UserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test Creating A New User
     */
    public function testCreateUser()
    {
        $user = User::createWith(
            EmailAddress::create('test@test.com'),
            UserPassword::create('password'),
            'Alan',
            'Test'
        );

        $this->assertEquals('test@test.com', $user->emailAddress()->get());
        $this->assertTrue($user->password()->matches('password'));
        $this->assertEquals('Alan', $user->firstName());
        $this->assertEquals('Test', $user->lastName());
    }

    /**
     * Test Restoring A User
     */
    public function testRestore()
    {
        $date = new DateTime();
        $login_date = $date->format('Y-m-d H:i:s');
        $email = new EmailAddress('test2@test.com');
        $password = UserPassword::create('password');

        $user = User::restore(
            UserId::restore('1583c0e4-aef8-11e6-b6ea-d03492418d01'),
            $email,
            $password,
            'John',
            'Smith',
            $login_date
        );

        $user->updateLogin($login_date);

        $this->assertEquals('1583c0e4-aef8-11e6-b6ea-d03492418d01', $user->id()->get());
        $this->assertEquals('test2@test.com', $user->emailAddress()->get());
        $this->assertTrue($user->password()->matches('password'));
        $this->assertEquals('John', $user->firstName());
        $this->assertEquals('Smith', $user->lastName());
        $this->assertEquals($login_date, $user->lastLogin());
    }

    /**
     * Test Updating A User
     */
    public function testUpdate()
    {
        $date = new DateTime();
        $login_date = $date->format('Y-m-d H:i:s');
        $email = new EmailAddress('test2@test.com');
        $password = UserPassword::create('password');
        $updated_password = UserPassword::create('password01');

        $user = User::restore(
            UserId::restore('1583c0e4-aef8-11e6-b6ea-d03492418d01'),
            $email,
            $password,
            'John',
            'Smith',
            $login_date
        );

        $user->updateLogin($login_date);
        $user->updateWith('Jane', 'Doe');
        $user->updatePassword($updated_password);

        $this->assertEquals('1583c0e4-aef8-11e6-b6ea-d03492418d01', $user->id()->get());
        $this->assertEquals('test2@test.com', $user->emailAddress()->get());
        $this->assertTrue($user->password()->matches('password01'));
        $this->assertEquals('Jane', $user->firstName());
        $this->assertEquals('Doe', $user->lastName());
        $this->assertEquals($login_date, $user->lastLogin());
    }

    /**
     * Test Authenticating A User
     */
     public function testAuthenticatesWith()
     {
        $date = new DateTime();
        $login_date = $date->format('Y-m-d H:i:s');
        $email = new EmailAddress('test2@test.com');
        $password = UserPassword::create('password');

        $user = User::restore(
            UserId::restore('1583c0e4-aef8-11e6-b6ea-d03492418d01'),
            $email,
            $password,
            'John',
            'Smith',
            $login_date
        );

        $this->assertTrue($user->authenticatesWith('password'));
     }
}
