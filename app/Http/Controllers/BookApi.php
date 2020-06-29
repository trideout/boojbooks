<?php
namespace App\Http\Controllers;


use App\Book;
use Illuminate\Support\Facades\DB;

class BookApi extends Controller
{
    public function addBook(){
        $this->validate(request(), [
            'title' => 'required',
            'author' => 'required',
            'description' => 'string',
            'isbn' => 'required',
        ]);

        $lastSort = DB::table('books')->selectRaw('max(sort) as maxSort')->first();
        $book = Book::create([
            'title' => request('title'),
            'author' => request('author'),
            'description' => request('description', ''),
            'isbn' => request('isbn'),
            'sort' => $lastSort->maxSort + 1,
        ]);

        return [
            'created' => true,
            'book_id' => $book->id,
        ];
    }

    public function removeBook(){
        $this->validate(request(), [
            'book_id' => 'required|integer',
        ]);

        $book = Book::findOrFail(request('book_id'));
        $book->delete();

        return [
            'deleted' => true,
        ];
    }

    public function sortBooks(){
        $this->validate(request(), [
            'books' => 'required',
        ]);
        $i = 1;
        foreach(request('books') as $book){
            $book = Book::find($book);
            $book->sort = $i;
            $book->save();
            $i++;
        }
        return [
            'success' => true,
        ];
    }

    public function getBooks(){
        $books = Book::orderBy('sort')->get();
        return $books;
    }
}
