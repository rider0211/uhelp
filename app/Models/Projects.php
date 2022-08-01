<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Ticket\Category;
use App\Models\Projects_category;

class Projects extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $fillable = [

        'name'
    ];


    public function projectscategory()
    {
        return $this->belongsToMany(Projects_category::class,'projects_categories','projects_id','category_id');
    }

    
}
