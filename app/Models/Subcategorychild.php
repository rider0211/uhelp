<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket\Category;

class Subcategorychild extends Model
{
    use HasFactory;

    protected $table = 'subcategoryschild';

    public function subcatlists()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id', 'id');
    }

    public function subcatlistss()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
