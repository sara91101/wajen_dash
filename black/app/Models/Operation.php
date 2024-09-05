<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    use HasFactory;

    protected $fillable = [ 'operation_ar', 'operation_en', 'property_id'];

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }
}
