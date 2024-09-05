<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [ 'property_ar', 'property_en', 'minor_id'];

    public function minor()
    {
        return $this->belongsTo(Minor::class, 'minor_id');
    }

    public function operation()
    {
        return $this->hasMany(Operation::class, 'property_id');
    }
}
