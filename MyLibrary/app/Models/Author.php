<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    //un autor tiene muchos libros
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
