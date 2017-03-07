<?php

namespace App\Domain\User;

class UserPassword
{
    /**
     * @var string
     */
    private $hash;

    /**
     * Creates a new hashed password from a plaintext string.
     *
     * @param  string $plaintext
     * @return UserPassword
     */
    public static function create($plaintext)
    {
        return new static(password_hash($plaintext, PASSWORD_DEFAULT));
    }

    /**
     * Creates a hashed password from an existing hash.
     *
     * @param  string $hash
     * @return UserPassword
     */
    public static function restore($hash)
    {
        return new static($hash);
    }

    private function __construct($hash)
    {
        $this->hash = $hash;
    }

    /**
     * Returns the password hash.
     *
     * @return string
     */
    public function get()
    {
        return $this->hash;
    }

    /**
     * Returns true if the provided plaintext matches
     * the hashed password.
     *
     * @param  string $plaintext
     * @return bool
     */
    public function matches($plaintext)
    {
        return password_verify($plaintext, $this->hash);
    }
}
