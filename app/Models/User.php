<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'branch_id',
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    //FOREIGN KEYS
    public function branch()
    {

        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function permissions()
    {

        return $this->belongsToMany(Permission::class, 'users_permissions');
    }

    //FORMATTING
    public function getPermissionsInSpacedKebabCaseAttribute()
    {
        $namesList = [];
        foreach ($this->permissions as $item) {

            array_push($namesList, __('fields.' . $item->key));
        }

        return implode(' - ', $namesList);
    }

    //HELPERS
    public function saveWithHash()
    {
        if (isset($this->beforeHashPassword))
            $this->password = Hash::make($this->beforeHashPassword);

        unset($this->beforeHashPassword);

        return $this->save();
    }

    public function has($pKey)
    {

        foreach ($this->permissions as $permission) {
            if ($permission->key == $pKey)
                return true;
        }

        return false;
    }
}
