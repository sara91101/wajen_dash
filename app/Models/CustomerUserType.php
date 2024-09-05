<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerUserType extends Model
{
    use HasFactory;

    protected $fillable = [ 'user_type_ar', 'user_type_en'];

    public function customerUser()
    {
        return $this->hasMany(CustomerUser::class, 'user_type_id');
    }
}
