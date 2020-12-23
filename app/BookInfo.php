<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookInfo extends Model
{
    public $table = "book_info";
    protected $hidden = [
        "created_at", "updated_at","BookID" , "CustomerID"
    ];

    public function translator()
    {
        return $this->belongsToMany(Translator::class, 'translator_to_book_info', 'BookInfoID', 'TranslatorID');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'CustomerID');
    }

}
