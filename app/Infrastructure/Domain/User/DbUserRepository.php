<?php

namespace App\Infrastructure\Domain\User;

use App\Domain\EmailAddress;
use App\Domain\User\UserId;
use App\Domain\User\User;
use App\Domain\User\UserPassword;
use App\Domain\User\UserRepository;
use App\Infrastructure\Database\DatabaseDriver;

class DbUserRepository implements UserRepository
{
    /**
    * @var MySQLDatabase
    */
    private $db;

    /**
    * Creates a new User repository Constructor
    *
    * @param DatabaseDriver $db
    */
    function __construct(DatabaseDriver $db)
    {
        $this->db = $db->getDatabase();
    }

    /**
    * Returns the array representation of a User
    * object suitable for use with the database.
    *
    * @param  User $book
    * @return array
    */
    private static function serialize(User $user)
    {
        return array(
            'id' => $user->id()->get(),
            'user_email' => $user->emailAddress()->get(),
            'user_password' => $user->password()->get(),
            'user_firstname' => $user->firstName(),
            'user_lastname' => $user->lastName(),
            'last_login' => $user->lastLogIn()
        );
    }

    /**
    * Returns a User object populated with data from
    * a serialized array.
    *
    * @param  array $arr
    * @return User
    */
    private function deserialize(array $arr)
    {
        return User::restore(
            UserId::restore($arr['id']),
            EmailAddress::create($arr['user_email']),
            UserPassword::restore($arr['user_password']),
            $arr['user_firstname'],
            $arr['user_lastname'],
            $arr['last_login']
        );
    }

    public function findById(UserId $id)
    {
        $data = $this->db->queryFirst('
            SELECT  *
            FROM    users
            WHERE   id = :id AND
            deleted IS NULL
            ', array(':id' => $id->get())
        );

        if (!$data) {
            return null;
        }

        return self::deserialize($data);
    }

    public function findByEmail(EmailAddress $email)
    {
        $data = $this->db->queryFirst('
            SELECT  *
            FROM    users
            WHERE   user_email = :email AND
            deleted IS NULL
            ', array(':email' => $email->get())
        );

        if (!$data) {
            return null;
        }

        return self::deserialize($data);
    }

    public function findAll()
    {
        $data = $this->db->queryAll('
        SELECT  *
        FROM    users
        WHERE   deleted IS NULL
        ');
        $users = array();
        foreach ($data as $arr) {
            $users[] = self::deserialize($arr);
        }

        return $users;
    }

    public function add(User $user)
    {
        $original = $this->findById($user->id());
        $arr = self::serialize($user);

        if ($original) {
            $arr['modified_user_id'] = '0000';
            $arr['date_modified'] = gmdate('Y-m-d H:i:s');
            $this->db->update(
                'users',
                array(
                    'id' => $user->id()->get()
                ),
                $arr
            );
        } else {

            $arr['created_by'] = '0000';
            $arr['date_entered'] = gmdate('Y-m-d H:i:s');
            $this->db->insert('users', $arr);
        }
    }

    public function remove(User $user)
    {
        $this->db->update(
            'users',
            array(
                'id' => $user->id()->get()
            ),
            array(
            'modified_user_id' => '0000',
            'deleted' => date('Y-m-d H:i:s')
            )
        );
    }

}
