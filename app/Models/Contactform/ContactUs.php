<?php

namespace App\Models\Contactform;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ContactUs extends Model
{
    use HasFactory;

    protected $table = "contactforms";
    protected  $fillable = [
        'name',
        'email',
        'phone_number',
        'subject',
        'message',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
