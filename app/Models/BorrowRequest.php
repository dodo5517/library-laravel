<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowRequest extends Model
{
    use HasFactory;

    public $timestamps = false; // timestamps 비활성화


    protected $fillable = [
        'client_id',
        'book_id',
        'request_date',
        'status',
    ];
}
