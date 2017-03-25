<?php

namespace App\Domain;

class EmailAddress
{
    /**
    * @var string
    */
    private $email;

    function __construct($email)
    {
        $this->email = $email;
    }

    /**
    * Creates a new email address.
    *
    * @param  string $email
    * @throw  InvalidArgumentException
    * @return EmailAddress
    */
    public static function create($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('Invalid email address');
        }

        return new static($email);
    }

    /**
    * Returns the email address.
    *
    * @return string
    */
    public function get()
    {
        return $this->email;
    }
}
