<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Stmt\TryCatch;

class Book extends Model
{
    protected $appends = ['ImageUrl', 'Colors', 'best_price', 'view_and_rate' , 'Rating'];
    public $table = "books";
    protected $hidden = [
        'Rate' , 'Image', "created_at", "updated_at", "PublisherID", "CatID" , "view_and_rate" , "Color"
    ];
    protected $fillable = ['BookID', 'Name', 'Image', 'Color', 'PublisherID', 'Year', 'CatID', 'Opt'];


    /* public function boook_info()
     {
         return $this->belongsTo(BookInfo::class, 'id');
     }*/

    public function bookInfo()
    {
        return $this->hasMany(BookInfo::class, "BookID");
    }

    public function story()
    {
        return $this->hasMany(BookInfo::class, "BookID");
    }

    public function author()
    {
        return $this->belongsToMany(Author::class, 'author_to_book', 'BookID', 'AuthorID');
    }

    public function publisher()
    {
        return $this->hasOne(Publisher::class, 'id', 'PublisherID');
    }

    public function category()
    {
        return $this->hasOne(SubCategory::class, 'id', 'CatID');
    }

    public function getImageUrlAttribute()
    {
        if ($this->Image == null || $this->Image == "")
            return "false";
        return "http://anarbuk.naeimsafaee.ir/images/books/" . $this->Image;
    }

    public function getBestPriceAttribute()
    {
        $BookID = $this->id;

        $prices = BookInfo::Where("BookID", $BookID)->get("Price");
        if (count($prices) == 0)
            return "-1";

        $min = $prices[0]["Price"];
        foreach ($prices as $price) {
            if ($price["Price"] < $min)
                $min = $price["Price"];
        }

        return $min;
    }

    public function getColorsAttribute()
    {
        $light_color = $this->Color;
        $dark_color = darker_color($this->Color , 0.8);

        return [$light_color , $dark_color];
    }

    public function getRatingAttribute()
    {
        $rate = $this->Rate;

        return round($rate , 1) . "";
    }

    public function getViewAndRateAttribute()
    {
        return ($this->View == 0 ? 1 : $this->View) * ($this->Rate == 0 ? 1 : $this->Rate);
    }

}
