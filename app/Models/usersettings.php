<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class usersettings extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket-refresh',
        'users_id',
        'happyrating',
        'unhappyrating',
    ];

    public function users(){

        return $this->hasOne(User::class, 'users_id','id');
    }
    
}
