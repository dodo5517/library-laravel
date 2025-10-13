<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowedBook extends Model
{
    use HasFactory;
    
    public $timestamps = false; // timestamps 비활성화

    protected $fillable = [
        'client_id',
        'book_id',
        'borrow_date',
        'due_date',
        'returned_date',
    ];
}
