<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Main extends Model
{
    protected $fillable=['type','name','user_id'];

    protected $hidden=['created_at','updated_at'];

    public function user()
    {
        return $this->belongsToMany(User::class, 'user_to_mains', 'main_id', 'user_id');
    }

//        return $this->belongsTo(User::class,'user_id');    one to many
//        return User::find($this->user_id);

}
