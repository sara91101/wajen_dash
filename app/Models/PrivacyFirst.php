<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivacyFirst extends Model
{
    use HasFactory;

    protected $fillable = [ "ar_first", "en_first"];

    public function second()
    {
        return $this->hasMany(PrivacySecond::class, 'first_id');
    }
}
