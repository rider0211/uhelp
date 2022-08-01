<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Groups;

class Groupsusers extends Model
{
    use HasFactory;

    public  $table = 'groups_users';

    protected $fillable = [
        'groups_id',
        'users_id'
    ];

    


}
