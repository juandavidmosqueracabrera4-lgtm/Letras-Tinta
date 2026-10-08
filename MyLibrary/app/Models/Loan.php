<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    //un préstamo pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    //un préstamo pertenece a un liblo en expecífico
    public function book()
    {
        return $this-belongsTo(Book::class);
    }
}
