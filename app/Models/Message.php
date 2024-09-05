<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [ 'customer_id', 'title', 'body'];

    public function customer()
    {
        return $this->belongsTo(Customer::class,"customer_id");
    }
}
