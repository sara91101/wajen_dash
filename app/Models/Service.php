<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [ 'ar_service', 'en_service', 'price'];

    public function customerService()
    {
        return $this->hasMany(CustomerService::class, 'service_id');
    }
}
