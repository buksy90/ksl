<?php
namespace KSL\Models;

class User extends Base
{
    //
    // https://laravel.com/docs/5.3/eloquent
    //
    protected $table = 'users';

    public static function IdentifierExists($identifier)
    {
        $instance = new Static();
        $count = $instance
            ->where('identifier', '=', $instance->getConnection()->raw($identifier))
            ->count();
        
        return $count === 1;
    }

    public static function Register($identifier, $email, $firstName, $lastName, $avatar) {
        $user = new Static();
        $user->identifier       = $identifier;
        $user->email            = $email;
        $user->firstName        = $firstName;
        $user->lastName         = $lastName;
        $user->avatarUrl        = $avatar;

        return $user->save();
    }

    public function Login($identifier) {
        // \Hybrid_Auth::storage()->set('user', $identifier);
        $_SESSION['auth'] = $identifier;
    }

    public function Logout() {
        //\Hybrid_Auth::storage()->set('user', null);
        $_SESSION['auth'] = null;
    }
}