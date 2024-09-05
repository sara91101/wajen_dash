<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'business_name', 'phone', 'email', 'city', 'branches_no', 'ip_address'];
}
