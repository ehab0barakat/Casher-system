<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
    ];

    //FOREIGN KEYS
    public function users()
    {

        return $this->belongsToMany(User::class, 'users_permissions');
    }

    //STATIC
    public static function isIdsValid($selectedIdsList, $permissionsIdList)
    {
        foreach ($selectedIdsList as $id) {

            if (!($permissionsIdList->contains($id)))
                return false;
        }

        return true;
    }
}
