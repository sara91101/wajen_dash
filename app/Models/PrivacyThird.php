<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivacyThird extends Model
{
    use HasFactory;

    protected $fillable = [ "second_id","ar_third", "en_third"];

    public function second()
    {
        return $this->belongsTo(PrivacySecond::class, 'second_id');
    }
}
