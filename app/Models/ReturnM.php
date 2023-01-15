<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnM extends Model
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

    protected $table = 'returns';

    protected $guarded = [];

    public function books()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }
}
