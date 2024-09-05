<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;

    protected $fillable = ['friend_first_name', 'friend_last_name', 'friend_phone', 'friend_email', 'subscriber_fullname', 'subscriber_business_name', 'subscriber_activity', 'subscriber_phone', 'subscriber_email', 'ip_address'];
}
