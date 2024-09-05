<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Minor extends Model
{
    use HasFactory;

    protected $fillable = [ 'minor_ar', 'minor_en', 'major_id'];

    public function major()
    {
        return $this->belongsTo(Major::class, 'major_id');
    }

    public function property()
    {
        return $this->hasMany(Property::class, 'minor_id');
    }
}
