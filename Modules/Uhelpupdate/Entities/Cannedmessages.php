<?php

namespace Modules\Uhelpupdate\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cannedmessages extends Model
{
    use HasFactory;

    protected $table = 'cannedmessages';

    protected $fillable = [
        'title',
        'messages',
        'status',
    ];
    
    protected static function newFactory()
    {
        return \Modules\Uhelpupdate\Database\factories\CannedmessagesFactory::new();
    }
}
