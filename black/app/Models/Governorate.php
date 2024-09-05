<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{
    use HasFactory;

    protected $fillable = ['ar_governorate','en_governorate','town_id'];

    public function town()
    {
        return $this->belongsTo(Town::class, 'town_id');
    }

    public function customer()
    {
        return $this->hasMany(Customer::class, 'governorate_id');
    }
}
