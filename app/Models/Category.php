<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "image",
        "description"
    ];


    public function excerpt($title) {

        $new = substr($title, 0, 27);

        if (strlen($title) > 30) {
            return $new.'... See More';
        } else {
            return $title;
        }

    }

    //FORMATTING
    public function getPhotoOrDefaultUrl()
    {
        if (isset($this->image))
            return Storage::disk('categories')->url($this->image);
        else
            return asset('img/avatars/category.png');
    }


}
