<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    protected $hidden = [
        "created_at", "updated_at"
    ];

    protected $fillable = ["Name"];

}
