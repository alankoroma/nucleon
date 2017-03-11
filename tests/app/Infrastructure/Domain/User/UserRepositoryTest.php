<?php

namespace App\Infrastructure\Domain\User;

use App\Domain\User\User;
use App\Domain\User\UserId;
use App\Domain\User\UserPassword;
use App\Domain\User\UserRepository;
use App\Domain\EmailAddress;
use App\Infrastructure\Database\DatabaseDriver;
use DateTime;

class UserRepositoryTest extends \Database_TestCase
{
    public function getDataSet()
    {
        return $this->createXmlDataSet(__DIR__ . '/UserData.xml');
    }

    public function setUp()
    {
        $this->db = self::$db;

        $this->userRepository = new DbUserRepository(
            $this->db
        );

        parent::setUp();
    }

    public function tearDown()
    {
        $this->db = null;
    }

    public function testFindById()
    {
        // return a User
        $user = $this->userRepository->findById(
          UserId::restore('5aef6312-b908-11e6-8ea1-23d4bf410863')
        );

        // Test Assertion
        $this->assertEquals('5aef6312-b908-11e6-8ea1-23d4bf410863', $user->id()->get());
        $this->assertEquals('John', $user->firstName());
        $this->assertTrue($user->password()->matches('password'));
        $this->assertEquals('johndoe@email.com', $user->emailAddress()->get());
    }

    public function testFindByEmail()
    {
        $email = new EmailAddress('johndoe@email.com');

        // return a User
        $user = $this->userRepository->findByEmail($email);

        // Test Assertion
        $this->assertEquals('5aef6312-b908-11e6-8ea1-23d4bf410863', $user->id()->get());
        $this->assertEquals('John', $user->firstName());
        $this->assertTrue($user->password()->matches('password'));
        $this->assertEquals('johndoe@email.com', $user->emailAddress()->get());
    }

    public function testAdd()
    {
        $newUser = User::createWith(
            EmailAddress::create('myemail@test.com'),
            UserPassword::create('password'),
            'Alan',
            'Test'
        );

        $this->userRepository->add($newUser);

        $user = $this->userRepository->findById(
            $newUser->id()
        );

        // Test Assertion
        $this->assertEquals($newUser->id()->get(), $user->id()->get());
        $this->assertTrue($user->password()->matches('password'));
        $this->assertEquals('Alan', $user->firstName());
        $this->assertEquals('Test', $user->lastName());
        $this->assertEquals('myemail@test.com', $user->emailAddress()->get());
    }

    public function testUpdate()
    {
        $date = new DateTime();
        $login_date = $date->format('Y-m-d H:i:s');
        $email = new EmailAddress('test2@test.com');
        $password = UserPassword::create('password');
        $updated_password = UserPassword::create('password02');

        $user = $this->userRepository->findById(
            UserId::restore('5aef6312-b908-11e6-8ea1-23d4bf410863')
        );

        $user->updateLogin($login_date);
        $user->updatePassword($updated_password);
        $user->updateWith('Janet', 'Door');

        $this->userRepository->add($user);

        $updated_user = $this->userRepository->findById(
            $user->id()
        );

        $this->assertEquals(
            '5aef6312-b908-11e6-8ea1-23d4bf410863',
            $updated_user->id()->get()
        );
        $this->assertEquals(
            'johndoe@email.com',
            $updated_user->emailAddress()->get()
        );
        $this->assertEquals('Janet', $updated_user->firstName());
        $this->assertEquals('Door', $updated_user->lastName());
        $this->assertTrue($user->password()->matches('password02'));
        $this->assertEquals($login_date, $updated_user->lastLogin());
    }

    public function testRemove()
    {
        // return a User
        $user = $this->userRepository->findById(
          UserId::restore('5aef6312-b908-11e6-8ea1-23d4bf410863')
        );

        $this->userRepository->remove($user);

        $removed_user = $this->userRepository->findById(
            $user->id()
        );

        $this->assertNull($removed_user);
    }
}
