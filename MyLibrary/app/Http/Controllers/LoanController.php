<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreLoanRequest;
use App\Models\Loan;
// AGREGA LA IMPORTACION DEL MANEJO DE ERRORES
use Exception;
use Illuminate\Support\Facades\Log;

class LoanController extends Controller
{
    //lista todos los prestamos con sus usuarios y libros relacionados
    public function index()
    {
        $loans = Loan::with(['user', 'book'])->get();
        return view('loans.index', compact('loans'));
    }
    public function create()
    {
        $users = \App\Models\User::all();
        $books = \App\Models\Book::all();

        return view('loans.create', compact('users', 'books'));
    }
    //registrar un nuevo préstamo
    public function store(StoreLoanRequest $request)
    {


        // AGREGADO EL MANEJO DE ERRORES TRY/CATCH CON Log::error Y LA VALIDACION QUEDA FUERA DEE TRY
        try {
            $loan = Loan::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'loan_date' => $request->loan_date,
            'status' => 'active',
        ]);

        // CORREGIDO EL MENSAJE DE RESPUESTA y SE AGREGA EL OBJETO LOAN A LA RESPUESTA
        return redirect()->route('loans.index')->with('success', 'Loan registered successfully');
        } catch (Exception $ex) {
           Log::error($ex);

           return redirect()->back()->with('error', 'An error has occurred.');
        }
    }


    public function show($id)
    {
        $loan = Loan::with(['user', 'book'])->findOrFail($id);

        return view('loans.show', compact('loan'));
    }
}
