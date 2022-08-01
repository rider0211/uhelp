<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Projects_category extends Pivot
{
    use HasFactory;

    protected $table = 'projects_categories';
    protected $fillable = [
        'category_id',
        'project_id'
    ];
}
