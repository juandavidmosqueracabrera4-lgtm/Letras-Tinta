<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;

class LoanController extends Controller
{
    //lista todos los préstamos con sus usuarios y libros relacionados
    public function index()
    {
        $loans = Loan::with(['user', 'book'])->get();
        return response()->json($loans);
    }

    //registrar un nuevo préstamo
    public function store(Request $request)
    {
        $request->validable([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
            'loan_date' => 'required|date',
        ]);

        $loan = Loan::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'loan_date' => $request->loan_date,
            'status' => 'active',
        ]);

        return response()-json(['message' => 'préstamo registrado con éxito', 'loan' => $loan], 201);
    }
}
