<?php

namespace App\Domain\User;

use App\Domain\EmailAddress;

class User
{
    /**
     * @var EntityId
     */
    private $id;

    /**
     * @var EmailAddress
     */
    private $emailAddress;

    /**
     * @var UserPassword
     */
    private $password;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $lastLogIn;

    /**
     * Get A User's Id
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * Get A User's Email Address
     * @return string
     */
    public function emailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * Returns the user's password hash.
     *
     * @return UserPassword
     */
    public function password()
    {
        return $this->password;
    }

    /**
     * Get A User's First Name
     * @return string
     */
    public function firstName()
    {
        return $this->firstName;
    }

    /**
     * Get A User's Last Name
     * @return string
     */
    public function lastName()
    {
        return $this->lastName;
    }

    /**
     * Get A User's Last Login Date
     * @return string
     */
    public function lastLogIn()
    {
        return $this->lastLogIn;
    }

    /**
     * Create A New User
     * @param EmailAddress $email_address
     * @param UserPassword $password
     * @param string       $first_name
     * @param string       $last_name
     */
    public static function createWith(
        EmailAddress $email_address,
        UserPassword $password,
        $first_name,
        $last_name
    ) {
        $user = new static();

        $user->id = UserId::create();
        $user->emailAddress = $email_address;
        $user->password = $password;
        $user->firstName = $first_name;
        $user->lastName = $last_name;

        return $user;
    }

    /**
     * Restore A User
     * @param UserId       $id
     * @param EmailAddress $email_address
     * @param UserPassword $password
     * @param string       $first_name
     * @param string       $last_name
     */
    public static function restore(
        UserId $id,
        EmailAddress $email_address,
        UserPassword $password,
        $first_name,
        $last_name,
        $last_log_in
    ) {
        $user = new static();

        $user->id = $id;
        $user->emailAddress = $email_address;
        $user->password = $password;
        $user->firstName = $first_name;
        $user->lastName = $last_name;
        $user->lastLogIn = $last_log_in;

        return $user;
    }

    /**
     * Update User
     * @param  $first_name
     * @param  $last_name
     */
    public function updateWith($first_name, $last_name)
    {
        $this->firstName = $first_name;
        $this->lastName = $last_name;
    }

    /**
     * Update Password
     * @param  UserPassword $password
     */
    public function updatePassword(UserPassword $password)
    {
        $this->password = $password;
    }

    /**
     * Update Email Address
     * @param  EmailAddress $email_address
     */
    public function updateEmail(EmailAddress $email_address)
    {
        $this->emailAddress = $email_address;
    }

    /**
     * Update User's Last Login
     * @param $last_log_in
     */
    public function updateLogin($last_log_in)
    {
        $this->lastLogIn = $last_log_in;
    }

    /**
     * Returns true if the provided password matches the user's
     * hashed password.
     *
     * @param  string $plaintext
     * @return bool
     */
    public function authenticatesWith($plaintext)
    {
        return $this->password->matches($plaintext);
    }
}
