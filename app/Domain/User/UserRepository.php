<?php

namespace App\Domain\User;

use App\Domain\EmailAddress;

interface UserRepository
{
    public function findById(UserId $id);
    public function findByEmail(EmailAddress $email);
    public function findAll();
    public function add(User $user);
    public function remove (User $user);
}
