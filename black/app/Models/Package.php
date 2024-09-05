<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [ 'package_ar', 'package_en', 'systm_id','price'];

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