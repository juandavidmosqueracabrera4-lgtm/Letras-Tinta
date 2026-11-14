<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreLoanRequest;
use App\Http\Requests\UpdateLoanRequest;
use App\Models\Loan;
use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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

            DB::transaction(function () use ($request) {
                $book = Book::where('id', $request->book_id)->lockForUpdate()->firstOrFail();

                if ($book->available_copies <= 0) {
                    throw new Exception('No available copies for this book.');
                }

                $book->available_copies = $book->available_copies -1;
                $book->save();

                Loan::create([
                'user_id' => $request->user_id,
                'book_id' => $request->book_id,
                'loan_date' => $request->loan_date,
                'status' => 'active',
                ]);

            });

        // CORREGIDO EL MENSAJE DE RESPUESTA y SE AGREGA EL OBJETO LOAN A LA RESPUESTA
        return redirect()->route('loans.index')->with('success', 'Loan registered successfully');

        } catch (Exception $ex) {
           Log::error($ex);

           return redirect()->back()->withInput()->with('error', 'An error has occurred.');
        }
    }


    public function show($id)
    {
        $loan = Loan::with(['user', 'book'])->findOrFail($id);

        return view('loans.show', compact('loan'));
    }

    public function edit($id)
    {
        $loan = Loan::findOrFail($id);
        $users = User::all();
        $books = Book::all();
        return view('loans.edit', compact('loan', 'users', 'books'));
    }

   // Actualiza un prestamo aplicando las validaciones definidas en UpdateLoanRequest
    public function update(UpdateLoanRequest $request, $id)
    {
        try {

            DB::transaction(function () use ($request, $id) {

                $loan = Loan::where('id', $id)->lockForUpdate()->firstOrFail();

                $oldBook = Book::where('id', $loan->book_id)->lockForUpdate()->firstOrFail();

                if ($loan->status == 'returned' && $request->book_id != $loan->book_id) {
                    throw new Exception('Cannot change the book of a returned loan.');
                }

                if ($loan->status != 'returned' && $request->book_id != $loan->book_id) {

                    $newBook = Book::where('id', $request->book_id)->lockForUpdate()->firstOrFail();

                    if ($newBook->available_copies <= 0) {
                        throw new Exception('No available copies for the new book.');
                    }


                    $oldBook->available_copies = $oldBook->available_copies + 1;
                    $oldBook->save();

                    $newBook->available_copies = $newBook->available_copies - 1;
                    $newBook->save();
                }

                $loan->user_id = $request->user_id;
                $loan->book_id = $request->book_id;
                $loan->loan_date = $request->loan_date;

                $loan->save();

            });

            return redirect()->route('loans.index')
                ->with('success', 'Loan updated successfully');

        } catch (Exception $ex) {

            Log::error($ex);

            return redirect()->back()->withInput()->with('error', 'An error has occurred.');
        }
    }

    public function returnLoan($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $loan = Loan::where('id', $id)->lockForUpdate()->firstOrFail();

                if ($loan->status == 'returned') {
                    throw new Exception('This loan has already been returned.');
                }

                $book = Book::where('id', $loan->book_id)->lockForUpdate()->firstOrFail();
                $book->available_copies = $book->available_copies + 1;
                $book->save();

                $loan->status = 'returned';
                $loan->return_date = now()->toDateString();
                $loan->save();
            });

            return redirect()->route('loans.show', $id)
                ->with('success', 'Loan returned successfully');

        } catch (Exception $ex) {

            Log::error($ex);

            return redirect()->back()->withInput()->with('error', 'An error has occurred.');
        }
    }

    public function destroy($id)
    {
        try {

            DB::transaction(function () use ($id) {

                $loan = Loan::where('id', $id) ->lockForUpdate()->firstOrFail();

                if ($loan->status != 'returned') {

                    $book = Book::where('id', $loan->book_id)->lockForUpdate()->firstOrFail();

                    $book->available_copies = $book->available_copies + 1;
                    $book->save();
                }

                $loan->delete();

            });

            return redirect()->route('loans.index')->with('success', 'Loan deleted successfully');

        } catch (Exception $ex) {

            Log::error($ex);

            return redirect()->back()->with('error', 'An error has occurred.');
        }
    }
}
