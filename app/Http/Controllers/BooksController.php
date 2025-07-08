<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class BooksController extends Controller
{
    //creating a new book
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'user_id' => 'required',
            'status' => 'required',
            'book_name' => 'required',
            'author' => 'required',
            'cover' => 'mimes:jpg,jpeg,png,svg,webp|max:3000'
        ]);
        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('profile_pictures', 'public');
            $formFields['cover'] = $path;
        }
        Book::create($formFields);
        return back()->with('book', 'Book created succesfully');
    }

    //deleting a book by id
    public function destroy($id){
        $book=Book::destroy($id);
        return back()->with('book','Book deleted successfully');
    }

    //show edit page for a book
    public function edit($id){
        $book=Book::findOrFail($id);
        return view('logged.editBook', compact('book'));
    }

    //storing book after edits
public function update(Request $request, Book $book)
{
    $formFields = $request->validate([
        'user_id' => '',
        'status' => '',
        'book_name' => 'required',
        'author' => 'required',
        'cover' => 'nullable|mimes:jpg,jpeg,png,svg,webp|max:3000',
    ]);
    
    if ($request->hasFile('cover')) {
        $path = $request->file('cover')->store('profile_pictures', 'public');
        $formFields['cover'] = $path;
    }

    // dd($formFields);
    $book->update($formFields);

    return redirect('/index')->with('message', 'Book updated successfully');
}


}
