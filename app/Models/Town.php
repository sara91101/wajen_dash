<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Town extends Model
{
    use HasFactory;

    protected $fillable = [
        'ar_town',
        'en_town'
    ];

    public function governorate()
    {
        return $this->hasMany(Governorate::class, 'town_id');
    }
}
