<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    use HasFactory;

    protected $table = 'pages';

    protected $fillable = [
        
        'pagename',
        'pagedescription',
        'pageslug',
        'viewonpages',
        'status',
       
    ];

}
