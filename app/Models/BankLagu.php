<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankLagu extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'genre', 'year', 'country', 'artist', 'filename', 'path', 'source'];
}
