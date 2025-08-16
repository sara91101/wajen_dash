<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [ 'package_ar', 'package_en', 'dash_id','price','is_archived','yearly_price','discount_percentage'];

    public function systm()
    {
        return $this->belongsTo(Systm::class, 'systm_id');
    }

    public function packageMinor()
    {
        return $this->hasMany(PackageMinor::class, 'package_id');
    }

    public function customerPackage()
    {
        return $this->hasMany(CustomerPackage::class, 'package_id');
    }
}
