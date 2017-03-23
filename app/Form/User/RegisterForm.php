<?php

namespace App\Form\User;

use App\Form\Form;

class RegisterForm extends Form
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
            'first_name' => 'firstName',
            'last_name' => 'lastName',
            'email' => 'email',
            'password' => 'password',
            'password_confirm' => 'password_confirm'
        );
    }

    protected function messages()
    {
        // If Empty Fields
        return array(
            'first_name.empty' => 'First Name is required.',
            'last_name.empty' => 'Last Name is required.',
            'email.empty' => 'Email is a required field.',
            'password.empty' => 'Password is a required field.',
            'password_confirm.empty' => 'Password Confirm is a required field.',
            'password_confirm.match' => 'Password fields must match.'
        );
    }

    protected function run()
    {
        $password = $this->get('password');
        $password_confirm = $this->get('password_confirm');

        if ($this->isEmpty('first_name')) {
            $this->addError('first_name', 'empty');
        }

        if ($this->isEmpty('last_name')) {
            $this->addError('last_name', 'empty');
        }

        if ($this->isEmpty('email')) {
            $this->addError('email', 'empty');
        }

        if ($this->isEmpty('password')) {
            $this->addError('password', 'empty');
        }

        if ($this->isEmpty('password_confirm')) {
            $this->addError('password_confirm', 'empty');
        }

        if (!empty($password) && $password_confirm != $password) {
            $this->addError('password_confirm', 'match');
        }
    }
    
    public function setCommandClass($class)
    {
        $this->commandClass = $class;
    }
}
