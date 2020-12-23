<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $hidden = [
        "created_at", "updated_at"
    ];

    protected $fillable = ['Title' , 'Image'];

    public function sub_category()
    {
        return $this->hasMany(SubCategory::class, "Parent");
    }

}
