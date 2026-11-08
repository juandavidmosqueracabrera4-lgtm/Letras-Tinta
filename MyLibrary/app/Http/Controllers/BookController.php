<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreBookRequest;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;

// AGREGADO PARA LAS VALIDACIONES Y EL MANEJO DE ERRORES
use Exception;//agregado para el manejo de excepciones con el try catch
use Illuminate\Support\Facades\Log;//agregado para el manejo de logs, registra los errores en el archivo
use Illuminate\Support\Facades\Session;//agregado para el manejo de sesiones y mensajes temporales a los usuarios
use Illuminate\Validation\Rule; //agregado para

class BookController extends Controller
{
    // Mostrar el catálogo de libros
    public function index()
    {
        $books = Book::with(['authors', 'categories'])->get();
         return view('books.index', compact('books'));
    }

    // Método para retornar la vista del formulario con la lista de autores
     public function create()
    {
        $authors = \App\Models\Author::all(); // Trae los autores para el menú desplegable
        $categories = \App\Models\Category::all(); // Trae las categorías para el menú desplegable
        return view('books.create', compact('authors', 'categories')); // Abre resources/views/books/create.blade.php
    }

    // Mostrar el formulario para editar un libro
    public function edit($id)
    {
        try {
            $book = Book::with(['authors', 'categories'])->findOrFail($id);
            $authors = Author::all();
            $categories = Category::all();

            return view('books.edit', compact('book', 'authors', 'categories'));
        } catch (Exception $ex) {
            Log::error($ex);
            Session::flash('message', ['content' => 'An error has occurred.','type' => 'error']);
            return redirect()->back();
        }
    }
    

    public function update(Request $request, $id){
        $book= Book::FindOrFail($id);
        //Validaciones
        $request->validate([
            'title'=> 'required|string|max:255',
            'author_ids'=>'required|array|min:1',
            'author_ids.*'=>'integer|exists:authors,id',
            'category_ids'=>'nullable|array',
            'category_ids.*'=>'integer|exists:categories,id',
            'isbn'=>[ 
                'required',
                'string', 
                Rule::unique('books','isbn')->ignore($book->id),],
             'available_copies'=>'required|integer|min:0',
        ]);
    try {
        $book->update([
            'title'=>$request->title,
            'isbn'=>$request->isbn,
            'available_copies'=>$request->available_copies,
        ]);

    //Actualizar autores y categorias
    $book->authors()->sync($request->author_ids);
    $book->categories()->sync($request->category_ids ?? []);

    Session::flash('message', ['content'
    =>'Book updated successfully.','type'=>'success']);

    return 
    redirect()->route('books.index');
    
    }catch (Exception $ex) {
        Log::error($ex);
        Session::flash('message', ['content' => 'An error has occurred.','type' => 'error']);
        return redirect()->back();
    }

        }

    //guardar un nuevo libro y lo asocia con las tablas intermedias
    public function store(StoreBookRequest $request)
    {

        // AGREGA EL MANEJO DE ERRORES CON Log::error, CON LA VALIDACION YA HECHA EN StoreBookRequest
        try {

         // Crea el libro con los campos validados basicos ya importados
             $book = Book::create([
             'title' => $request->title,
             'isbn' => $request->isbn,
             'available_copies' => $request->available_copies,
            // Estado por defecto según el diagrama del profesor
             'status' => 'available'
        ]);

        // Asocia los múltiples IDs de autores en la tabla pivote intermedia
        if ($request->has('author_ids')) {
            $book->authors()->attach($request->author_ids);
        }

        if ($request->filled('category_ids')) {
           $book->categories()->attach($request->category_ids);
        }

        return redirect()->route('books.index')->with('success', 'Book registered successfully.');

        // SI ALGO FALLA SE REGISTRA EN EL LOG Y SE AVISA CON session
        } catch (Exception $ex) {
            Log::error($ex);
            Session::flash('message', ['content' => 'An error has occurred.', 'type' => 'error']);
            return redirect()->back();
        }
    }

       //metodo para eliminar un libro y limpiar sus relaciones muchos a muchos
    public function destroy($id)
    {
        //AGREGADO EL TRY CATCH PARA LAS VALIDACIONES Y EL MANEJO DE ERRORES CON Log Y session
        try {
            // 1. buscar un libro por su id o arrojar un error 404 si no existe
            $book = Book::findOrFail($id);

            // 2. Desvincular de forma manual sus autores y categorías en las tablas pivote
            // Esto limpia de inmediato las tablas 'book_authors' y 'book_categories'
            $book->authors()->detach();
            $book->categories()->detach();

            // 3. Eliminar el registro físico del libro en la tabla 'books'
            $book->delete();

            // 4. Retornar una respuesta de eliminacion exitosa para el frontend
            return redirect()->back()->with('success',
             'El libro fue eliminado correctamente y se limpiaron sus relaciones del sistema.');

        } catch (Exception $ex) {
            Log::error($ex);
            Session::flash('message', [
                'content' => 'An error has occurred.',
                'type' => 'error'
            ]);
            return redirect()->back();
        }
    }

}
