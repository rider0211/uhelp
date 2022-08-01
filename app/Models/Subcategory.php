<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subcategorychild;

class Subcategory extends Model
{
    use HasFactory;
    protected $table = 'subcategorysd';

    protected $fillable = [

        'subcategoryname',
        'category_id',
        'status',


    ];


    public function subcategorysync()
    {
        return $this->belongsToMany(Subcategorychild::class,'subcategoryschild','subcategory_id','category_id');
    }


    public function subcategorylist()
    {
        return $this->hasMany(Subcategorychild::class,'subcategory_id');
    }
}
