<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $hidden = [
        "created_at", "updated_at" , "Parent"
    ];

    protected $fillable = ['Title' , 'Parent'];

}
