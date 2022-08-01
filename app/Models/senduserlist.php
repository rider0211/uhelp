<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class senduserlist extends Model
{
    use HasFactory;

    protected $fillable = [

        'mail_id',
        'touser_id',
        'tocust_id'
    ];

    public function touser(){

        return $this->belongsTo(User::class, 'touser_id', 'id');
    }
    public function tocust(){

        return $this->belongsTo(Customer::class, 'tocust_id', 'id');
    }
}
