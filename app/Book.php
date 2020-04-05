<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /**
     * Title corresponding to the name of the book
     * Unit corresponding to the amount of copies
     * @var array
     */
    protected $fillable = [
        'title', 'unit'
    ];
}
