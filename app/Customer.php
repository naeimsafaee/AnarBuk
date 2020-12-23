<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $hidden = [
        "created_at", "updated_at" , "Password"
    ];
}
