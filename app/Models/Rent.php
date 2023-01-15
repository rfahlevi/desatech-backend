<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;

    protected $fillable = [
        'rent_code',
        'book_id',
        'name',
        'email',
        'no_telp',
        'expired',
        'qty',
        'status'
    ];

    protected $guarded = [];

    public function books()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }
}
