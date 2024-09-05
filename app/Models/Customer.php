<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [ 'membership_no', 'first_name', 'second_name', 'bussiness_name', 'tax_no', 'phone', 'email', 'start_date', 'end_date', 'url', 'amount', 'taxes', 'taxes_type', 'discounts', 'discounts_type', 'final_amount', 'activity_id', 'systm_id', 'governorate_id'];

    public function systm()
    {
        return $this->belongsTo(Systm::class, 'systm_id');
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }

    public function governorate()
    {
        return $this->belongsTo(Governorate::class, 'governorate_id');
    }

    public function customerPackage()
    {
        return $this->hasMany(CustomerPackage::class, 'customer_id');
    }

    public function customerUser()
    {
        return $this->hasMany(CustomerUser::class, 'customer_id');
    }

    public function message()
    {
        return $this->hasMany(Message::class, 'customer_id');
    }
}
