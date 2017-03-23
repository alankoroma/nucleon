<?php

namespace App\Form\Auth;

use App\Form\Form;

class LogInForm extends Form
{
    /**
     * @var
     */
    private $commandClass;

    protected function transferObject()
    {
        return new $this->commandClass;
    }

    protected function map()
    {
        return array(
            'email' => 'email',
            'password' => 'password'
        );
    }

    protected function messages()
    {
        // If Empty Fields
        return array(
            'email.empty' => 'Email is a required field.',
            'password.empty' => 'Password is a required field.'
        );
    }

    protected function run()
    {
        if ($this->isEmpty('email')) {
            $this->addError('email', 'empty');
        }

        if ($this->isEmpty('password')) {
            $this->addError('password', 'empty');
        }
    }

    public function setCommandClass($class)
    {
        $this->commandClass = $class;
    }
}
