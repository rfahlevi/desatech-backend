<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index()
    {
        //Get book
        $book = Book::latest()->paginate(5);

        //return collection of book as a resource
        return new BookResource(true, 'List Data Book', $book);
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'book_code' => 'required',
            'cover' => 'required|image|mimes:png,jpg,jpeg,gif|max:2048',
            'name' => 'required',
            'category' => 'required',
            'duration' => 'required',
            'stock' => 'required',

        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //Upload Cover
        $cover = $request->file('cover');
        $cover->storeAs('public/book-cover', $cover->hashName());

        //Create Book
        $book = Book::create([
            'book_code' => $request->book_code,
            'cover' => $cover->hashName(),
            'name' => $request->name,
            'category' => $request->category,
            'duration' => $request->duration,
            'stock' => $request->stock,
        ]);

        //Return Response
        return new BookResource(true, 'Data Buku berhasil ditambah', $book);
    }

    public function show(Book $book)
    {
        //Return single book as a resource
        return new BookResource(true, 'Data Buku ditemukan!', $book);
    }

    public function update(Request $request, Book $book)
    {
        //Define validation rules
        $validator = Validator::make($request->all(), [
            'book_code' => 'required',
            'cover' => 'required|image|mimes:png,jpg,jpeg,gif|max:2048',
            'name' => 'required',
            'category' => 'required',
            'duration' => 'required',
            'stock' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //Check if cover is not empty
        if ($request->hasFile('cover')) {

            //Upload new cover
            $cover = $request->file('cover');
            $cover->storeAs('public/book-cover', $cover->hashName());

            //Delete old Cover
            Storage::delete('public/book-cover/' . $book->cover);

            //Update book with new cover
            $book->update([
                'book_code' => $request->book_code,
                'cover' => $cover->hashName(),
                'name' => $request->name,
                'category' => $request->category,
                'duration' => $request->duration,
                'stock' => $request->stock,
            ]);
        } else {
            //Update book without new cover
            $book->update([
                'book_code' => $request->book_code,
                'name' => $request->name,
                'category' => $request->category,
                'duration' => $request->duration,
                'stock' => $request->stock,
            ]);
        }

        //Return Response
        return new BookResource(true, 'Data Buku berhasil diubah', $book);
    }

    public function destroy(Book $book)
    {
        //delete cover
        Storage::delete('public/book-cover/' . $book->cover);

        //delete book
        $book->delete();

        //return response
        return new BookResource(true, 'Data Buku berhasil dihapus', null);
    }
}
