<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InquiryReply extends Model
{
    use HasFactory;

    protected $fillable = ["user_id","inquiry_id","reply"];

    public function user()
    {
        return $this->belongsTo(User::class,"user_id");
    }

    public function inquiry()
    {
        return $this->belongsTo(Inquiry::class,"inquiry_id");
    }
}
