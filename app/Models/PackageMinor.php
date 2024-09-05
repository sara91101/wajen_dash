<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageMinor extends Model
{
    use HasFactory;

    protected $fillable = [ 'package_id', 'minor_id'];

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function minor()
    {
        return $this->belongsTo(Minor::class, 'minor_id');
    }

}
