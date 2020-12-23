<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Translator extends Model
{
    protected $hidden = [
        'created_at',"updated_at" ,"pivot"
    ];

}
