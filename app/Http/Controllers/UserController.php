<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //shows main page for logged in user
    public function index(){
        $books = Book::where('user_id',Auth::id())->with('books')->get();
        return view('logged.index',compact('books'));
    }

    //storing user details in database 
    public function store(Request $request){
        $formFields= $request->validate([
            'name' => 'required',
            'email' => ['required', Rule::unique('users','email'),],
            'password' => ['required','confirmed', 'min:8'],
        ]);
        $formFields['password']= bcrypt($formFields['password']);
        $user= User::create($formFields);
        Auth::login($user);

        return redirect('/index')->with('message', 'Your account created succesfully');
    }

    //Log user in
    public function login(Request $request){
            $formFields= $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);
        if(Auth::attempt($formFields)){
            return redirect('/index')->with('message', 'You are logged in succesfully');
        }
        return back()->withErrors('Invalid credentials');
    }

    #Log user out
    public function logout(){
        Auth::logout();
        return redirect('/')->with('message', 'You are logged out succesfully');
    }
}
