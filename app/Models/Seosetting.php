<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seosetting extends Model
{
    use HasFactory;

    protected $fillable = [

        'author',
        'description',
        'keywords',
    ];
}
