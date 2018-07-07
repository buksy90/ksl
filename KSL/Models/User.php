<?php
namespace KSL\Models;

class User extends Base
{
    //
    // https://laravel.com/docs/5.3/eloquent
    //
    protected $table = TABLE_PREFIX . 'users';

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

        if(!$user->save())
            throw new \Exception('Nepodarilo sa zaregistrovat používateľa');
        
        return $user;
    }

    public static function IsLoggedIn() {
        return array_key_exists('auth', $_SESSION) && $_SESSION['auth'] !== null;
    }

    public static function GetUser() {
        return static::IsLoggedIn()
            ? static::where('identifier', '=', $_SESSION['auth'])->first()
            : null;
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