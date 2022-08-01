<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket\Category;
use App\Models\Ticket\Ticket;

class CategoryUser extends Model
{
    use HasFactory;

    protected $table = 'category_category_user';

    protected $fillable = [

        'category_user_id',

    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function tickets()
    {
        return $this->belongTo(Ticket::class, 'category_id');
    }

}
