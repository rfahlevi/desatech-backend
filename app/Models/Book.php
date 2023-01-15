<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_code',
        'cover',
        'name',
        'category',
        'duration',
        'stock',
    ];

    protected $guarded = [];

    public function rents()
    {
        return $this->hasMany(Rent::class, 'id', 'book_id');
    }

    public function returns()
    {
        return $this->hasMany(ReturnM::class, 'id', 'book_id');
    }
}
