<?php

namespace App\Session;

class Session
{
    /**
     * @var array
     */
    private $data;

    /**
     * Creates a new session object.
     *
     * @param array $data
     */
    function __construct($data = [])
    {
        $this->data = $data;
    }

    /**
     * Sets the data associated with a key.
     *
     * @param  string $key
     * @param  mixed  $data
     * @return null
     */
    public function set($key, $data)
    {
        $this->data[$key] = $data;
    }

    /**
     * Returns the data associated with a key, or null if the key does not
     * exist.
     *
     * @param  string $key
     * @return mixed
     */
    public function get($key)
    {
        if (!isset($this->data[$key])) {
            return null;
        }

        return $this->data[$key];
    }

    /**
     * Returns all session data.
     *
     * @return array
     */
    public function data()
    {
        return $this->data;
    }

    /**
     * Clears all session data.
     *
     * @return null
     */
    public function clear()
    {
        $this->data = [];
    }
}
