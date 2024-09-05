<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerUser extends Model
{
    use HasFactory;

    protected $fillable = [ 'customer_id', 'user_type_id', 'user_name', 'password'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function customerUserType()
    {
        return $this->belongsTo(CustomerUserType::class, 'user_type_id');
    }
}
