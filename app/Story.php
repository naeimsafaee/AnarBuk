<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    protected $hidden = [
        'updated_at',"Status",
    ];

    public function book()
    {
        return $this->belongsTo(Book::class , "BookID");
    }
//        return Book::select("id" , "Image")->where("id" , $this->BookID)->get();

}
