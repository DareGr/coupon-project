<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Coupon;

class UsedCoupon extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = []; 

    public function coupon()
    {
        return $this->hasOne(Coupon::class, 'id', 'coupon_num');
    }

    public function pattern()
    {
        return $this->hasOne(CouponPattern::class, 'id', 'coupon_pattern');
    }
}
