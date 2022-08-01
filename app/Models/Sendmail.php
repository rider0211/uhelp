<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\senduserlist;

class Sendmail extends Model
{
    use HasFactory;

    protected $fillable = [

        'user_id',
        'mailsubject',
        'mailtext',
        
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function users(){

        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function touser(){
        return $this->hasMany(senduserlist::class, 'mail_id', 'id');
    }
}
