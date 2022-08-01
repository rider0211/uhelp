<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupscategories extends Model
{
    use HasFactory;

    protected $table = 'groups_categories';


    public function groupsc()
    {
        return $this->belongsTo(Groups::class, 'group_id', 'id');
    }

    
   
}
