<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class callaction extends Model
{
    use HasFactory;

    protected $fillable = [
        
        'callcheck',
        'title',
        'subtitle',
        'buttonname',
        'buttonurl',
        'image',
    ];
}
