<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = ["phone","email","message","ip_address"];

    public function reply()
    {
        return $this->hasMany(InquiryReply::class,"inquiry_id");
    }
}
