<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'company',
    ];

    //FORMATTING
    public function getPhotoOrDefaultUrlAttribute()
    {
        if (isset($this->photo))
            return Storage::disk('suppliers')->url($this->photo);
        else
            return asset('img/avatars/person.png');
    }

    public function getNameAndCompanyAttribute()
    {
        return $this->name . " ({$this->company})";
    }
}
