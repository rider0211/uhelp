<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Groupsusers;

class Groups extends Model
{
    use HasFactory;

    protected $table = 'groups';

    protected $fillable = ['groupname'];

    public function groupsusers()
    {
        return $this->belongsToMany(Groupsusers::class,'groups_users','groups_id','users_id');
    }

    public function groupsuser()
    {
        return $this->hasMany(Groupsusers::class, 'groups_id');
    }
}
