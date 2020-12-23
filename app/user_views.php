<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class user_views extends Model
{
    protected $hidden = [
        "created_at", "updated_at"
    ];

    protected $fillable = [
        'UserID', 'BookID'
    ];
}
