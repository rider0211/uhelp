<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class VerifyUser extends Model
{
    use HasFactory;

    protected $guarded = [];
 
    public function user()
    {
        return $this->belongsTo(Customer::class, 'cust_id');
    }
}
