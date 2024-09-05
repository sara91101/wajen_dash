<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en', 'name_ar', 'logo', 'bill', 'phone', 'email', 'address_ar', 'address_en'
    ];
}
