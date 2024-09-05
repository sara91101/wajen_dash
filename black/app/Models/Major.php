<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    use HasFactory;

    protected $fillable = [ 'major_ar', 'major_en', 'systm_id'];

    public function systm()
    {
        return $this->belongsTo(Systm::class, 'systm_id');
    }

    public function minor()
    {
        return $this->hasMany(Minor::class, 'major_id');
    }
}
