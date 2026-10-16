<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{

    use HasFactory;

    protected $fillable = ['title', 'isbn', 'status', 'available_copies'];

    //Relación muchos a muchos con autores
    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_authors');
    }

    //Relación muchos a muchos con categorías
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_categories');
    }
     
    //un libro puede tener muchos préstamos
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
