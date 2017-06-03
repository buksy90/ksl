<?php
namespace KSL\Models;

class UserPermissions extends Base
{
    protected $table = 'user_permissions';

    public static function HasPermission($user_id, $permission) {
        return ($permission === 'user')
            ? true
            : static::where('user_id', '=', $user_id)->where('permission', '=', $permission)->count() === 1;
    }
}