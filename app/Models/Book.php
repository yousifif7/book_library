<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    //
    protected $fillable=[
        'user_id','book_name','author','cover','status'
    ];

    public function books(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
