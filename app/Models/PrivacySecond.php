<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivacySecond extends Model
{
    use HasFactory;

    protected $fillable = [ "first_id","ar_second", "en_second"];

    public function first()
    {
        return $this->belongsTo(PrivacyFirst::class, 'first_id');
    }

    public function third()
    {
        return $this->hasMany(PrivacyThird::class, 'second_id');
    }
}
