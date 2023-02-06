<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersPermissions extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'permission_id',
    ];

    //STATIC
    public static function createPermissions($userId, $permissionsList)
    {
        foreach ($permissionsList as $pId) {

            UsersPermissions::create([
                'user_id' => $userId,
                'permission_id' => $pId,
            ]);
        }
    }

    public static function overwrite($user, $newPermissionsList)
    {
        foreach ($user->permissions->pluck('id') as $pId) {

            if (!in_array($pId, $newPermissionsList)) {
                self::where([
                    ['user_id', '=', $user->id],
                    ['permission_id', '=', $pId],
                ])->delete();
            }

            $newPermissionsList = array_diff($newPermissionsList, [$pId]);
        }

        if (count($newPermissionsList) > 0) {

            foreach ($newPermissionsList as $pId) {
                self::create([
                    'user_id' => $user->id,
                    'permission_id' => $pId,
                ]);
            }
        }
    }
}
