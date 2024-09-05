<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Systm extends Model
{
    use HasFactory;

    protected $fillable = [ 'system_name_ar', 'system_name_en', 'url', 'endPoint_url'];

    public function package()
    {
        return $this->hasMany(Package::class, 'systm_id');
    }

    public function customer()
    {
        return $this->hasMany(Customer::class, 'systm_id');
    }
}
