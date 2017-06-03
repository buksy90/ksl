<?php
namespace KSL\Controllers;

class BaseAdmin extends Base
{
    public function __construct() {
        $user       = \KSL\Models\User::GetUser();
        $user_id    = $user ? $user->id : null;

        if(\KSL\Models\UserPermissions::hasPermission($user_id, 'admin') === false) {
            die('Nemáte oprávnenie na prístup k nasledujúcej stránke.');
        }

        return call_user_func_array(array('parent', '__construct'), func_get_args());
    }
}