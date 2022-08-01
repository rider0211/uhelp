<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialAuthSetting extends Model
{
    use HasFactory;

    protected $fillable =[
        'facebook_client_id',
        'facebook_secret_id',
        'facebook_status',
        'google_client_id',
        'google_secret_id',
        'google_status',
        'twitter_client_id',
        'twitter_secret_id',
        'twitter_status',
    ];
}
