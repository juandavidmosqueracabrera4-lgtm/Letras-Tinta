<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
   // AGREGADO PARA QUE Loan::create DEL CONTROLADOR PUEDA GUARDAR LOS CAMPOS
    protected $fillable = [
        'user_id',
        'book_id',
        'loan_date',
        'status',
    ];

    //un préstamo pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //un préstamo pertenece a un libro en específico
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
