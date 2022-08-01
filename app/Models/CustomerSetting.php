<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerSetting extends Model
{
    use HasFactory;

    protected $table = 'customer_settings';

    protected $fillable = [
        'custs_id',
        'notify',

    ];
}
