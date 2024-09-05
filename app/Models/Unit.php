<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'ar_name',
        'en_name',
        'description',
        'status',
        'abbreviation',
        'conversion_factor',
        'is_archived'
    ];
}
