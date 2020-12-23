<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $hidden = [
        'created_at',"updated_at" ,"pivot"
    ];

    protected $fillable = ["Name"];

}
