<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Ticket\Ticket;
use App\Models\User;
use App\Models\Articles\Article;


class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'guard_name'
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function ticket()
    {
    return $this->belongsTo(Ticket::class);
    }

    public function article()
    {
        return $this->hasMany(Article::class);
    }
}
