<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IPLIST extends Model
{
    use HasFactory;

    protected $fillable = [

        'ip',
        'country',
        'entrytype',
        'types'
    ];
}
