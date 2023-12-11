<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    use HasFactory;
    protected $fillable = [
        'isbn',
        'name',
        'year',
        'page',
    ];

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_authors')
            ->using(BookAuthor::class);
    }
}
