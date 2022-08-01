<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class VerifyOtp extends Model
{
    use HasFactory;

    protected $guarded = [];


    protected $fillable = [

        'otp',
        'cust_id',
    ];

    public function userotp()
    {
        return $this->belongsTo(Customer::class, 'cust_id');
    }
}
