<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //un libro pertece a muchos autores
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
     
    //un libro puede tener muchos préstamos
    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
