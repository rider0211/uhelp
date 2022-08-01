<?php

namespace Modules\Uhelpupdate\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class APIData extends Model
{
    use HasFactory;

    protected $table = 'envatoapitoken';

    protected $fillable = [
        'envatoapitoken'
    ];
    
    protected static function newFactory()
    {
        return \Modules\Uhelpupdate\Database\factories\APIDataFactory::new();
    }
}
